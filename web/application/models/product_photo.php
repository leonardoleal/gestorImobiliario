<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Product_photo extends DataMapper
{
	public $model = 'product_photo';
	public $table = 'products_photos';

	public $default_order_by	= array( 'id' );
	public $has_one			= array( 'product' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}