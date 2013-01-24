<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Categories extends CI_Controller
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
		$uri							= 'categories/';
		$url							= $this->url . $uri;
		$title							= 'Categorias';


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
		$records = new Category();
		$records->where( 'removed <', 1 );
		if ( $searched )
		{
			$records->ilike( 'title', $search );
		}
		$records->get();


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
	        $records = new Category();
    	    $records->where( 'removed <', 1 );
			if ( $searched )
			{
				$records->ilike( 'title', $search );
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
		$this->load->view( 'manager/categories/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function save( $id = NULL )
	{
		//
		// configuração básica da página
		//
		$uri							= 'categories/';
		$url							= $this->url . $uri;
		$title							= 'Categorias';


		//
		// busca as mensagens
		//
        $messages                       = $this->messages->get();


		//
		// verifica se é um novo registro
		//
		$is_new			= !is_numeric( $id );
		$records		= array();


		//
		// popula os campos para exibir
		//
		$fields = array(
			'id'		=> '',
			'title'		=> '',
			'type'		=> ''
		);


		//
		// busca o registro
		//
		$record = new Category();
		if ( !$is_new )
		{
			$record->where( 'id',			$id );
			$record->where( 'removed <',	1 );
			$record = $record->get();

			if ( $record->result_count() > 0 )
			{
				$fields = array(
					'id'		=> $record->id,
					'title'		=> $record->title,
					'type'		=> $record->type
				);


				$records = new Category_item();
				$records->where( 'category_id', $record->id );
				$records->where( 'removed <', 1 );
				$records->get();
			}
		}


		//
		// popula os tipos de categorias
		//
		$types = $record->get_type();


		//
		// passa os dados para a view
		//
        $data = array(
			'messages'			=> $messages,
        	'is_new'  			=> $is_new,
        	'fields'  			=> $fields,
        	'types'				=> $types,
        	'records'  			=> $records,
	        'permitted_actions'	=> array(
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
		$this->load->view( 'manager/categories/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function update()
	{
		//
		// requisição de campos
		//
		$id			= $this->input->post( 'id' );
		$title		= $this->input->post( 'title' );
		$type		= $this->input->post( 'type' );
		$item_id	= $this->input->post( 'item_id' );
		$item_title	= $this->input->post( 'item_title' );


		//
		// verifica se é um novo registro
		//
		$is_new = !is_numeric( $id );


		//
		// verifica se é atualização ou inserção
		//
		$record = new Category( $id );


		//
		// passa os dados para o registro
		//
		$record->title		= $title;
		$record->type		= $type;


		//
		// executa a ação
		//
		if ( $record->save() )
		{
			//
			// verifica se há itens
			//
			if( sizeof( $item_title ) > 1 )
			{
				$item_title = array_filter( $item_title );
				$records = new Category_item();
				foreach( $item_title as $key => $item )
				{
					//
					// verifica se é atualização
					//
					if ( isset( $item_id[ $key ] ) )
					{
						$records->where( 'id', $item_id[ $key ] );
						$records->get();
					}


					//
					// atribui os valores 
					//
					$records->category_id	= $record->id;
					$records->title			= $item;


					//
					// salva item
					//
					$records->save();
					$records->clear();
				}
			}


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

		redirect( $this->url . 'categories/save/' . $record->id );
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
			$record = new Category();
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
			$record = new Category( $id );


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
        redirect( $this->url . 'categories/' );
	}


	public function remove_item( $id )
	{
		//
		// verifica se o usuário esta logado
		//
        $this->validate();


		//
		// recebe os dados
		//
        $result			= FALSE;


		if ( is_numeric( $id ) )
		{
			//
			// seleciona o registro
			//
			$record = new Category_item( $id );


			//
			// executa a ação
			//
			if ( $record->delete() )
			{
		        $result	= TRUE;
			}
        }


        echo json_encode( $result );
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