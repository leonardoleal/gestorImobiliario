<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Pages extends CI_Controller
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
		$uri							= 'pages/';
		$url							= $this->url . $uri;
		$title							= 'Páginas';


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
		$records = new Page();
		$records->where( 'removed <', 1 );
		$records->where( 'parent_id IS NULL' );
		if ( $searched )
		{
			$records->ilike( 'title', $search );
		}
		$records->get();


		//
		// busca páginas filhas
		//
		foreach( $records as $record )
		{
			$record->children	= array();
			$childrens			= new Page();

			$childrens->where( 'removed <', 1 );
			$childrens->where( 'parent_id', $record->id );
			$childrens->get();

			if ( $childrens->result_count() > 0 )
			{
				$record->children = $childrens;
			}
		}


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
	        $records = new Page();
    	    $records->where( 'removed <', 1 );
    	    $records->where( 'parent_id IS NULL' );
			if ( $searched )
			{
				$records->ilike( 'title', $search );
			}
			$records->limit( $page_size, $offset );
			$records->get();


			//
			// busca páginas filhas
			//
			foreach( $records as $record )
			{
				$record->children	= array();
				$childrens			= new Page();

				$childrens->where( 'removed <', 1 );
				$childrens->where( 'parent_id', $record->id );
				$childrens->get();

				if ( $childrens->result_count() > 0 )
				{
					array_push( $record->children, $childrens );
				}
			}
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
		$this->load->view( 'manager/pages/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function save( $id = NULL )
	{
		//
		// configuração básica da página
		//
		$uri							= 'pages/';
		$url							= $this->url . $uri;
		$title							= 'Páginas';


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
			'parent_id'	=> '',
			'alias'		=> '',
			'content'	=> ''
		);


		//
		// popula o campo "paginas superior"
		//
		$pages = new Page();
		$pages->where( 'removed <',	1 );
		$pages->where( 'parent_id IS NULL' );
		if ( !empty( $id ) )
		{
			$pages->where( 'id !=', $id );
		}
		$pages->get();


		//
		// busca o registro
		//
		if ( !$is_new )
		{
			$record = new Page();
			$record->where( 'removed <',	1 );
			$record->where( 'id',			$id );
			$record = $record->get();

			if ( $record->result_count() > 0 )
			{
				$fields = array(
					'id'		=> $record->id,
					'parent_id'	=> $record->parent_id,
					'alias'		=> $record->alias,
					'content'	=> $record->content
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
        	'pages'				=> $pages,
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
		$this->load->view( 'manager/pages/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function update()
	{
		//
		// requisição de campos
		//
		$id			= $this->input->post( 'id' );
		$parent_id	= $this->input->post( 'parent_id' );
		$parent_id	= $parent_id ? : NULL;
		$alias		= $this->input->post( 'alias' );
		$title		= site::strclean( $alias );
		$content	= $this->input->post( 'content' );


		//
		// verifica se o nome da página não é igual as paginas padrões
		//
		$default_pages = array( 'home', 'contato', 'contact', 'manager', 'imoveis', 'products' );

		if ( in_array( site::strclean( $title ), $default_pages ) )
		{
			$this->messages->add( 'O nome da página não pode ser: Home, Contato, Manager e Imóveis.', 'error' );
			redirect( $this->url . 'pages/' );
		}


		//
		// verifica se ja existe um registro com o mesmo title
		//
		$record = new Page();
		$record->where( 'removed <', 1 );
		$record->where( 'title', $title );
		$record->where( 'id !=', $id );
		$record->get();
		if ( $record->result_count() > 0 )
		{
			$this->messages->add( 'Não foi possível criar o registro, tente com outro nome', 'warning' );
		}
		else
		{
			//
			// verifica se é um novo registro
			//
			$is_new = !is_numeric( $id );


			//
			// verifica se é atualização ou inserção
			//
			$record = new Page( $id );


			//
			// passa os dados para o registro
			//
			$record->parent_id	= $parent_id;
			$record->alias		= $alias;
			$record->title		= $title;
			$record->content	= $content;

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
		}

		redirect( $this->url . 'pages/' );
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
			$record = new Page();
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
			$record = new Page( $id );


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
        redirect( $this->url . 'pages/' );
	}


	public function upload_view()
	{
		//
		// configuração básica da página
		//
		$uri							= 'pages/';
		$url							= $this->url . $uri;
		$title							= 'Upload';
	
	
		//
		// busca as mensagens
		//
		$messages                       = $this->messages->get();


		//
		// passa os dados para a view
		//
		$data = array(
			'messages'			=> $messages,
			'page'				=> array(
				'uri'				=> $uri,
				'url'				=> $url,
				'title' 			=> $title
			),
			'has_uploaded'	=> FALSE
		);


		//
		// define o layout que será utilizado
		//
		$this->load->view( 'manager/layout/header' );
		$this->load->view( 'manager/pages/image_upload', $data );
	}

	public function upload_image()
	{
		//
		// configuração básica da página
		//
		$uri						= 'pages/';
		$url						= $this->url . $uri;
		$title						= 'Upload';
		$config[ 'upload_path' ]	= $this->application->images_path;
		$config[ 'allowed_types' ]	= 'jpg|gif|jpeg|png';
		$config[ 'overwrite' ]		= FALSE;
		$config[ 'file_name' ]		= rand() . '_' . rand();


		$this->load->library( 'upload', $config );
		$this->load->helper( 'html' );



		if ( $this->upload->do_upload( 'image' ) )
		{
			$this->messages->add( 'Aguarde... finalizando o upload.', 'success' );

			$image		= $this->application->images_url . html::get_file_by_ext( $this->application->images_path, $config[ 'file_name' ], array( 'jpg', 'gif', 'jpeg', 'png' ) );
		}
		else
		{
			$this->messages->add( 'Erro durante o upload.', 'error' );
			$image		= NULL;
		}


		//
		// busca as mensagens
		//
		$messages                       = $this->messages->get();
		
		
		//
		// passa os dados para a view
		//
		$data = array(
			'messages'			=> $messages,
			'image'			=> $image,
			'has_uploaded'	=> TRUE,
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
		$this->load->view( 'manager/pages/image_upload', $data );
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