<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Customer extends DataMapper
{
	public $model = 'customer';
	public $table = 'customers';

	public $default_order_by	= array( 'name' );
	public $has_many			= array( 'product', 'operation' );
	public $has_one				= array( 'neighborhood' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}