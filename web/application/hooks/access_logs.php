<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Access_logs
{
	private $CI;
	private $browser;

	public function __construct()
	{
		//
		// define criação de logs sempre com data e hora de são paulo
		//
		date_default_timezone_set('America/Sao_Paulo');

		//
		// referência ao CI
		//
		$this->CI =& get_instance();
		$this->CI->load->helper( 'browser_detection' );
	}

	public function save()
	{
		//
		// recebe os valores
		//
		sort( $segment	= array_filter( explode( '/' , key( $_REQUEST ) ) ) );
		$page		= isset( $segment[ 1 ] ) ? $segment[ 1 ] : 'home';
		$product_id	= isset( $segment[ 2 ] ) ? $segment[ 2 ] : NULL;
		$ip			= Browser_detection::get_ip();
		$system		= Browser_detection::get_os();
		$browser	= Browser_detection::get_browser();


		if ( $page != 'manager'
				AND $page != 'config' )
		{
			//
			// atribui os valores
			//
			$record				= new Access_log();
			$record->page		= $page;
			$record->product_id	= $product_id;
			$record->ip			= $ip;
			$record->system		= $system;
			$record->browser	= $browser;


			$record->save();
		}
	}
}


