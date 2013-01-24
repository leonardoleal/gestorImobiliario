<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Configuration_group extends DataMapper
{
	public $model = 'configuration_group';
	public $table = 'configurations_groups';

	public $default_order_by	= array( 'alias' );
	public $has_many		= array( 'configuration' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}