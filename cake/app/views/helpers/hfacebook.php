<?php
class HfacebookHelper extends AppHelper {
	var $appId;
	var $apiKey;
	var $apiSecret;
	
	var $controller;
	function HfacebookHelper(){
		
		Configure::load('facebook');
		
		$this->appId = Configure::read('facebook.appId');
		$this->apiKey = Configure::read('facebook.apiKey');
		$this->apiSecret = Configure::read('facebook.apiSecret');

	}
	
	function shareMeta($img,$title=null,$desc=null){
		$str = "";
		if(is_array($img)){
			foreach($img as $file){
				if(!preg_match("/flyfoenix.com/i",$file)) $file = 'http://www.flyfoenix.com' . $file;
				$str .= "<meta property=\"og:image\" content=\"{$file}\" />\n";
			}
		} else {
			if(!preg_match("/flyfoenix.com/i",$img)) $img = 'http://www.flyfoenix.com' . $img;
			$str .= "<meta property=\"og:image\" content=\"{$img}\" />\n";
		}
		if(empty($title)) $title='200+ schools - Upgrade Your College Gear - Save 20-40%';
		if(empty($desc)) $desc = 'FlyFoenix.com finds the best officially licensed college apparel and serves it up at a discount! Exclusive unique apparel for over 200 colleges and universities.  New sales start weekly...Join Today!';
		
	$str .= "
	<meta property=\"og:title\" content=\"$title\" /> 
	<meta property=\"og:description\" content=\"$desc\" /> 
	
	<meta property=\"og:site_name\" content=\"FlyFoenix.com\" />
	<meta property=\"fb:admins\" content=\"679415429\" />
";
	
		echo $str;
	}
	
	function loginButton($title='',$showFaces='false'){
		return '<fb:login-button show-faces="'.$showFaces.'" width="200" max-rows="1">'.$title.'</fb:login-button>';
	}
	/**
	 * Create facebook like button
	 * @param $url string The url to associate with like button, for framed method only
	 * @param $layout string Layout options, Frame only
	 * @param $faces String Boolean (true|false) Show faces, Frame only
	 * @param $width integer width, Frame only
	 * @param $height integer height, Frame only
	 * @return unknown_type
	 */
	function likeButton($url,$layout='standard',$faces='false',$width=450,$height=80){
		$raw = $url;
		
		//encode url
		$url = urlencode($url);
		
		//build the frame
		$frame = <<<STR
		<iframe src="http://www.facebook.com/plugins/like.php?
			href=$url&amp;
			layout=$layout&amp;
			show_faces=$faces&amp;
			width=$width&amp;
			action=like&amp;
			colorscheme=light&amp;
			height=$height" 
		
			scrolling="no" frameborder="0" 
			
			style="border:none; overflow:hidden; width:{$width}px; height:{$height}px;" allowTransparency="true"></iframe>
STR;
		
		$frame = str_replace("\n",'',$frame);
		$frame = str_replace("\t",'',$frame);
		
		//fbml
		$fbml = "<fb:like href=\"$raw\"></fb:like>";
		
		return array('frame'=>$frame,'fbml'=>$fbml);
	}
	function likeButtonHTML5($url){
		$script = <<<STR
		<div class="fb-like" data-href="$url" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
STR;
		return $script;
	}
	function likeButtonFBML($url){
		echo "<fb:like href=\"$url\" send=\"true\" layout=\"button_count\" width=\"450\" show_faces=\"false\"></fb:like>";
	}
	/**
	 * 
	 * @param $id string Unique identifier for this set of comments
	 * @param $width integer The width
	 * @return string
	 * @see http://developers.facebook.com/docs/reference/fbml/comments
	 */
	function comments($id, $width=425, $opts=array()){
		$opts = http_build_query($opts,'',' ');
		$opts = str_replace('+','',$opts);
		return '<fb:comments xid="'.$id.'" width="'.$width.'" '.$opts.'></fb:comments>';
	}
	
	function initSimple($appId, $callback='function(){}'){
		
		$str  = "\n\t//Facebook\n";
		
		$str .= "window.fbAsyncInit = function() {\n";
		
		$str .= 
<<<STR
	FB.init({
	appId   : '$appId',
	status  : true, // check login status
	cookie  : true, // enable cookies to allow the server to access the session
	xfbml   : true, // parse XFBML
	oauth   : true  //use Oauth 2.0
	});
	FB.Canvas.setAutoResize();

    fbApiInit = true; //init flag
};

function fbEnsureInit(callback) {
   if(!window.fbApiInit) {
      setTimeout(function() {fbEnsureInit(callback);}, 50);
   } else {
      if(callback) {
          callback();
      }
   }
};

fbEnsureInit($callback);
	
STR;
		return $str;
		
	}
	
	/**
	 * Create the facebook initialization code...does not write "<script></script>" tags
	 * @param $appId string Your app Id...If use Cake component cfacebook, use $FACEBOOK_APP_ID
	 * @param $fbsession array Your facebook session in array format...if using Cake component cfacebook, use $FACEBOOK_APP_SESSION
	 * @param $async Wether or not to load this asyncronously...defaults to false
	 * @param $hooks array('fb hookname'=>'youJSfunctionName') 
	 * 		- see http://developers.facebook.com/docs/reference/javascript/FB.login for list of facebook login hooks
	 * @return string
	 */
	function initLogin($appId,$fbsession=null,$async=false,$hooks=array()){
		$session = json_encode($fbsession);
		
		//just for formatting
		$tab = ($async) ? "\t" : '';
		
		$str  = "\n\t//Facebook\n";
		
		$str .= ($async) ? "\twindow.fbAsyncInit = function() {\n" : '';
		
		$str .= 
<<<STR
	FB.init({
	appId   : '$appId',
	session : $session, // don't refetch the session when PHP already has it
	status  : true, // check login status
	cookie  : true, // enable cookies to allow the server to access the session
	xfbml   : true, // parse XFBML
	oauth   : true  //use Oauth 2.0
	});

STR;
		$str .= ($async) ? "{$tab}}\n\n" : '';
	
		foreach($hooks as $hook=>$function){
			$str .= <<<STR
			
	// Facebook Hook: $hook
	FB.Event.subscribe('$hook', $function);
	
STR;
		}
		return $str;
	}
	
	function loginJs($success=null, $failure=null, $scopeString=null){
		if($success != null) $success .= '();';
		if($failure != null) $failure .= '();';
		
		$str = 
<<<STR
		FB.login(
			function(response) {
				if (response.authResponse) {
		        	{$success}
				} else {
		            //user cancelled login or did not grant authorization
		            {$failure}
		    	}
			}, 
			{scope:'$scopeString'}
		);	
STR;
		return $str;
	}
	
	function connectScript($protocal='http'){
		return "\n".'<script src="'.$protocal.'://connect.facebook.net/en_US/all.js"></script>'."\n";	
	}
	
	/**
	 * Wasnt sure where to put this, so it is here for now
	 * @param $user_username string The username in `users` database
	 * @param $FACEBOOK_APP_LOGGED_IN Boolean Created by Cfacebook (facebook component)
	 * @param $FACEBOOK_USER Array Created by Cfacebook (facebook component);
	 * @return string
	 */
	function getUsername($user_username, $FACEBOOK_APP_LOGGED_IN, $FACEBOOK_USER){
		$username = ($FACEBOOK_APP_LOGGED_IN ) ? $FACEBOOK_USER['first_name'] . ' ' . $FACEBOOK_USER['last_name'] : $user_username;
		if( strlen($username) == 0) $username = 'Anonymous';
		return $username;
	}
}
?>