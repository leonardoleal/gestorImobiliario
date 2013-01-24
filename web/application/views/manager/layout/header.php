<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->config->item( 'manager_title' ); ?> | Manager</title>
	<base href="<?php echo( $this->application->url ); ?>">
	<link type="text/css" media="screen" rel="stylesheet" href="static/manager/css/style.css">
	<link type="text/css" media="screen" rel="stylesheet" href="static/manager/css/jquery.wysiwyg.css">
	<link type="text/css" media="screen" rel="stylesheet" href="static/manager/css/facebox.css">
	<link type="text/css" media="screen" rel="stylesheet" href="static/manager/css/visualize.css">
	<link type="text/css" media="screen" rel="stylesheet" href="static/manager/css/date_input.css">
	<link type="text/css" media="screen" rel="stylesheet" href="static/manager/css/highslide.css">
	<!--[if lt IE 8]>
	    <link type="text/css" media="all" rel="stylesheet" href="static/manager/css/ie.css">
    <![endif]-->
</head>
<body>
	<?php if ( $this->session->userdata( 'manager.user.logged' ) === TRUE ) { ?>
	<div id="header">
		<div class="line">
			<p class="system">Sistema administrativo: <?php echo $this->config->item( 'manager_title' ); ?></p>
			<p class="greetings">
				<span>Olá, </span>
				<a href="manager/users/save/<?php echo $this->session->userdata( 'manager.user.id' ); ?>"><?php echo $this->session->userdata( 'manager.user.name' ); ?></a>
				<a href="manager/users/logout/">Sair</a>
			</p>
		</div>
		<?php $this->load->view( 'manager/layout/menu' ); ?>
		<?php $this->load->view( 'manager/layout/search' ); ?>
	</div>
	<?php } ?>
	<div class="wrapper">