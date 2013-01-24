<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Locations extends CI_Controller
{
	public function get_cities()
	{
		$state_id			= $this->input->post( 'state_id' );
		$result[ 'status' ]	= 'error';


		if ( !empty( $state_id ) )
		{
			$records	= new City();
			$records->where( 'removed <', 1 );
			$records->where( 'state_id', $state_id );
			$records->get();


			if ( $records->result_count() > 0 )
			{
				$result[ 'status' ]	= 'ok';
				$result[ 'data' ]	= $records->all_to_array( array( 'id', 'name' ) );
			}
		}


		echo( json_encode( $result ) );
	}


	public function get_neighborhoods()
	{
		$city_id			= $this->input->post( 'city_id' );
		$result[ 'status' ]	= 'error';


		if ( !empty( $city_id ) )
		{
			$records	= new Neighborhood();
			$records->where( 'removed <', 1 );
			$records->where( 'city_id', $city_id );
			$records->get();


			if ( sizeof( $records ) > 0 )
			{
				$result[ 'status' ]	= 'ok';
				$result[ 'data' ]	= $records->all_to_array( array( 'id', 'name' ) );
			}
		}


		echo( json_encode( $result ) );
	}


	public function validate() // bool
	{
		//
		// verifica se a variavel logged esta definida como true
		//
		if ( $this->session->userdata( 'manager.user.logged' ) !== TRUE )
		{
			//
			// usuário precisa estar logado
			//
			$this->messages->add( 'Você precisa estar logado.', 'error' );


			//
			// redireciona para a pagina de login
			//
			redirect( $this->url );
		}
	}
}