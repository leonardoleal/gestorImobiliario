<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Category extends DataMapper
{
	public $model = 'category';
	public $table = 'categories';

	public $default_order_by	= array( 'title' );
	public $has_many			= array( 'category_item' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}


	public function get_type( $type = NULL )
	{
		$data = array( 'Único', 'Múltiplo' );

		if ( is_numeric( $type ) )
		{
			return $data[ $type ];
		}

		return $data;
	}
}