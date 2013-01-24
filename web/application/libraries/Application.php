<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Application
{
	function __construct()
	{
		$ci =& get_instance();


		//
		// busca as configurações do banco
		//
		$records = new Configuration();
		$records->include_related( 'configuration_group', NULL, TRUE, TRUE );
		$records->where( 'removed <', 1 );
		$records->get();


		//
		// transforma os registros em propriedades
		//
		foreach( $records as $record )
		{
// 			$this->{ $record->title } = $record->value;
			$this->config->{ $record->configuration_group->title }->{ $record->title }->title = $record->title;
			$this->config->{ $record->configuration_group->title }->{ $record->title }->alias = $record->alias;
			$this->config->{ $record->configuration_group->title }->{ $record->title }->value = $record->value;
		}
		

		//
		// configurações básicas
		//
		$this->url				= base_url();
		$this->path				= FCPATH;


		//
		// paths do sistema
		//
		$this->products_path	= $this->path . 'files/products/';
		$this->products_url		= $this->url . 'files/products/';

		$this->images_path		= $this->path . 'files/pages/';
		$this->images_url		= $this->url . 'files/pages/';


		//
		// páginas
		//
		$this->home			= '';
		$this->products		= 'imoveis/';
		$this->products_details	= 'imoveis/';
		$this->contact			= 'contato/';
		$this->contact_send		= 'contato/envia';


		//
		// páginas dinâmicas
		//
		$records				= new Page();
		$this->menu			= $records->get_pages_links();


		//
		// configuração do e-mail
		//
		$email = array(
			'development'	=> 'morris@combo.st',
			'testing'		=> 'morris@combo.st',
			'production'	=> $this->config->system->email
		);

		$this->email		= $email[ ENVIRONMENT ];


		//
		// desenvolvimento e criação
		//
		$this->development_name	= 'COMBO';
		$this->development_link	= 'http://combo.st';
		$this->art_name		= 'COMBO';
		$this->art_link		= 'http://combo.st';
	}
}