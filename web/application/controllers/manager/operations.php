<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Operations extends CI_Controller
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


    public function index()
	{
		//
		// configuração básica da página
		//
		$uri							= 'operations/';
		$url							= $this->url . $uri;
		$title							= 'Operações';


		//
		// busca as mensagens
		//
		$messages				       = $this->messages->get();


		//
		// parametro de pesquisa
		//
		$search_title					= 'Buscar';
		$search							= $this->input->get( 'search' );
		$search							= isset( $search ) ? $search : $search_title;
		$searched						= ( $search != $search_title );


		//
		// busca os registros, para pegar a quantidade de registros
		//
		$records = new Operation();
		$records->where( 'removed <', 1 );

		if ( $searched )
		{
			$records->ilike( 'id', $search );
		}
		$records->get();


		//
		// salva a consulta na variável de sessão 
		//
		$this->load->helper( 'hash' );
		$filter_hash			= hash::generate();

		$filter					= $this->session->userdata( 'filter' );
		$filter[ $filter_hash ]	= end( $records->db->queries );

		$this->session->set_userdata( 'filter', $filter );


		//
		// monta a configuração da paginação
		//
		$record_count					= $records->result_count();
		$current_page					= $this->input->get( 'page' );
		$current_page					= is_numeric( $current_page ) ? $current_page : 1;
		$page_size						= 20;
		$offset							= $page_size * ( $current_page-1 );


		//
		// carrega a biblioteca de paginação
		//	passando a configuração
		//
		$this->load->library( 'pagination' );
		$this->pagination->initialize( array(
				'base_url'		=> $url,
				'total_rows'	=> $record_count,
				'cur_page'		=> $current_page,
				'per_page'		=> $page_size,
				'num_links'		=> $record_count / $page_size
			)
		);


		//
		// busca os dados para listar caso a quantidade de
		//	registros seja maior do que o tamanho da página
		//
		if ( $record_count > $page_size )
		{
			$records = new Operation();
    	    $records->where( 'removed <', 1 );

			if ( $searched )
			{
				$records->ilike( 'id', $search );
			}
			$records->limit( $page_size, $offset );
			$records->get();
		}


		//
		// passa os dados para a view
		//
		$data = array(
			'search'			=> $search,
			'messages'			=> $messages,
			'filter_hash'		=> $filter_hash,
			'record_count'		=> $record_count,
			'records'  			=> $records,
			'permitted_actions'	=> array(
				'save',
				'remove',
				'export'
			),
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
		$this->load->view( 'manager/operations/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function save( $id = NULL )
	{
		//
		// configuração básica da página
		//
		//
		$uri							= 'operations/';
		$url							= $this->url . $uri;
		$title							= 'Operações';


		//
		// busca as mensagens
		//
		$messages				       = $this->messages->get();


		//
		// verifica se é um novo registro
		//
		$is_new			= !is_numeric( $id );


		//
		// popula os campos para exibir
		//
		$fields			= array(
			'id'				=> '',
			'product_id'		=> '',
			'customer_id'		=> '',
			'realtor_id'		=> '',
			'transaction_type'	=> '',
			'value'				=> '',
			'date_start'		=> '',
			'date_end'			=> ''
		);


		//
		// popula a lista de clientes
		//
		$products = new Product();
		$products->where( 'removed <', 1 );
		$products->get();


		//
		// popula a lista de clientes
		//
		$customers = new Customer();
		$customers->where( 'removed <', 1 );
		$customers->get();


		//
		// popula a lista de clientes
		//
		$realtors = new Realtor();
		$realtors->where( 'removed <', 1 );
		$realtors->get();


		//
		// popula lista de tipos de transações
		//
		$record				= new Operation();
		$transaction_types	= $record->get_transaction_type();


		//
		// busca o registro
		//
		if ( !$is_new )
		{
			$record->where( 'id',			$id );
			$record->where( 'removed <',	1 );
			$record->include_related( 'product',	'id' );
			$record->include_related( 'customer',	'id' );
			$record->include_related( 'realtor',	'id' );
			$record->get();

			if ( $record->result_count() > 0 )
			{
				$fields = array(
					'id'				=> $record->id,
					'product_id'		=> $record->product_id,
					'customer_id'		=> $record->customer_id,
					'realtor_id'		=> $record->realtor_id,
					'transaction_type'	=> $record->transaction_type,
					'value'				=> $record->value,
					'date_start'		=> $record->date_start,
					'date_end'			=> $record->date_end
				);
			}
		}


		//
		// passa os dados para a view
		//
		$data = array(
			'messages'			=> $messages,
			'is_new'  			=> $is_new,
			'fields'  			=> $fields,
			'transaction_types'	=> $transaction_types,
			'products'			=> $products,
			'customers'			=> $customers,
			'realtors'			=> $realtors,
			'permitted_actions'	=> array(
				'save',
				'remove'
			),
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
		$this->load->view( 'manager/operations/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function update()
	{
		//
		// requisição de campos
		//
		$id					= $this->input->post( 'id' );
		$product_id			= $this->input->post( 'product_id' );
		$customer_id		= $this->input->post( 'customer_id' );
		$realtor_id			= $this->input->post( 'realtor_id' );
		$transaction_type	= $this->input->post( 'transaction_type' );
		$value				= $this->input->post( 'value' );
		$date_start			= $this->input->post( 'date_start' );
		$date_end			= $this->input->post( 'date_end' );


		//
		// verifica se é um novo registro
		//
		$is_new = !is_numeric( $id );


		//
		// verifica se é atualização ou inserção
		//
		$record = new Operation( $id );


		//
		// passa os dados para o registro
		//
		$record->product_id			= $product_id;
		$record->customer_id		= $customer_id;
		$record->realtor_id			= $realtor_id;
		$record->transaction_type	= $transaction_type;
		$record->value				= $value;
		$record->date_start			= ( !empty( $date_start ) ? format::datebr2datesql( $date_start ) : '' );
		$record->date_end			= ( !empty( $date_end )	? format::datebr2datesql( $date_end ) : '' );

		//
		// executa a ação
		//
		if ( $record->save() )
		{
			if ( $is_new )
			{
				$this->messages->add( 'Registro cadastrado com sucesso.', 'success' );
			}
			else
			{
				$this->messages->add( 'Registro alterado com sucesso.', 'success' );
			}
		}
		else
		{
			if ( $is_new )
			{
				$this->messages->add( 'Não foi possível cadastrar o registro.', 'error' );
			}
			else
			{
				$this->messages->add( 'Não foi possível alterar o registro.', 'error' );
			}
		}


		redirect( $this->url . 'operations/' );
	}


	public function remove( $id = NULL )
	{
		//
		// verifica se o usuário esta logado
		//
		$this->validate();


		//
		// recebe os dados
		//
		$ids			= $this->input->post( 'id' );


		//
		// verifica se é array
		//
		if ( is_array( $ids ) )
		{
			$data = array();

			//
			// monta o objeto para ação
			//
			$record = new Operation();
			$record->where_in( 'id', $ids );
			$record->get();


			//
			// executa a ação
			//
			if ( $record->delete_all() )
			{
				$this->messages->add( 'Registros removidos com sucesso.', 'success' );
			}
			else
			{
				$this->messages->add( 'Não foi possível remover os registros.', 'error' );
			}
		}
		elseif ( is_numeric( $id ) )
		{
			//
			// seleciona o registro
			//
			$record = new Operation( $id );


			//
			// executa a ação
			//
			if ( $record->delete() )
			{
				$this->messages->add( 'Registro removido com sucesso.', 'success' );
			}
			else
			{
				$this->messages->add( 'Não foi possível remover o registro.', 'error' );
			}
		}
		else
		{
		    $this->messages->add( 'Selecione algum registro.', 'warning' );
		}


		//
		// redireciona
		//
		redirect( $this->url . 'operations/' );
	}


	public function validate() // bool
	{
		$true_referer	= ( isset( $_SERVER[ 'HTTP_REFERER' ] ) ) ? $_SERVER[ 'HTTP_REFERER' ] : '';
		$referer		= $this->router->class . '/save';
		$host			= $_SERVER[ 'HTTP_HOST' ];


		//
		// verifica se a variavel7 logged esta definida como true
		//  ou se vem da página operations/save
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