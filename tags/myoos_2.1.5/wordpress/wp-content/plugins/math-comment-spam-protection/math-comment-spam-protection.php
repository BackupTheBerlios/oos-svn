<?php
/*
Plugin Name: Math Comment Spam Protection
Plugin URI: http://sw-guide.de/wordpress/plugins/math-comment-spam-protection/
Description: Asks the visitor making the comment to answer a simple math question. This is intended to prove that the visitor is a human being and not a spam robot. Example of such question: <em>What is the sum of 2 and 9?</em>
Version: 2.2
Author: Michael Woehrer
Author URI: http://sw-guide.de/
*/

/*	----------------------------------------------------------------------------
 	    ____________________________________________________
       |                                                    |
       |           Math Comment Spam Protection             |
       |                © Michael Woehrer                   |
       |____________________________________________________|

	© Copyright 2006-2007 Michael Woehrer (michael dot woehrer at gmail dot com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

	----------------------------------------------------------------------------

	ACKNOWLEDGEMENTS:
	- Thanks to Steven Herod (http://www.herod.net/) for his plugin
	  "Did You Pass Math?". I took his idea and extended/improved it by
	  writing a plugin on my own. 

	----------------------------------------------------------------------------

	INSTALLATION, USAGE:
	Visit the plugin's homepage.

	----------------------------------------------------------------------------
	
*/


# Determine installation path: will be under wp-content/plugins or under a subdir of /plugins/
$mcsp_info['install_dir'] = ABSPATH . 'wp-content/plugins';
if ( basename(dirname(__FILE__)) != 'plugins' ) $mcsp_info['install_dir'] .= '/' . basename(dirname(__FILE__));


# Include the class and create object
if ( !class_exists('MathCheck') )
	include_once($mcsp_info['install_dir'] . '/math-comment-spam-protection.classes.php');
$mcsp_MathCheckObj = new MathCheck; 

# Get settings
$mcsp_opt = get_option('plugin_mathcommentspamprotection');


/*******************************************************************************
 * Let's use wp_nonce to secure the forms. 
 * Source: http://michaeldaw.org/papers/securing_wp_plugins/
 * Code is being implemented at different locations, always commented as "### SECURING FORMS ###"
 ******************************************************************************/
	if ( !function_exists('wp_nonce_field') ) {
	        function mcsp_nonce_field($action = -1) { return; }
	        $mcsp_nonce = -1;
	} else {
	        function mcsp_nonce_field($action = -1) { return wp_nonce_field($action); }
	        $mcsp_nonce = 'mcsp-update-key';
	}



/*******************************************************************************
 * Generate math question
 ******************************************************************************/
function math_comment_spam_protection() {

	global $mcsp_MathCheckObj, $mcsp_opt;

	// Set class options
	$mcsp_MathCheckObj->opt['input_numbers'] = $mcsp_opt['mcsp_opt_numbers'];

	// Generate numbers to be displayed and result
	$mcsp_MathCheckObj->GenerateValues();

	$mcsp_info['operand1'] = $mcsp_MathCheckObj->info['operand1'];
	$mcsp_info['operand2'] = $mcsp_MathCheckObj->info['operand2'];
	$mcsp_info['result']   = $mcsp_MathCheckObj->info['result'];
	
	return $mcsp_info;

}


/*******************************************************************************
 * Input validation. 
 ******************************************************************************/
function mcsp_check_input($comment_data) {

	global $mcsp_MathCheckObj, $user_ID, $mcsp_opt;


    if (  ( !isset($user_ID) ) && ( $comment_data['comment_type'] == '' ) ) { // Do not check if the user is registered & do not check trackbacks/pingbacks
	
		// Get actual result
		$actual_result = $_POST[ $mcsp_opt['mcsp_opt_fieldname_mathresult'] ];
		// Get value user has entered
		$value_entered = $_POST[ $mcsp_opt['mcsp_opt_fieldname_useranswer'] ];

		// Get input validation result
		$result = $mcsp_MathCheckObj->InputValidation($actual_result, $value_entered);

		// DIE if there was an error. Apply filter for security reasons (strip JS code, etc.)
		switch ($result) {
			case 'No answer': 
				mcsp_aux_die( apply_filters('pre_comment_content', stripslashes($mcsp_opt['mcsp_opt_msg_no_answer'])) );
				break;
			case 'Wrong answer': 
				mcsp_aux_die( apply_filters('pre_comment_content', stripslashes($mcsp_opt['mcsp_opt_msg_wrong_answer'])) );
				break;
		}

	}

	return $comment_data;

}



