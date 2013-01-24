<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Neighborhood extends DataMapper
{
	public $model = 'neighborhood';
	public $table = 'neighborhoods';

	public $default_order_by	= array( 'name' );
	public $has_one				= array( 'city' );
	public $has_many			= array( 'customer', 'realtor', 'product' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}