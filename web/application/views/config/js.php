<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

header( 'content-type:text/javascript' );

if ( FALSE ) { ?>
<script type="text/javascript">
<?php } ?>
var	config = {
	environment:		'<?php echo ENVIRONMENT; ?>',
	url:				'<?php echo base_url(); ?>',
	static_url:			'<?php echo base_url(); ?>static/',
	manager:
	{
		url:			'<?php echo base_url(); ?>manager/',
		static_url:		'<?php echo base_url(); ?>static/manager/',
		upload_url:		'<?php echo base_url(); ?>manager/products/upload_photo/'
	}
};