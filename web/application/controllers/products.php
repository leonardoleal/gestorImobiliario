<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Products extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		//
		// busca lista de produtos
		//
		$records = new Product();
		$records->select( 'products.id, CONCAT( neighborhood_cities.name, " - ", neighborhoods.name ) AS title, value', FALSE );
		$records->include_related( 'neighborhood', 'name' );
		$records->include_related( 'neighborhood/city', 'name' );
		$records->where( 'removed <', 1 );
		$records->limit( '20' );
		$records->get();


		$data = array(
			'records' => $records
		);


		$this->views( 'products', $data );
	}


	public function details( $id )
	{
		if ( !is_numeric( $id ) )
		{
			redirect( 'products/' );
		}


		//
		// busca lista de produtos
		//
		$record = new Product();
		$record->include_related( 'neighborhood', 'name' );
		$record->include_related( 'neighborhood/city', 'name', 'city' );
		$record->where( 'id', $id );
		$record->where( 'removed <', 1 );
		$record->get();


		//
		// verifica se encontrou o imóvel do contrário redireciona
		//
		if ( $record->result_count() != 1 )
		{
			redirect( $this->application->products );
		}


		$data = array(
			'record' => $record
		);


		$this->views( 'products_details', $data );
	}


	public function views( $content, $data = NULL )
	{
		$this->load->view( 'layout/header' );
		$this->load->view( $content, $data );
		$this->load->view( 'layout/footer' );
	}
}