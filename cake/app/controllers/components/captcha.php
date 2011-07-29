<?php  

include_once VENDORS  . 'phpcaptcha'.DS.'php-captcha.inc.php'; 

class CaptchaComponent extends Object 
{ 
    var $controller; 
  
    function startup( &$controller ) { 
        $this->controller = &$controller; 
        
    } 

    function image(){ 
         
        $imagesPath = realpath(VENDORS . 'phpcaptcha').'/fonts/'; 
         
        $aFonts = array( 
            $imagesPath.'VeraBd.ttf', 
            $imagesPath.'VeraIt.ttf', 
            $imagesPath.'Vera.ttf' 
        ); 
         
        $oVisualCaptcha = new PhpCaptcha($aFonts, 200, 60); 
        $oVisualCaptcha->UseColour(true); 
        //$oVisualCaptcha->SetOwnerText('Source: '.FULL_BASE_URL); 
        $oVisualCaptcha->SetNumChars(6); 
        $oVisualCaptcha->Create(); 
    } 
     
    function audio(){ 
        $oAudioCaptcha = new AudioPhpCaptcha('/usr/bin/flite', '/tmp/'); 
        $oAudioCaptcha->Create(); 
    } 
     
    function check($userCode, $caseInsensitive = true){ 
        if ($caseInsensitive) { 
            $userCode = strtoupper($userCode); 
        } 
         
        if (!empty($_SESSION[CAPTCHA_SESSION_ID]) && $userCode == $_SESSION[CAPTCHA_SESSION_ID]) {
            // clear to prevent re-use 
            unset($_SESSION[CAPTCHA_SESSION_ID]); 
             
            return true; 
        } 
        else return false; 
         
    } 
} 
?>