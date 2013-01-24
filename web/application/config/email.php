<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

if ( ENVIRONMENT != 'production' )
{
	$config[ 'protocol' ]		= 'smtp';
	$config[ 'smtp_host' ]		= 'localhost';
	$config[ 'smtp_user' ]		= '';
	$config[ 'smtp_pass' ]		= '';
//	$config[ 'smtp_timeout' ]	= '180';
	$config[ 'mailtype' ]		= 'html';
}
else
{
	$config[ 'protocol' ]		= 'mail';
//	$config[ 'smtp_timeout' ]	= '180';
}