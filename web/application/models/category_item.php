<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Category_item extends DataMapper
{
	public $model = 'category_item';
	public $table = 'categories_items';

	public $default_order_by	= array( 'id' );
	public $has_one			= array( 'category' );
	public $has_many			= array( 'product_category_item' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}