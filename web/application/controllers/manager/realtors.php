<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Realtors extends CI_Controller
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
		$uri							= 'realtors/';
		$url							= $this->url . $uri;
		$title							= 'Corretores';


		//
		// busca as mensagens
		//
        $messages                       = $this->messages->get();


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
		$records = new Realtor();
		$records->where( 'removed <', 1 );

		if ( $searched )
		{
			$records->ilike( 'name', $search );
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
	        $records = new Realtor();
    	    $records->where( 'removed <', 1 );

			if ( $searched )
			{
				$records->ilike( 'name', $search );
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
		$this->load->view( 'manager/realtors/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function save( $id = NULL )
	{
		//
		// configuração básica da página
		//
		//
		$uri							= 'realtors/';
		$url							= $this->url . $uri;
		$title							= 'Corretores';


		//
		// busca as mensagens
		//
        $messages                       = $this->messages->get();


		//
		// verifica se é um novo registro
		//
		$is_new			= !is_numeric( $id );


		//
		// popula os campos para exibir
		//
		$cities			= array();
		$neighborhoods	= array();
		$fields			= array(
			'id'				=> '',
			'neighborhood_id'	=> '',
			'city_id'			=> '',
			'state_id'			=> '',
			'name'				=> '',
			'cpf'				=> '',
			'rg'				=> '',
			'zip_code'			=> '',
			'address'			=> '',
			'number'			=> '',
			'complement'		=> '',
			'email'				=> '',
			'phone'				=> '',
			'phone2'			=> '',
			'cellphone'			=> ''
		);


		//
		// popula a lista de estados
		//
		$states = new State();
		$states->where( 'removed <', 1 );
		$states->get();


		//
		// busca o registro
		//
		if ( !$is_new )
		{
			$record = new Realtor();
			$record->where( 'id',			$id );
			$record->where( 'removed <',	1 );
			$record->include_related( 'neighborhood', 'id' );
			$record->include_related( 'neighborhood/city', 'id', 'city' );
			$record->include_related( 'neighborhood/city/state', 'id', 'state' );
			$record->get();

			if ( $record->result_count() > 0 )
			{
				$fields = array(
					'id'				=> $record->id,
					'neighborhood_id'	=> $record->neighborhood_id,
					'city_id'			=> $record->city_id,
					'state_id'			=> $record->state_id,
					'name'				=> $record->name,
					'cpf'				=> $record->cpf,
					'rg'				=> $record->rg,
					'zip_code'			=> $record->zip_code,
					'address'			=> $record->address,
					'number'			=> $record->number,
					'complement'		=> !empty( $record->complement ) ? $record->complement : '',
					'email'				=> $record->email,
					'phone'				=> $record->phone,
					'phone2'			=> $record->phone2,
					'cellphone'			=> $record->cellphone
				);
			}


			//
			// popula a lista de cidades
			//
			$cities = new City();
			$cities->where( 'state_id', $record->state_id );
			$cities->where( 'removed <', 1 );
			$cities->get();


			//
			// popula a lista de bairros
			//
			$neighborhoods = new Neighborhood();
			$neighborhoods->where( 'city_id', $record->city_id );
			$neighborhoods->where( 'removed <', 1 );
			$neighborhoods->get();
		}


		//
		// passa os dados para a view
		//
        $data = array(
			'messages'			=> $messages,
        	'is_new'  			=> $is_new,
        	'fields'  			=> $fields,
        	'states'  			=> $states,
        	'cities'			=> $cities,
        	'neighborhoods'		=> $neighborhoods,
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
		$this->load->view( 'manager/realtors/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function update()
	{
		//
		// requisição de campos
		//
		$id					= $this->input->post( 'id' );
		$neighborhood_id	= $this->input->post( 'neighborhood_id' );
		$name				= $this->input->post( 'name' );
		$cpf				= $this->input->post( 'cpf' );
		$rg					= $this->input->post( 'rg' );
		$zip_code			= $this->input->post( 'zip_code' );
		$address			= $this->input->post( 'address' );
		$number				= $this->input->post( 'number' );
		$complement			= $this->input->post( 'complement' );
		$email				= $this->input->post( 'email' );
		$phone				= $this->input->post( 'phone' );
		$phone2				= $this->input->post( 'phone2' );
		$cellphone			= $this->input->post( 'cellphone' );

		//
		// verifica se é um novo registro
		//
		$is_new = !is_numeric( $id );


		//
		// verifica se é atualização ou inserção
		//
		$record = new Realtor( $id );


		//
		// passa os dados para o registro
		//
		$record->neighborhood_id	= $neighborhood_id;
		$record->name				= $name;
		$record->cpf				= $cpf;
		$record->rg					= $rg;
		$record->zip_code			= $zip_code;
		$record->address			= $address;
		$record->number				= $number;
		$record->complement			= $complement;
		$record->email				= $email;
		$record->phone				= $phone;
		$record->phone2				= $phone2;
		$record->cellphone			= $cellphone;


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


		redirect( $this->url . 'realtors/' );
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
			$record = new Realtor();
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
			$record = new Realtor( $id );


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
        redirect( $this->url . 'realtors/' );
	}


	public function export()
	{
		//
		// recebe o hash
		//
		$hash = $this->input->post( 'filter_hash' );


		if ( !empty( $hash ) )
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
			if ( export::to_excel( $query, 'Corretores' ) )
			{
				return TRUE;
			}
		}


		//
		// se cheagar aqui algo errado ocorreu
		//
		$this->messages->add( 'Não foi possível gerar o arquivo, nenhum registo encontrado.', 'error' );

		redirect( $this->url . 'realtors/' );
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