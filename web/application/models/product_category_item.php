<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Product_category_item extends DataMapper
{
	public $model = 'product_category_item';
	public $table = 'products_categories_items';

	public $default_order_by	= array( 'id' );
	public $has_one			= array( 'product', 'category_item' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}