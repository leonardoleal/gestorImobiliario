<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Product extends DataMapper
{
	public $model = 'product';
	public $table = 'products';

	public $default_order_by	= array( 'id' );
	public $has_many			= array( 'product_category_item', 'product_photo', 'operation' );
	public $has_one				= array( 'customer', 'neighborhood' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}


	public function get_type( $type = NULL )
	{
		$data = array( 'Residencial', 'Comercial' );

		if ( is_numeric( $type ) )
		{
			return $data[ $type ];
		}

		return $data;
	}


	public function get_transaction_type( $type = NULL )
	{
		$data = array( 'Venda', 'Aluguel' );

		if ( is_numeric( $type ) )
		{
			return $data[ $type ];
		}

		return $data;
	}
}