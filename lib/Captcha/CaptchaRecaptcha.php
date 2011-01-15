<?php

require (__DIR__."/recaptcha_1_11/recaptchalib.php");

class CaptchaRecaptcha {

	// static $_captchaHtml = null;
	static $_publickey = "6Lf1TMASAAAAAIyM4jdt6rljHVSG86R-JRvX__Rw";
	static $_privatekey = "6Lf1TMASAAAAAOUPSOsv4j7wUHv0GnuSM5TO_glJ";
	
	public static function getHTML()
	{
		return recaptcha_get_html(self::$_publickey, null);
		/*
		if (self::$_captchaHtml === null) { 
			self::$_captchaHtml = recaptcha_get_html(self::$_publickey, null);
		}
		return self::$_captchaHtml;
		*/
	}

	public static function validate($recaptcha_challenge_field, $recaptcha_response_field, &$error = null)
	{
		$resp = recaptcha_check_answer (self::$_privatekey,
                                        $_SERVER["REMOTE_ADDR"],
                                        $recaptcha_challenge_field,
                                        $recaptcha_response_field);
		
		if ($resp->is_valid) return true;
		else {
			$error = $resp->error;
			return false;
		}
	}

	
}