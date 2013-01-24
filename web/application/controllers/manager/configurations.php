<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Configurations extends CI_Controller
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
		$uri							= 'configurations/';
		$url							= $this->url . $uri;
		$title							= 'Configurações';


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
		$records = new Configuration();
		$records->include_related( 'configuration_group', NULL, TRUE, TRUE );
		$records->where( 'removed <', 1 );

		if ( $searched )
		{
			$records->ilike( 'alias', $search );
		}
		$records->order_by( 'configurations_groups.priority' );
		$records->get();

		$record_count	= $records->result_count();


		//
		// passa os dados para a view
		//
        $data = array(
			'search'			=> $search,
			'messages'			=> $messages,
			'record_count'		=> $record_count,
        	'records'  			=> $records,
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
		$this->load->view( 'manager/configurations/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


    public function save_new( $group_id = NULL )
    {
    	$this->save( NULL, $group_id );
    }


	public function save( $id = NULL, $group_id = NULL )
	{
		//
		// configuração básica da página
		//
		//
		$uri							= 'configurations/';
		$url							= $this->url . $uri;
		$title							= 'Configurações';


		//
		// busca as mensagens
		//
        $messages                       = $this->messages->get();


		//
		// verifica se é um novo registro
		//  sendo novo registro de possuir uma categoria
		//
		$is_new			= !is_numeric( $id );

		if ( $is_new  AND !is_numeric( $group_id ) )
		{
			$this->messages->add( 'Nenhum registro foi selecionado.', 'error' );
			redirect( $this->url . 'configurations' );
		}


		//
		// popula os campos para exibir
		//
		$fields = array(
			'id'			=> '',
			'alias'			=> '',
			'value'			=> ''
		);


		//
		// busca o registro
		//
		$record = new Configuration();
		$record->where( 'id',			$id );
		$record->where( 'removed <',	1 );
		$record = $record->get();
		
		if ( $record->result_count() > 0 )
		{
			$fields = array(
						'id'			=> $record->id,
						'alias'			=> $record->alias,
						'value'			=> $record->value
			);
		}


		//
		// passa os dados para a view
		//
        $data = array(
			'messages'			=> $messages,
        	'is_new'  			=> $is_new,
        	'group_id'  		=> $group_id,
        	'fields'  			=> $fields,
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
		$this->load->view( 'manager/configurations/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function update()
	{
		//
		// requisição de campos
		//
		$id				= $this->input->post( 'id' );
		$group_id		= $this->input->post( 'group_id' );
		$alias			= $this->input->post( 'alias' );
		$title			= site::strclean( $alias, '_' );
		$value			= $this->input->post( 'value' );


		//
		// verifica se é um novo registro
		//
		$is_new = !is_numeric( $id );


		//
		// verifica se é atualização ou inserção
		//
		$record = new Configuration( $id );


		//
		// verifica se não é variável de sistema
		//
		$is_system	= (int) $record->system;
		if ( !$is_system )
		{
			//
			// verifica se já existe um registro com o mesmo "title"
			//
			$check_config = new Configuration();
			$check_config->where( 'removed <', 1 );
			$check_config->where( 'title', $title );
			$check_config->where( 'id !=', $id );
			$check_config->get();
			if ( $check_config->result_count() > 0 )
			{
				$this->messages->add( 'Não foi possível criar o registro, tente com outro nome', 'warning' );
				redirect( $this->url . 'configurations/' );
			}
			unset( $check_config );

			
			$record->title		= $title;
		}


		//
		// passa os dados para o registro
		//
		$record->value			= $value;
		$record->alias			= $alias;


		//
		// se o grupo está vazio é porque este registro é edição e não pode ser alterado o grupo
		//
		if ( !empty( $group_id ) )
		{
			$record->configuration_group_id	= $group_id;
		}


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


		redirect( $this->url . 'configurations/' );
	}


	public function remove( $id = NULL )
	{
		//
		// verifica se o usuário esta logado
		//
		$this->validate();


		if ( is_numeric( $id ) )
		{
			//
			// seleciona o registro
			//
			$record = new Configuration( $id );


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
		redirect( $this->url . 'configurations/' );
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