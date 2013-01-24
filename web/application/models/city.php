<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class City extends DataMapper
{
	public $model = 'city';
	public $table = 'cities';

	public $default_order_by	= array( 'name' );
	public $has_one				= array( 'state' );
	public $has_many			= array( 'neighborhood' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}