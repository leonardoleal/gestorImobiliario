<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Statistics extends CI_Controller
{
	public $url;

	public function __construct()
	{
		parent::__construct();

		$this->load->library( 'messages' );


		$this->url = base_url() . $this->config->item( 'manager_uri' );


		//
		// verifica se o usuário esta logado
		//
        $this->validate();
	}


    public function index( $type = 'access_log', $subtype = 'per_page' )
	{
		//
		// configuração básica da página
		//
		$uri							= 'statistics/' . $type . '/' . $subtype . '/';
		$url							= $this->url . $uri;
		$title							= 'Estatísticas';


		//
		// busca as mensagens
		//
        $messages                       = $this->messages->get();


        //
        // recebe os dados
        //;
        $type		= ucwords( $type );
        $subtype	= strtolower( $subtype );


        //
		// verifica se existe o tipo de relatório
		//
		if ( class_exists( $type )
				AND method_exists( $type, 'get_' . $subtype ) )
		{
			//
			// busca o relatório
			//
			$log = new $type();
			$log = $log->{'get_' . $subtype}( $this->input->post() );


			//
			// salva a consulta na variável de sessão
			//
			$this->load->helper( 'hash' );
			$filter_hash			= hash::generate();
			
			$filter					= $this->session->userdata( 'filter' );
			$filter[ $filter_hash ]	= $log->query;
			
			$this->session->set_userdata( 'filter', $filter );
		}
		else
		{
			//
			// seta mensagem e redireciona
			//
			$this->messages->add( 'Não existe relatório deste tipo.', 'warning' );
			redirect( $this->config->item( 'manager_uri' ) . 'products/' );
		}

		//
		// passa os dados para a view
		//
        $data = array(
			'messages'			=> $messages,
        	'records'  			=> $log->records,
	        'filters'  			=> $log->filters,
			'filter_hash'		=> $filter_hash,
	        'legends'  			=> $log->legends,
			'page'				=> array(
				'uri'				=> $uri,
				'url'				=> $url,
				'title' 			=> $title
			)
		);


		//
		// define o layout que será utilizado
		//
		$this->load->view( 'manager/layout/header' );
		$this->load->view( 'manager/statistics/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function export( $hash = NULL )
	{
		if ( !is_null( $hash ) )
		{
			//
			// carrega o helper
			//
			$this->load->helper( 'export' );


			//
			// busca a query gravada na sessão de acordo com o hash
			//
			$filter		= $this->session->userdata( 'filter' );


			//
			// busca os dados no banco
			//
			$query = $this->db->query( $filter[ $hash ] );


			//
			// verifica se o arquivo foi gerado
			//
			if ( export::to_excel( $query, 'Relatório' ) )
			{
				return TRUE;
			}
		}


		//
		// se cheagar aqui algo errado ocorreu
		//
		$this->messages->add( 'Não foi possível gerar o arquivo, nenhum registo encontrado.', 'error' );

		redirect( $this->url . 'statistics/' );
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