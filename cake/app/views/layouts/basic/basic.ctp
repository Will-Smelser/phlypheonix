<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		//echo $this->Html->meta('icon','/img/jm.icon.png')."\n";
		//echo $this->Html->css('reset')."\n";
		
		//echo $scripts_for_layout;
		
	?>
	
	<style>
	/* YUI 3 CSS REST */
html{color:#000;background:#FFF}body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,code,form,fieldset,legend,input,textarea,p,blockquote,th,td{margin:0;padding:0}table{border-collapse:collapse;border-spacing:0}fieldset,img{border:0}address,caption,cite,code,dfn,em,strong,th,var{font-style:normal;font-weight:normal}li{list-style:none}caption,th{text-align:left}h1,h2,h3,h4,h5,h6{font-size:100%;font-weight:normal}q:before,q:after{content:''}abbr,acronym{border:0;font-variant:normal}sup{vertical-align:text-top}sub{vertical-align:text-bottom}input,textarea,select{font-family:inherit;font-size:inherit;font-weight:inherit}input,textarea,select{*font-size:100%}legend{color:#000}

#landing-content {
	float:left;
	padding: 17px 0px 0px 15px;
	width:350px;	
}

HTML{
	height:100%;
	width:100%;	
	
	background-color: #545454;
	background-image: url("/img/helpers/bg_stripes.gif");
	
}
BODY{
	height: 100%;
	width:100%;	
	

}
#wrapper {
	margin:0px;
	padding:0px;
	border:none;
}
#topWrapper{
	
		
}
#wrapper{
	position:absolute;
	z-index:2;
	top:50%;
	
	width:100%;
	
	margin-top:-200px;
}
#container{
	background-image: url("/img/helpers/film.png");
	background-repeat:repeat-x;
	background-position:top center;
}
#main{
	margin: 0px auto 0px auto;
	
	height:400px;
	width:950px;

	background-color:#000;
}
#inner{
	border:solid #000 8px;
	background-color:#FFF;
	height:384px;
}
#footer{
}
#logo{
	position:relative;
	top:0px;
	left:-10px;	
}
	</style>

</head>
<body class="f-std">
	<div id="wrapper">
	<div id="topWrapper">
		<div id="header">
			
		</div>
		<div id="top-nav" class="f-white">
			
		</div>
	</div>
	<div id="container">
		
		<div id="content">
			
			<div id="main">
				<div id="inner">
					<?php echo $this->Session->flash(); ?>
					<?php echo $content_for_layout; ?>
					<div id="inner-foot"></div>
				</div>
			</div>

		</div>
		<div id="footer">
			
		</div>
	</div>
	</div>
	<div id="img-preloader" style="display:none;"></div>
	<?php //echo $this->element('sql_dump'); ?>
</body>