<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-script-type" content="text/javascript" />
		<meta http-equiv="content-style-type" content="text/css" />
		<link rel="stylesheet" href="/assets/wiz/css/reset.css" type="text/css" />
		<link rel="stylesheet" href="/assets/wiz/css/global.css" type="text/css" />
		<link rel="stylesheet" href="/assets/wiz/css/jquery-ui.css" type="text/css" />
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript" src="/assets/wiz/js/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="/assets/wiz/js/jquery-1.9.1.ui.min.js"></script>
		<script type="text/javascript" src="/assets/wiz/js/jquery-contained-sticky-scroll-min.js"></script>
		<title><?php echo ENV_LABEL.' ';?>Wiz Group Corp Portal</title>
	</head>
	<body>
		<?php if (ENV_LABEL !== ''):?>
		<h1><?php echo ENV_LABEL;?></h1>
		<?php endif;?>

		<!--header area-->
		<div id="header">
			<div id="logo"><a href="/"><img src="/assets/wiz/img/wiz-g_logo_header.jpg" /></a></div>
			<?php if (logged_in()):?>
				<div id="username">Hi, <?php echo username();?>.</div>
			<?php else:?>
				<div id="username">Hi, guest.</div>
			<?php endif;?>
		</div>
		<div class="clear"></div>

		<!--navigation area-->
		<div id="nav_bg">
		<?php $this->load->view($this->config->item('auth_views_root') . 'parts/nav'); ?>
		</div>
		
		<div id="container">
