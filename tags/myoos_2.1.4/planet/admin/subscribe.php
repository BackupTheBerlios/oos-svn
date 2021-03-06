<?php
/**
 * @todo Move to admin/login.php
 * @author Ryan McCue <cubegames@gmail.com>
 * @package Lilina
 * @version 1.0
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once('admin.php');

class SubscribePage {

	public static function run() {
		if(isset($_GET['test']))
			return self::success_page('xyz');
		if(isset($_GET['test2']))
			return self::sub_page('FAIL');
		if(empty($_POST['url']))
			return self::sub_page();

		try {
			$_GET['url'] = $_POST['url'];
			$result = Feeds::get_instance()->add( $_POST['url'], $_POST['name'] );
		}
		catch( Exception $e ) {
			return self::sub_page($e->getMessage());
		}
		return self::success_page($result);
	}

	public static function success_page($result) {
		self::head();
?>
	<div id="message">
		<h1><?php _e('Success!'); ?></h1>
		<p class="sidenote"><?php _e('Closing window in...') ?></p>
		<p class="sidenote" id="counter">3</p>
	</div>
	<script>
		$(document).ready(function () {
			setInterval(countdown, 1000);
		});

		function countdown() {
			if(timer > 0) {
				$('#counter').text(timer);
				timer--;
			}
			else {
				self.close();
			}
		}

		var timer = 2;
	</script>
<?php
		self::foot();
	}

	public static function sub_page($error = '') {
		if(!empty($_GET['url']))
			$url = htmlspecialchars($_GET['url']);
		else
			$url = '';
		self::head();
?>
	<div id="main">
		<h1><?php _e('Add Feed'); ?></h1>
		<p id="backlink"><a href="<?php echo get_option('baseurl'); ?>"><?php echo sprintf(_r('Back to %s.'), get_option('sitename')); ?></a></p>
<?php
		if(!empty($error)) {
?>
		<div id="error">
			<p><?php echo sprintf(_r('Whoops, looks like an error occurred while processing. %s'), $error); ?></p>
		</div>
<?php
		}
?>
		<form action="subscribe.php" method="post" id="add_form"<?php if(!empty($error)) echo ' class="errorform"' ?>>
			<fieldset id="add">
				<p>
					<label for="name"><?php _e('Name'); ?>:</label>
					<input type="text" name="name" id="name" class="input input_small" />
				</p>
				<p class="sidenote"><?php _e('If no name is specified, it will be taken from the feed'); ?></p>

				<p>
					<label for="url"><?php _e('Feed address (URL)'); ?>:</label>
					<input type="text" name="url" id="url" value="<?php if(!empty($url)) echo $url; ?>" class="input input_small" />
				</p>
				<p class="sidenote"><?php _e('Example'); ?>: http://feeds.feedburner.com/lilina-news, http://getlilina.org</p>

				<input type="hidden" name="action" value="add" />
				<input type="submit" value="<?php _e('Add Feed'); ?>" class="submit" />
			</fieldset>
		</form>
	</div>
<?php
		self::foot();
	} // function sub_main()

	public static function head() {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php _e('Subscribe') ?> &mdash; <?php echo get_option('sitename'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo get_option('baseurl'); ?>admin/resources/core.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="<?php echo get_option('baseurl'); ?>admin/resources/mini.css" media="screen"/>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="<?php echo get_option('baseurl'); ?>inc/js/jquery.js"></script>
</head>
<body id="admin-subscribe" class="admin-page">
<?php
	} // function head()

	public static function foot() {
?>
</body>
</html>
<?php
	}
} // class SubscribePage

SubscribePage::run();