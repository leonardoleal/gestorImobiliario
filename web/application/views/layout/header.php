<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo $this->application->config->system->title->value; ?></title>
	<meta name="description" content="<?php echo $this->application->config->system->description->value; ?>">
	<meta name="keywords" content="<?php echo $this->application->config->system->keywords->value; ?>">
	<meta name="author" content="<?php echo $this->application->development_name; ?>">
	<meta name="robots" content="index,follow">
	<meta name="googlebot" content="index,follow">
	<base href="<?php echo( $this->application->url ); ?>">
	<link type="image/png" rel="shortcut icon" href="static/img/favicon.png">
	<link type="text/css" rel="stylesheet" href="static/css/global.css">
</head>
<body>
	<header>
	<?php echo html::ie_tag( 'header' ); ?>
		<h1>
			<a href="<?php html::write( $this->application->home ); ?>"><?php html::write( $this->application->home ); ?></a>
		</h1>
		<nav>
		<?php echo html::ie_tag( 'nav' ); ?>
			<a href="<?php html::write( $this->application->home ); ?>">Home</a>
			<a href="<?php html::write( $this->application->products ); ?>">Imóveis</a>
			<?php html::write_html( $this->application->menu ); ?>
			<a href="<?php html::write( $this->application->contact ); ?>">Contato</a>
		<?php echo html::ie_tag_close(); ?>
		</nav>
	<?php echo html::ie_tag_close(); ?>
	</header>