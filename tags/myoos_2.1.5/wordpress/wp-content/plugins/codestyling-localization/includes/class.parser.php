<?php

if (!defined('T_ML_COMMENT'))
	    define('T_ML_COMMENT', T_COMMENT);
else
	    define('T_DOC_COMMENT', T_ML_COMMENT);

class csp_l10n_parser {
	
	function csp_l10n_parser($basedir, $textdomain, $do_gettext = true, $do_domains=false) {
		$domains = array(
			'load_textdomain',
			'load_theme_textdomain',
			'load_plugin_textdomain'
		);
		$gettext = array(
			'__',
			'_e',
			'_c', //context by |
			'_nc', //context by |
			'__ngettext', '_n',
			'__ngettext_noop', '_n_noop',
			'_x', 		//see "_c" but explicite context
			'_nx', 		//see "_n" but  but additional context,
			'_nx_noop'	//see "_n_noop" but  but additional context,
		);

		$escapements = array(
			'esc_attr__',
			'esc_html__',
			'esc_attr_e',
			'esc_html_e',
			'esc_attr_x'
		); //needed only for checks against developer own functions for gettext like Ozz is using
		
		$this->textdomain = $textdomain;
		$this->basedir = $basedir;
		$this->filename = '';
		$this->l10n_functions = array();
		$this->buildin_functions = array_merge($gettext, $escapements);
		
		if ($do_gettext) $this->l10n_functions = array_merge($this->l10n_functions, $gettext);
		if ($do_domains) $this->l10n_functions = array_merge($this->l10n_functions, $domains);
		
		$this->l10n_regular = '/('.implode('$|', $this->l10n_functions).'$)/';
		$this->l10n_domains = '/('.implode('|',$domains).')/';
	}
	
	function parseFile($filename) {
		if (file_exists($filename)){
			$this->filename = str_replace($this->basedir, '', $filename);
			$content = file_get_contents($filename);
			return $this->parseString($content);
		}
		return false;
	}
	
	function parseString($content) {
		$results = array(
			'gettext' 	  => array(),
			'not_gettext' => array()
		);
		
		$in_func = false;
		$in_domain = false;
		$in_not_gettext = false;
		$args_started = false;
		$parens_balance = 0;
		
		$tokens = token_get_all($content);
	
		$cur_not_gettext = false;
		$cur_func = false;
		$cur_full_func = false;
		$cur_translator_hint = false;
		$line_number = 1;
		$cur_match_line = 1;
		$cur_argc = 0;
		$cur_args = array();
		$bad_argc = array();
		
		foreach($tokens as $token) {
			if (is_array($token)) {
				list($id, $text) = $token;
				if (T_STRING == $id && preg_match($this->l10n_regular, $text, $m)) {
					$in_func = true;
					$in_domain = preg_match($this->l10n_domains, $text);
					$parens_balance = 0;
					$args_started = false;
					$cur_func = $m[1];
					$cur_full_func = $text;
					$token = $text;
				} elseif (T_STRING == $id && $in_func) {
					$bad_argc[] = $cur_argc;  //avoid stacked functions inside parts of required params!
					$token = $text;
				} elseif (T_CONSTANT_ENCAPSED_STRING == $id) {
					if ($in_func && $args_started) {
						if ($text{0} == '"') {
							$text = trim($text, '"');
							$text = str_replace('\"', '"', $text);
							$text = str_replace("\\$", "$", $text);
							$text = str_replace("\r\n", "\n", $text);
							$token = $text;
							$text = str_replace("\\n", "\n", $text);
						}
						else{
							$text = trim($text, "'");
							$text = str_replace("\\'", "'", $text);
							$text = str_replace("\\$", "$", $text);
							$text = str_replace("\r\n", "\n", $text);
							$text = str_replace("\\n", "\n", $text);
							$text = str_replace("\\\\", "\\", $text);
							$token = $text;
						}
						if(isset($cur_args[$cur_argc])){
							$cur_args[$cur_argc] .= $text;	
						}else{
							$cur_args[$cur_argc] = $text;	
						}
						
						if ($cur_argc == 0) $cur_match_line = $line_number;
					}elseif($in_not_gettext) {
						if ($text{0} == '"') {
							$text = trim($text, '"');
							$text = str_replace('\"', '"', $text);
						}
						else{
							$text = trim($text, "'");
							$text = str_replace("\\'", "'", $text);
						}
						$text = str_replace("\\$", "$", $text);
						$text = str_replace("\r\n", "\n", $text);						
						$results['not_gettext'][] = $this->_build_non_gettext($line_number, $cur_not_gettext, $text);
						$cur_not_gettext = false;
						$token = $text;
					}
					else {
						$token = $text;
					}
				} elseif ((T_ML_COMMENT == $id || T_COMMENT == $id) && preg_match('|/\*\s*(/?WP_I18N_[a-z_]+)\s*\*/|i', $text, $matches)) {
					$in_not_gettext = $matches[1]{0} == 'W';
					if ($in_not_gettext) $cur_not_gettext = 'Not gettexted string '.$matches[1];
					$token = $text;
				} elseif ((T_ML_COMMENT == $id || T_COMMENT == $id) && preg_match('/\*\s(translators:.*)\*/i', $text, $matches)) {
					$cur_translator_hint = $matches[1];
					$token = $text;
				} elseif((T_VARIABLE == $id)||(T_OBJECT_OPERATOR == $id)||(T_STRING == $id)) {
					if ($in_func && $in_domain && $args_started) {
						if(isset($cur_args[$cur_argc])){
							$cur_args[$cur_argc] .= $text;						
						}else{
							$cur_args[$cur_argc] = $text;
						}
					}
					$token = $text;
				}
				else {
					$token = $text;
				}
			} elseif ('(' == $token){
				$args_started = true;
				++$parens_balance;
			} elseif (',' == $token) {
				if ($in_func && $args_started) {
					$cur_argc++;
				}
			} elseif (')' == $token) {
				--$parens_balance;
				if ($in_func && 0 == $parens_balance) {				
					if (count($cur_args) && isset($cur_args[0])) {
						//skip those, where all args are variables
						$is_dev_func = !in_array($cur_full_func, $this->buildin_functions);
						$gt = $this->_build_gettext($cur_match_line, $cur_func, $cur_args, $cur_argc, $is_dev_func, $bad_argc);
						if (is_array($gt)) {
							if ($cur_translator_hint !== false) {
								$gt['CC'][] = $cur_translator_hint;
							}
							$results['gettext'][] = $gt;
						}
					}
					$in_func = false;
					$in_domain = false;
					$args_started = false;
					$cur_func = false;
					$cur_full_func = false;
					$cur_translator_hint = false;
					$cur_argc = 0;
					$cur_args = array();
					$bad_argc = array();
				}
			}			
			$line_number += substr_count($token, "\n");
		}
		return $results;
	}
	
