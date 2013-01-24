<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Tools extends CI_Controller
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
		$uri							= 'tools/';
		$url							= $this->url . $uri;
		$title							= 'Ferramentas';


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
		$records = new Tool();
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
			$records = new Tool();
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
		$this->load->view( 'manager/tools/index', $data );
		$this->load->view( 'manager/layout/footer' );
    }


	public function save( $id = NULL )
	{
		//
		// configuração básica da página
		//
		//
		$uri							= 'tools/';
		$url							= $this->url . $uri;
		$title							= 'Ferramentas';


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
		$cities			= array();
		$neighborhoods	= array();
		$product_photos	= array();
		$product_items	= array();
		$fields			= array(
			'id'				=> '',
			'customer_id'		=> '',
			'renter_id'			=> '',
			'neighborhood_id'	=> '',
			'state_id'			=> '',
			'city_id'			=> '',
			'value'				=> '',
			'description'		=> '',
			'type'				=> '',
			'transaction_type'	=> '',
			'zip_code'			=> '',
			'address'			=> '',
			'number'			=> '',
			'complement'		=> '',
			'pos_latitude'		=> '',
			'pos_longitude'		=> ''
		);


		//
		// popula a lista de categorias e items
		//
		$categories = new Category();
		$categories->include_related_count('category_item');
		$categories->where( 'removed <', 1 );
		$categories->having( 'category_item_count >', 0 );
		$categories->get();

		foreach( $categories as $category )
		{
			$category->category_item->where( 'removed <', 1 );
			$category->items = $category->category_item->get();
		}


		//
		// popula a lista de clientes
		//
		$customers = new Customer();
		$customers->where( 'removed <', 1 );
		$customers->get();


		//
		// popula a lista de estados
		//
		$states = new State();
		$states->where( 'removed <', 1 );
		$states->get();

		//
		// popula lista de tipos
		//
		$record = new Tool();
		$types = $record->get_type();


		//
		// popula lista de tipos de transações
		//
		$transaction_types = $record->get_transaction_type();


		//
		// busca o registro
		//
		if ( !$is_new )
		{
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
					'customer_id'		=> $record->customer_id,
					'renter_id'			=> $record->renter_id,
					'neighborhood_id'	=> $record->neighborhood_id,
					'city_id'			=> $record->city_id,
					'state_id'			=> $record->state_id,
					'value'				=> $record->value,
					'description'		=> $record->description,
					'type'				=> $record->type,
					'transaction_type'	=> $record->transaction_type,
					'zip_code'			=> $record->zip_code,
					'address'			=> $record->address,
					'number'			=> $record->number,
					'complement'		=> !empty( $record->complement ) ? $record->complement : '',
					'pos_latitude'		=> $record->pos_latitude,
					'pos_longitude'		=> $record->pos_longitude
				);

				//
				// busca os items da propriedade
				//
				$product_items = new Tool_category_item();
				$product_items->where( 'product_id', $record->id );
				$product_items->where( 'removed <', 1 );
				$product_items->get();


				//
				// transforma em um array único
				//
				$temp = array();
				foreach( $product_items as $item )
				{
					array_push( $temp, $item->category_item_id );
				}
				$product_items = $temp;
				unset( $temp );


				//
				// busca as fotos
				//
				$product_photos = new Tool_photo();
				$product_photos->where( 'product_id', $record->id );
				$product_photos->where( 'removed <', 1 );
				$product_photos->get();


				//
				// foreach 
				//
				foreach( $product_photos as $photo )
				{
					$photo->photo_t	= site::view_photo( $fields[ 'id' ], $photo->id . '_t', TRUE, FALSE );
					$photo->photo	= site::view_photo( $fields[ 'id' ], $photo->id, FALSE );
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
		}


		//
		// passa os dados para a view
		//
		$data = array(
			'messages'			=> $messages,
			'is_new'  			=> $is_new,
			'fields'  			=> $fields,
			'product_items'		=> $product_items,
			'product_photos'	=> $product_photos,
			'types'				=> $types,
			'transaction_types'	=> $transaction_types,
			'categories'		=> $categories,
			'customers'			=> $customers,
			'states'			=> $states,
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
		$this->load->view( 'manager/tools/save', $data );
		$this->load->view( 'manager/layout/footer' );		
	}


	public function update()
	{
		//
		// requisição de campos
		//
		$id					= $this->input->post( 'id' );
		$customer_id		= $this->input->post( 'customer_id' );
		$renter_id			= $this->input->post( 'renter_id' );
		$neighborhood_id	= $this->input->post( 'neighborhood_id' );
		$value				= $this->input->post( 'value' );
		$description		= $this->input->post( 'description' );
		$type				= $this->input->post( 'type' );
		$transaction_type	= $this->input->post( 'transaction_type' );
		$zip_code			= $this->input->post( 'zip_code' );
		$address			= $this->input->post( 'address' );
		$number				= $this->input->post( 'number' );
		$complement			= $this->input->post( 'complement' );
		$pos_latitude		= $this->input->post( 'pos_latitude' );
		$pos_longitude		= $this->input->post( 'pos_longitude' );
		$items				= $this->input->post( 'item' );


		//
		// verifica se é um novo registro
		//
		$is_new = !is_numeric( $id );


		//
		// verifica se é atualização ou inserção
		//
		$record = new Tool( $id );


		//
		// passa os dados para o registro
		//
		$record->customer_id		= $customer_id;
		$record->renter_id			= ( $transaction_type == 1 ) ? $renter_id : NULL;
		$record->neighborhood_id	= $neighborhood_id;
		$record->value				= format::decimalbr2sql( $value );
		$record->description		= $description;
		$record->type				= $type;
		$record->zip_code			= $zip_code;
		$record->address			= $address;
		$record->number				= $number;
		$record->complement			= $complement;
		$record->transaction_type	= $transaction_type;
		$record->pos_latitude		= $pos_latitude;
		$record->pos_longitude		= $pos_longitude;


		//
		// executa a ação
		//
		if ( $record->save() )
		{
			//
			// busca categorias atuais
			//
			$items_product = new Tool_category_item();
			$items_product->where( 'product_id', $record->id );
			$items_product->get();


			// remove valores em branco
			$items = array_filter( $items );


			//
			// verifica se deve excluir ou reativar item
			//
			if ( $items_product->result_count() > 0 )
			{
				foreach( $items_product as $item )
				{
					$key = array_search( $item->category_item_id, $items );

					if( is_numeric( $key ) )
					{
						if ( $item->removed > 0 )
						{
							$item->removed = '0000-00-00 00:00:00';
							$item->save();
						}

						unset( $items[ $key ] );
					}
					elseif ( is_bool( $key ) )
					{
						$item->delete();
					}
				}
			}


			//
			// insere novos itens
			//
			foreach( $items as $item )
			{
				$items_product->clear();
				$items_product->product_id = $record->id;
				$items_product->category_item_id = $item;
				$items_product->save();
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


		redirect( $this->url . 'tools/' );
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
			$record = new Tool();
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
			$record = new Tool( $id );


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
		redirect( $this->url . 'tools/' );
	}


	public function validate() // bool
	{
		$true_referer	= ( isset( $_SERVER[ 'HTTP_REFERER' ] ) ) ? $_SERVER[ 'HTTP_REFERER' ] : '';
		$referer		= $this->router->class . '/save';
		$host			= $_SERVER[ 'HTTP_HOST' ];


		//
		// verifica se a variavel7 logged esta definida como true
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