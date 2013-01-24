<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Pages extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	public function index( $title )
	{
		//
		// busca lista de produtos
		//
		$record = new Page();
		$record->where( 'removed <', 1 );
		$record->where( 'title', $title );
		$record->get( 1 );


		if ( $record->result_count() != 1 )
		{
			show_404();
		}


		$data = array(
			'record' => $record
		);


		$this->views( 'pages', $data );
	}

	
	public function views( $content, $data = NULL )
	{
		$this->load->view( 'layout/header' );
		$this->load->view( $content, $data );
		$this->load->view( 'layout/footer' );
	}
}