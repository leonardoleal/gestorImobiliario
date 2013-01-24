<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

	$config[ 'upload_path' ]	= FCPATH . 'static/photos/';
	$config[ 'allowed_types' ]	= 'jpg|gif|jpeg|png';
	$config[ 'max_width' ]		= 0;
	$config[ 'max_height' ]		= 0;
	$config[ 'max_size' ]		= 0;
	$config[ 'overwrite' ]		= TRUE;
