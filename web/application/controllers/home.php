<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->views( 'home' );
	}
	

	public function views( $content, $data = NULL )
	{
		$this->load->view( 'layout/header' );
		$this->load->view( $content, $data );
		$this->load->view( 'layout/footer' );
	}
}