/*******************************************************************************
 * Apply plugin
 ******************************************************************************/
add_filter('preprocess_comment', 'mcsp_check_input', 0);



##################################################################################################################################

/*******************************************************************************
 * Admin
*******************************************************************************/

// Add admin menu
function mcsp_add_options_to_admin() {
    if (function_exists('add_options_page')) {
		add_options_page('Math Comment Spam', 'Math Comment Spam', 8, basename(__FILE__), 'mcsp_options_subpanel');
    }
}

// This will add the new item, 'Math Comment Spam', to the Options menu.
function mcsp_options_subpanel() {

	/* Lets add some default options if they don't exist
			If an option with the specified name already exists, no changes are made to its value
			or to the database as a whole. add_option() can only add options, not alter them.*/

	$tmp_noanswer =	'<p align="center">
<strong>Error:</strong> Please press the back button and fill the required field for spam protection.
</p>';
	$tmp_wronganswer = '<p align="center">
<strong>Error:</strong> You have entered the wrong sum in the spam protection field.
<br />Press the back button and try again.
</p>';
	$optionarray_def = array(
		'mcsp_opt_numbers'				=> '1~1, 2~2, 3~3, 4~4, 5~5, 6~6, 7~7, 8~8, 9~9, 10~10',
		'mcsp_opt_msg_no_answer' 		=> $tmp_noanswer,
		'mcsp_opt_msg_wrong_answer' 	=> $tmp_wronganswer,
		'mcsp_opt_fieldname_useranswer' => 'mcspvalue',
		'mcsp_opt_fieldname_mathresult' => 'mcspinfo',
		);
	add_option('plugin_mathcommentspamprotection', $optionarray_def, 'Math Comment Spam Protection Plugin Options');

	/* Check form submission and update options if no error occurred */
	if (isset($_POST['submit']) ) {
		### SECURING FORMS ###
			if ( function_exists('current_user_can') && !current_user_can('manage_options') )
      			die(__('Cheatin&#8217; uh?'));
			check_admin_referer( $mcsp_nonce );
		### SECURING FORMS ###

		$optionarray_update = array (
			'mcsp_opt_numbers' 				=> mcsp_aux_numbers_input_formatting($_POST['mcsp_opt_numbers']),
			'mcsp_opt_msg_no_answer'		=> $_POST['mcsp_opt_msg_no_answer'],
			'mcsp_opt_msg_wrong_answer' 	=> $_POST['mcsp_opt_msg_wrong_answer'],
			'mcsp_opt_fieldname_useranswer' => mcsp_aux_fieldname_formatting($_POST['mcsp_opt_fieldname_useranswer']),
			'mcsp_opt_fieldname_mathresult' => mcsp_aux_fieldname_formatting($_POST['mcsp_opt_fieldname_mathresult'])
		);
		update_option('plugin_mathcommentspamprotection', $optionarray_update);

	}

	/* Get options */
	$optionarray_def = get_option('plugin_mathcommentspamprotection');

	
?>

<!-- ############################## BEGIN: ADMIN OPTIONS ################### -->
<div class="wrap">

	<h2>Math Comment Spam Protection Options</h2>
	<p>For details, visit the <a title="Math Comment Spam Protection Plugin" href="http://sw-guide.de/wordpress/plugins/math-comment-spam-protection/">plugin's homepage</a>.

	<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?page=' . basename(__FILE__); ?>&updated=true">
	<?php 
		### SECURING FORMS ###
		mcsp_nonce_field($mcsp_nonce);
		### SECURING FORMS ###
	 ?> 

	<div class="submit">
		<input type="submit" name="submit" value="<?php _e('Update Options') ?> &raquo;" />
	</div>

	<!-- ****************** Operands ****************** -->
	<fieldset class="options">
		<legend>Used Operands</legend>
		<p style="margin-left: 25px; color: #555; font-size: .85em;">
			Enter the numbers to be used. Use the number on the left side, tilde (~) as separator and then the term to display.
			Separate values with comma (,).
			<br />Examples: 
			<br />&nbsp;-&nbsp;<em>1~one, 2~two, 3~three, 4~four, 5~five, 6~six, 7~seven, 8~eight, 9~nine, 10~ten</em>
			<br />&nbsp;-&nbsp;<em>1~1, 2~2, 3~3, 4~4, 5~5, 6~6, 7~7, 8~8, 9~9, 10~10</em>
		</p>
		<textarea style="margin-left: 25px" name="mcsp_opt_numbers" id="mcsp_opt_numbers" cols="100%" rows="2"><?php 
			echo htmlspecialchars(stripslashes(mcsp_aux_numbers_input_formatting($optionarray_def['mcsp_opt_numbers'])));
		?></textarea>
	</fieldset>

	<!-- ****************** Field Names ****************** -->
	<fieldset class="options">
		<legend>Field Names</legend>
		<p style="margin-left: 25px; color: #555; font-size: .85em;">
			<label for="mcsp_opt_fieldname_useranswer">Name of field for user's answer:</label>
			<br /><input name="mcsp_opt_fieldname_useranswer" type="text" id="mcsp_opt_fieldname_useranswer" value="<?php echo $optionarray_def['mcsp_opt_fieldname_useranswer']; ?>" size="30" />
			<br />
			<label for="mcsp_opt_fieldname_mathresult">Name of hidden field that contains the hash:</label>
			<br /><input name="mcsp_opt_fieldname_mathresult" type="text" id="mcsp_opt_fieldname_mathresult" value="<?php echo $optionarray_def['mcsp_opt_fieldname_mathresult']; ?>" size="30" />
		</p>
	</fieldset>




	<!-- ****************** Error Messages ****************** -->
	<fieldset class="options">
		<legend>Error Messages</legend>

		<!-- No Answer -->
		<p style="margin-left: 25px; color: #555; font-size: .85em;">
			Error message being displayed in case of no answer (empty field) / not entered a number:
		</p>
		<textarea style="margin-left: 25px" name="mcsp_opt_msg_no_answer" id="mcsp_opt_msg_no_answer" cols="100%" rows="3"><?php 
			echo htmlspecialchars(stripslashes($optionarray_def['mcsp_opt_msg_no_answer']));
		?></textarea>

		<!-- Wrong Answer -->
		<p style="margin-left: 25px; color: #555; font-size: .85em;">
			Error message being displayed in case of a wrong answer:
		</p>
		<textarea style="margin-left: 25px" name="mcsp_opt_msg_wrong_answer" id="mcsp_opt_msg_wrong_answer" cols="100%" rows="3"><?php 
			echo htmlspecialchars(stripslashes($optionarray_def['mcsp_opt_msg_wrong_answer']));
		?></textarea>

	</fieldset>




	<div class="submit">
		<input type="submit" name="submit" value="<?php _e('Update Options') ?> &raquo;" />
	</div>

	</form>

	<p style="text-align: center; font-size: .85em;">&copy; Copyright 2006-2007&nbsp;&nbsp;<a href="http://sw-guide.de">Michael W&ouml;hrer</a></p>

</div> <!-- [wrap] -->
<!-- ############################## END: ADMIN OPTIONS ##################### -->


<?php


} // function mcsp_options_subpanel


function mcsp_aux_numbers_input_formatting($input) {
	// Formats the input of the numbers...
	$result = str_replace(' ', '', $input);	// Strip whitespace
	$result = preg_replace('/,/', ', ', $result); // Add whitespace after comma
	$result = preg_replace('/(\r\n|\n|\r)/', '', $result); // Strip line breaks
	return $result;
}

function mcsp_aux_fieldname_formatting($input) {

	// Clean the input values for the field names...
	$return = preg_replace('/[^a-zA-Z0-9_\-]/', '', $input);
	
	return $return;

}


function mcsp_aux_die($message) {

		// wp_die() exists in Wordpress 2.x only. Displays a nicer output incl. WP logo.
		if ( function_exists('wp_die') ) {
			wp_die($message);
		} else {
			die($message);
		}

}

/* =============================================================================
   Apply the admin menu
============================================================================= */

add_action('admin_menu', 'mcsp_add_options_to_admin');

?>