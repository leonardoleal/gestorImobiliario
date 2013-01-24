<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Configuration extends DataMapper
{
	public $model = 'configuration';
	public $table = 'configurations';

	public $default_order_by	= array( 'alias' );
	public $has_one		= array( 'configuration_group' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}