<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class User extends DataMapper
{
	public $model = 'user';
	public $table = 'users';

	public $default_order_by = array( 'id' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}


	public function test( $login, $password ) // bool
	{
		//
		// verifica se existe algum registro com este usuario e senha
		//
		$user = new $this();
		$user->where( 'login', $login );
		$user->where( 'password', md5( $password ) );
		$user->where( 'removed <', 1 );
		$user = $user->get();


		//
		// retornar TRUE ou FALSE
		//
		return ( $user->result_count() > 0 );
	}
	
}