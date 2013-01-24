<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Users extends CI_Controller
{
	public $url;

	public function __construct()
	{
		parent::__construct();

		$this->load->library( 'messages' );

		$this->url = base_url() . $this->config->item( 'manager_uri' );
	}


    public function index()
	{
		//
		// verifica se o usuário esta logado
		//
        $this->validate();


		//
		// configuração básica da página
		//
		$uri							= 'users/';
		$url							= $this->url . $uri;
		$title							= 'Usuários';


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
		$records = new User();
		$records->where( 'removed <', 1 );
		if ( $searched )
		{
			$records->ilike( 'name', $search );
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
	        $records = new User();
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
		$this->load->view( 'manager/users/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function update()
	{
		//
		// verifica se o usuário esta logado
		//
        $this->validate();


		//
		// requisição de campos
		//
		$id			= $this->input->post( 'id' );
		$name		= $this->input->post( 'name' );
		$email		= $this->input->post( 'email' );
		$login		= $this->input->post( 'login' );
		$password	= $this->input->post( 'password' );


		//
		// carrega o model
		//
		$is_new = !is_numeric( $id );


		//
		// verifica se é atualização ou inserção
		//
		$record = new User( $id );


		//
		// passa os dados para o registro
		//
		$record->name	= $name;
		$record->email	= $email;
		$record->login	= $login;


		//
		// verifica se a senha foi informada
		//
		if ( !empty( $password ) )
		{
			$record->password = md5( $password );
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


        //
        // redireciona
        //
        redirect( $this->url . 'users/' );
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
/*        $ids   = $this->input->post( 'id' );


        if ( isset( $ids ) )
        {
            if ( is_array( $ids ) )
            {
				$data = array();

                //
                // monta o objeto para atualizar
                //
                foreach( $ids as $id )
                {
                    $info = array(
                        'id'		=> $id,
                        'removed'	=> $participant
                    );

					array_push( $data, $info );
                }


                //
                // executa a atualização
                //
                if ( $this->db->update_batch( 'participants', $data, 'id' ) === NULL )
                {
                    $this->messages->add( 'Registro(s) removido(s) com sucesso.', 'success' );
                }
                else
                {
                    $this->messages->add( 'Não foi possível remover o(s) registro(s).', 'error' );
                }
            }
            else
            {*/
				//
				// verifica se é atualização ou inserção
				//
				$record = new User( $id );


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
           /* }
        }
        else
        {
            $this->messages->add( 'Selecione algum registro.', 'warning' );
        }*/


        //
        // redireciona
        //
        redirect( $this->url . 'users/' );
	}


	public function save( $id = NULL )
	{
		//
		// verifica se o usuário esta logado
		//
		$this->validate();


		//
		// configuração básica da página
		//
		$uri						= 'users/';
		$url						= $this->url . $uri;
		$title					= 'Usuário';


		//
		// busca as mensagens
		//
		$messages                       = $this->messages->get();


		//
		// verifica se é edição ou cadastro
		//
		$is_new		= !$id;


		//
		// popula os campos para exibir
		//
		$fields = array(
			'id'		=> '',
			'name'		=> '',
			'email'		=> '',
			'login'		=> ''
		);

		
		//
		// busca o registro
		//
		if ( !$is_new )
		{
			$record = new User();
			$record->where( 'id',			$id );
			$record->where( 'removed <',	1 );
			$record = $record->get();

			if ( $record->result_count() > 0 )
			{
				$fields = array(
					'id'		=> $record->id,
					'name'		=> $record->name,
					'email'		=> $record->email,
					'login'		=> $record->login
				);
			}
		}


		//
		// passa os dados para a view
		//
        $data = array(
			'messages'			=> $messages,
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
		$this->load->view( 'manager/users/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function test()
	{
		//
		// carrega os dados do login
		//
		$login		= $this->input->post( 'login' );
		$password	= $this->input->post( 'password' );


		//
		// verifica se os dados foram passados
		//
		if ( !empty( $login ) && !empty( $password ) )
		{
			//
			// carrega o model
			//
			$user = new User();


			//
			// chama o metodo que consulta o banco e verifica se os dados estao corretos
			//
			if ( $user->test( $login, $password ) )
			{
				//
				// busca os dados do usuário
				//
				$this->set_user( $login, $password );


				//
				// define a mensagem de ok
				//
				$this->messages->add( 'Seja bem vindo ao sistema administrativo.', 'success' );


				//
				// redireciona para a pagina de padrão
				//
				redirect( $this->url . $this->config->item( 'manager_default_uri' ) );
			}
			else
			{
				//
				// limpa os dados do usuário
				//
				$this->unset_user();


				//
				// define o erro para mostrar a mensagem na tela
				//
				$this->messages->add( 'Usuário ou senha inváliados.', 'error' );


				//
				// redireciona para a pagina de login
				//
				redirect( base_url() . $this->config->item( 'manager_uri' ) );
			}
		}
		else
		{
			//
			// os dados não foram preenchidos
			//
			$this->messages->add( 'Preecha corretamente os campos.', 'warning' );


			//
			// redireciona para a pagina de padrão
			//
			redirect( $this->url );
		}
	}	


	public function login()
	{
		//
		// dados da página
		//
		$data				= array();


		//
		// controle das mensagens
		//
		$data[ 'messages' ]	= $this->messages->get();


		//
		// define o layout que será utilizado
		//
		$this->load->view( 'manager/layout/header' );
		$this->load->view( 'manager/users/login', $data );
		$this->load->view( 'manager/layout/footer' );
	}

	public function logout()
	{
		//
		// limpa os dados do usuario
		//
		$this->unset_user();


		//
		// redireciona para a pagina de login
		//
		redirect( $this->url );
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

	
	public function set_user( $login, $password ) // void
	{
		$user = new User();
		$user->where( 'login', $login );
		$user->where( 'password', md5( $password ) );
		$user->where( 'removed <', 1 );
		$user = $user->get();


		//
		// variavel que define se o usuario esta logado
		//
		$this->session->set_userdata( 'manager.user.logged', 	TRUE );


		//
		// define os dados do usuario
		//
		$this->session->set_userdata( 'manager.user.id',		$user->id );
		$this->session->set_userdata( 'manager.user.name',		$user->name );
		$this->session->set_userdata( 'manager.user.login',		$user->login );
		$this->session->set_userdata( 'manager.user.level',		$user->level );
	}

	public function unset_user() // void
	{
		//
		// limpa variavel que define se o usuario esta logado
		//
		$this->session->unset_userdata( 'manager.user.logged' );

		//
		// limpa os dados do usuario
		//
		$this->session->unset_userdata( 'manager.user.id' );
		$this->session->unset_userdata( 'manager.user.name' );
		$this->session->unset_userdata( 'manager.user.login' );
		$this->session->unset_userdata( 'manager.user.level' );
	}
}