	function _build_gettext($line, $func, $args, $argc, $is_dev_func, $bad_argc) {
		$res = array(
			'msgid' => '',
			'R'		=> $this->filename.':'.$line,
			'CC' 	=> array(),
			'LTD'	=> ($is_dev_func ? $this->textdomain : '')
		);
		switch($func) {
			case '__':
				// see also esc_html__
				//see also esc_attr__
				//[0] =>  phrase
				//[1] => textdomain (optional)
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0];
				if (isset($args[1])) $res['LTD'] = trim($args[1]);
				elseif ($argc == 1) $res['LTD'] = $this->textdomain;
			case '_e':
				//see also esc_html_e
				//see also esc_attr_e
				//[0] =>  phrase
				//[1] => textdomain (optional)
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0];
				if (isset($args[1])) $res['LTD'] = trim($args[1]);
				elseif ($argc == 1) $res['LTD'] = $this->textdomain;
			case '_c':
				//[0] =>  phrase
				//[1] => textdomain (optional)
				$res['msgid'] = $args[0];
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (isset($args[1])) $res['LTD'] = trim($args[1]);
				elseif ($argc == 1) $res['LTD'] = $this->textdomain;
				break;
			case '_x': 		
				//see "_c" but explicite context
				//se also esc_attr_x 
				//[0] =>  phrase
				//[1] =>  context
				//[2] => textdomain (optional)
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[1]."\04".$args[0];
				if (isset($args[2])) $res['LTD'] = trim($args[2]);
				elseif ($argc == 2) $res['LTD'] = $this->textdomain;
				break;
			case '__ngettext':
				//[0] =>  phrase singular
				//[1] => phrase plural
				//[2] => number
				//[3] => textdomain (optional)
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0]."\00".$args[1];
				$res['P'] = true;
				if (isset($args[3])) $res['LTD'] = trim($args[3]);
				elseif ($argc == 3) $res['LTD'] = $this->textdomain;
				break;
			case '_n':
				//[0] => phrase singular
				//[1] => phrase plural
				//[2] => number
				//[3] => textdomain (optional)				
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0]."\00".$args[1];
				$res['P'] = true;
				if (isset($args[3])) $res['LTD'] = trim($args[3]);
				elseif ($argc == 3) $res['LTD'] = $this->textdomain;
				break;
			case '_nc':
				//[0] => phrase singular
				//[1] => phrase plural
				//[2] => number
				//[3] => textdomain (optional)				
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0]."\00".$args[1];
				$res['P'] = true;
				if (isset($args[3])) $res['LTD'] = trim($args[3]);
				elseif ($argc == 3) $res['LTD'] = $this->textdomain;
				break;
			case '_nx':
				//see "_n" but  but additional context,
				//[0] => phrase singular
				//[1] => phrase plural
				//[2] => number
				//[3] => context
				//[4] => textdomain (optional)
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				if (in_array(3, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[3]."\04".$args[0]."\00".$args[1];
				$res['P'] = true;
				if (isset($args[4])) $res['LTD'] = trim($args[4]);
				elseif ($argc == 4) $res['LTD'] = $this->textdomain;
				break;
			case '__ngettext_noop':
				//[0] =>  phrase singular
				//[1] => phrase plural
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0]."\00".$args[1];
				$res['P'] = true;
				break;
			case '_n_noop':
				//see deprecated __ngettext_noop
				//[0] =>  phrase singular
				//[1] => phrase plural				
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[0]."\00".$args[1];
				$res['P'] = true;
				break;
			case '_nx_noop':
				//see "_n_noop" but  but additional context,
				//[0] => phrase singular
				//[1] => phrase plural				
				//[2] => context
				if (in_array(0, $bad_argc)) return null; //error, this can't be a function
				if (in_array(1, $bad_argc)) return null; //error, this can't be a function
				if (in_array(2, $bad_argc)) return null; //error, this can't be a function
				$res['msgid'] = $args[2]."\04".$args[0]."\00".$args[1];
				$res['P'] = true;
				break;			
		}
		return $res;
	}
	
	function _build_non_gettext($line, $stage, $text) {
		return array( 
			'msgid' => $text,
			'R' 	=> $this->filename.':'.$line, 
			'CC' 	=> array($stage), 
			'LTD'	=> '{php-code}'
		);
	}

}

?>