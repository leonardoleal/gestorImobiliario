<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class State extends DataMapper
{
	public $model = 'state';
	public $table = 'states';

	public $default_order_by	= array( 'alias' );
	public $has_many			= array( 'city' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}
}