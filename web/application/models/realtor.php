<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Realtor extends DataMapper
{
	public $model = 'realtor';
	public $table = 'realtors';

	public $default_order_by	= array( 'name' );
	public $has_many			= array( 'operation' );
	public $has_one				= array( 'neighborhood' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}