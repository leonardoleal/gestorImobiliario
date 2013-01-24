<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Page extends DataMapper
{
	public $model = 'page';
	public $table = 'pages';

	public $default_order_by	= array( 'title' );
	public $has_many			= array(
		// self-referencing
		'page' => array(
			'class'			=> 'page',
			'join_table'	=> 'pages',
			'other_field'	=> 'parent'
		)
	);


	function __construct( $id = NULL )
	{
		parent::__construct( $id );
	}


	public function get_pages_links()
	{
		$html		= '';
		$records	= new $this;


		$records->where( 'removed <', 1 );
		$records->where( 'parent_id IS NULL' );
		$records->get();


		foreach( $records as $record )
		{
			$html .= '<a href="' . $record->title . '/">' . $record->alias . '</a> ';


			//
			// busca páginas filhas
			//
			$has_children	= false;
			$childrens		= new $this;
			$childrens->where( 'removed <', 1 );
			$childrens->where( 'parent_id', $record->id );
			$childrens->get();


			foreach( $childrens as $children )
			{
				if ( !$has_children )
				{
					$html .= '<div>';
					$has_children = 1;
				}

				$html .= '<a href="' . $children->title . '/">' . $children->alias . '</a> ';
			}


			if ( $has_children )
			{
				$html .= '</div>';
			}
		}


		return !empty( $html ) ?  $html : false ;
	}
}