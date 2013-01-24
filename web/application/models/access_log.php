<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Access_log extends DataMapper
{
	public $model = 'access_log';
	public $table = 'access_logs';

	public $default_order_by	= array( 'id' );


	function __construct( $id = NULL )
	{
		parent::__construct( $id );

		$this->load->library( 'filter' );
	}


	public function get_per_page( $parameters, $limit = 50 )
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
				$param_select	= ', YEAR( access_logs.created ) AS date';
				$param_where	= ' AND YEAR( access_logs.created ) >= YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND YEAR( access_logs.created ) < YEAR( date_add( "' . $date_end . '", INTERVAL 1 YEAR ) )';
				$param_group_by	= ', YEAR( access_logs.created )';
				$param_order_by	= ' YEAR( access_logs.created )';
				break;

			case 'month':
				$param_select	= ', DATE_FORMAT( access_logs.created, "%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( access_logs.created ) = YEAR( "' . $date_start . '" )';
				$param_group_by	= ', YEAR( access_logs.created ), MONTH( access_logs.created )';
				$param_order_by	= ' YEAR( access_logs.created ), MONTH( access_logs.created )';
				break;

			case 'day':
				$param_select	= ', DATE_FORMAT( access_logs.created, "%d/%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( access_logs.created ) = YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND MONTH( access_logs.created ) = MONTH( "' . $date_start . '" ) ';
				$param_group_by	= ', YEAR( access_logs.created ), MONTH( access_logs.created ), DAY( access_logs.created )';
				$param_order_by	= ' YEAR( access_logs.created ), MONTH( access_logs.created ), DAY( access_logs.created )';
				break;

			default:
				$param_where	= ' AND access_logs.created >= "' . $date_start . '"';
				$param_where	.= ' AND access_logs.created <= date_add( "' . $date_end . '", INTERVAL 1 DAY )';
				$param_order_by = ' title';
				break;
		}


		//
		// busca dos relatórios
		//
		$query = '
			SELECT
				CONCAT( UCASE( LEFT( page, 1 ) ),LCASE( SUBSTRING( page, 2) ) ) AS title,
				CONCAT( COUNT( page ), " Visitas" ) AS number,
				CONCAT( ROUND( COUNT( page ) * 100 / ( SELECT COUNT( id ) FROM access_logs WHERE removed < 1 ' . $param_where . ' ), 2 ), "%") AS percent,
				( SELECT COUNT( id )FROM access_logs WHERE removed < 1 ' . $param_where . ' ) AS total
				' . $param_select . '
			FROM
				access_logs
			WHERE
				access_logs.removed < 1
				' . $param_where . '
			GROUP BY
				access_logs.page
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
			'subtitle'		=> 'Acessos x Página',
			'table_headers'	=> array(
					'Página',
					'Acessos')
		 );


		//
		// popula os filtros
		//
		$filter = new Filter();
		$filter->add( new Field( 'Período:', 'period', 'radio', array( 'Padrão' => 'none', 'Diário' => 'day', 'Mensal' => 'month', 'Anual' => 'year' ) ) );
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


	public function get_per_product( $parameters, $limit = 50 )
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
				$param_select	= ', YEAR( access_logs.created ) AS date';
				$param_where	= ' AND YEAR( access_logs.created ) >= YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND YEAR( access_logs.created ) < YEAR( date_add( "' . $date_end . '", INTERVAL 1 YEAR ) )';
				$param_group_by	= ', YEAR( access_logs.created )';
				$param_order_by	= ' YEAR( access_logs.created )';
				break;

			case 'month':
				$param_select	= ', DATE_FORMAT( access_logs.created, "%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( access_logs.created ) = YEAR( "' . $date_start . '" )';
				$param_group_by	= ', YEAR( access_logs.created ), MONTH( access_logs.created )';
				$param_order_by	= ' YEAR( access_logs.created ), MONTH( access_logs.created )';
				break;

			case 'day':
				$param_select	= ', DATE_FORMAT( access_logs.created, "%d/%m/%Y" ) AS date';
				$param_where	= ' AND YEAR( access_logs.created ) = YEAR( "' . $date_start . '" )';
				$param_where	.= ' AND MONTH( access_logs.created ) = MONTH( "' . $date_start . '" ) ';
				$param_group_by	= ', YEAR( access_logs.created ), MONTH( access_logs.created ), DAY( access_logs.created )';
				$param_order_by	= ' YEAR( access_logs.created ), MONTH( access_logs.created ), DAY( access_logs.created )';
				break;

			default:
				$param_where	= ' AND access_logs.created >= "' . $date_start . '"';
				$param_where	.= ' AND access_logs.created <= date_add( "' . $date_end . '", INTERVAL 1 DAY )';
				$param_order_by = ' product_id';
				break;
		}


		//
		// busca dos relatórios
		//
		$query = '
			SELECT
				CONCAT( LPAD( product_id, 6, "0" ), " - ", c.name, " - ", n.name ) AS title,
				CONCAT( COUNT( page ), " Visitas" ) AS number,
				CONCAT( ROUND( COUNT( page ) * 100 / ( SELECT COUNT( id ) FROM access_logs WHERE removed < 1  AND `access_logs`.`product_id` IS NOT NULL ' . $param_where . ' ), 2 ), "%") AS percent,
				( SELECT COUNT( id ) FROM access_logs WHERE removed < 1 AND `access_logs`.`product_id` IS NOT NULL ' . $param_where . ' ) AS total
				' . $param_select . '
			FROM
				access_logs
			INNER JOIN
				products AS p
				ON
					p.id = access_logs.product_id
			INNER JOIN
				neighborhoods AS n
				ON
					n.id = p.neighborhood_id
			INNER JOIN
				cities AS c
				ON
					c.id = n.city_id
			WHERE
				access_logs.removed < 1
				AND product_id IS NOT NULL
				' . $param_where . '
			GROUP BY
				access_logs.product_id
				' . $param_group_by . '
			ORDER BY
				' . $param_order_by . '
			LIMIT
				' . $limit
		;


		$records->query( $query );

		$records->select('
				( SELECT COUNT( id ) FROM access_logs WHERE removed < 1 AND `access_logs`.`product_id` IS NOT NULL ' . $param_where . ' ) AS total
		', FALSE );


		//
		// popula as legendas
		//
		$legends = (object) array(
			'subtitle'		=> 'Acessos x Imóvel',
			'table_headers'	=> array(
					'Imóvel',
					'Acessos')
		 );


		//
		// popula os filtros
		//
		$filter = new Filter();
		$filter->add( new Field( 'Período:', 'period', 'radio', array( 'Padrão' => 'none', 'Diário' => 'day', 'Mensal' => 'month', 'Anual' => 'year' ) ) );
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