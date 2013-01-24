<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Operation extends DataMapper
{
	public $model = 'operation';
	public $table = 'operations';

	public $default_order_by	= array( 'id' );
	public $has_one				= array( 'product', 'customer', 'realtor' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}


	public function get_transaction_type( $type = NULL )
	{
		$data = array( 'Venda', 'Aluguel' );

		if ( is_numeric( $type ) )
		{
			return $data[ $type ];
		}

		return $data;
	}


	public function get_per_sale( $parameters, $limit = 50 )
	{
		$records	= new $this;


		//
		// verifica os parametros dos filtros recebidos
		//
		$param_select	= '';
		$param_where	= '';
		$param_group_by	= '';
		$param_order_by	= '';
		$pereiod		= $parameters[ 'period' ];
		$date_start		= date( 'Y-m-d H:i:s' );
		$date_end		= date( 'Y-m-d H:i:s' );


		if( !empty( $parameters[ 'date_start' ] ) )
		{
			if(  !empty( $parameters[ 'date_end' ] ) )
			{
				$date_end	= format::datebr2sql( $parameters[ 'date_end' ] );
			}

			$date_start	= format::datebr2sql( $parameters[ 'date_start' ] );
		}


		//
		// monta os parametros
		//
		switch ( $pereiod )
		{
			case 'year':
				$param_select	= ', YEAR( operations.created ) AS date';
				$param_where	= ' AND YEAR( operations.created ) >= YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND YEAR( operations.created ) < YEAR( date_add( "' . $date_end . '", INTERVAL 1 YEAR ) )';
				$param_group_by	= ' YEAR( operations.created )';
				$param_order_by	= ' YEAR( operations.created )';
				break;

			case 'month':
				$param_select	= ', DATE_FORMAT( operations.created, "%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( operations.created ) = YEAR( "' . $date_start . '" )';
				$param_group_by	= ' YEAR( operations.created ), MONTH( operations.created )';
				$param_order_by	= ' YEAR( operations.created ), MONTH( operations.created )';
				break;

			case 'day':
				$param_select	= ', DATE_FORMAT( operations.created, "%d/%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( operations.created ) = YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND MONTH( operations.created ) = MONTH( "' . $date_start . '" ) ';
				$param_group_by	= ' YEAR( operations.created ), MONTH( operations.created ), DAY( operations.created )';
				$param_order_by	= ' YEAR( operations.created ), MONTH( operations.created ), DAY( operations.created )';
				break;

			default:
				$param_where	= ' AND operations.created >= "' . $date_start . '"';
				$param_where	.= ' AND operations.created <= date_add( "' . $date_end . '", INTERVAL 1 DAY )';
				$param_group_by	= ' operations.id';
				$param_order_by = ' title';
				break;
		}


		//
		// busca dos relatórios
		//
		$query = '
			SELECT
				"" AS title,
				"" AS number,
				"" AS percent,
				( SELECT COUNT( id )FROM operations WHERE removed < 1 ' . $param_where . ' ) AS total
				' . $param_select . '
			FROM
				operations
			WHERE
				operations.removed < 1 AND
				operations.transaction_type = 0
				' . $param_where . '
			GROUP BY
				' . $param_group_by . '
			ORDER BY
				' . $param_order_by . '
			LIMIT
				 ' . $limit
		;

		$records->query( $query );


		//
		// popula as legendas
		//
		$legends = (object) array(
			'subtitle'		=> 'Operações - Venda',
			'table_headers'	=> array(
					'Período',
					'Vendas')
		 );


		//
		// popula os filtros
		//
		$this->load->library( 'filter' );
		$filter = new Filter();
		$filter->add( new Field( 'Período:', 'period', 'radio', array( 'Diário' => 'day', 'Mensal' => 'month', 'Anual' => 'year' ) ) );
		$filter->add( new Field( 'Data Inicial:', 'date_start', 'datepicker', format::datetime2date( $date_start ) ) );
		$filter->add( new Field( 'Data Final:', 'date_end', 'datepicker', format::datetime2date( $date_end ) ) );
		$filters = $filter->build( $filter );


		$result = array(
			'records'	=> $records,
			'filters'	=> $filters,
			'legends'	=> $legends,
			'query'		=> $query
		);


		return (object) $result;
	}


	public function get_per_rent( $parameters, $limit = 50 )
	{
		$records	= new $this;


		//
		// verifica os parametros dos filtros recebidos
		//
		$param_select	= '';
		$param_where	= '';
		$param_group_by	= '';
		$param_order_by	= '';
		$pereiod		= $parameters[ 'period' ];
		$date_start		= date( 'Y-m-d H:i:s' );
		$date_end		= date( 'Y-m-d H:i:s' );


		if( !empty( $parameters[ 'date_start' ] ) )
		{
			if(  !empty( $parameters[ 'date_end' ] ) )
			{
				$date_end	= format::datebr2sql( $parameters[ 'date_end' ] );
			}

			$date_start	= format::datebr2sql( $parameters[ 'date_start' ] );
		}


		//
		// monta os parametros
		//
		switch ( $pereiod )
		{
			case 'year':
				$param_select	= ', YEAR( operations.created ) AS date';
				$param_where	= ' AND YEAR( operations.created ) >= YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND YEAR( operations.created ) < YEAR( date_add( "' . $date_end . '", INTERVAL 1 YEAR ) )';
				$param_group_by	= ' YEAR( operations.created )';
				$param_order_by	= ' YEAR( operations.created )';
				break;

			case 'month':
				$param_select	= ', DATE_FORMAT( operations.created, "%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( operations.created ) = YEAR( "' . $date_start . '" )';
				$param_group_by	= ' YEAR( operations.created ), MONTH( operations.created )';
				$param_order_by	= ' YEAR( operations.created ), MONTH( operations.created )';
				break;

			case 'day':
				$param_select	= ', DATE_FORMAT( operations.created, "%d/%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( operations.created ) = YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND MONTH( operations.created ) = MONTH( "' . $date_start . '" ) ';
				$param_group_by	= ' YEAR( operations.created ), MONTH( operations.created ), DAY( operations.created )';
				$param_order_by	= ' YEAR( operations.created ), MONTH( operations.created ), DAY( operations.created )';
				break;

			default:
				$param_where	= ' AND operations.created >= "' . $date_start . '"';
				$param_where	.= ' AND operations.created <= date_add( "' . $date_end . '", INTERVAL 1 DAY )';
				$param_group_by	= ' operations.id';
				$param_order_by = ' title';
				break;
		}


		//
		// busca dos relatórios
		//
		$query = '
			SELECT
				"" AS title,
				"" AS number,
				"" AS percent,
				( SELECT COUNT( id )FROM operations WHERE removed < 1 ' . $param_where . ' ) AS total
				' . $param_select . '
			FROM
				operations
			WHERE
				operations.removed < 1 AND
				operations.transaction_type = 1
				' . $param_where . '
			GROUP BY
				' . $param_group_by . '
			ORDER BY
				' . $param_order_by . '
			LIMIT
				 ' . $limit
		;

		$records->query( $query );


		//
		// popula as legendas
		//
		$legends = (object) array(
			'subtitle'		=> 'Operações - Aluguéis',
			'table_headers'	=> array(
					'Período',
					'Aluguéis')
		 );


		//
		// popula os filtros
		//
		$this->load->library( 'filter' );
		$filter = new Filter();
		$filter->add( new Field( 'Período:', 'period', 'radio', array( 'Diário' => 'day', 'Mensal' => 'month', 'Anual' => 'year' ) ) );
		$filter->add( new Field( 'Data Inicial:', 'date_start', 'datepicker', format::datetime2date( $date_start ) ) );
		$filter->add( new Field( 'Data Final:', 'date_end', 'datepicker', format::datetime2date( $date_end ) ) );
		$filters = $filter->build( $filter );


		$result = array(
			'records'	=> $records,
			'filters'	=> $filters,
			'legends'	=> $legends,
			'query'		=> $query
		);


		return (object) $result;
	}
}