<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Filter
{
	public $fields = array();

	public function add( Field $field )
	{
		array_push( $this->fields , $field );
	}

	public function build( Filter $filter )
	{
		$html = '';

		foreach ( $filter->fields as $field )
		{
			$html .= $this->create_field( $field );
		}
		
		return $html;
	}

	private function create_field( Field $field )
	{
		$html = '<p>';

		// cria label
		$html .= '<label><span>' . $field->title . '</span></label>';
		
		// cria input ou select
		$html .= $this->html_field( $field->name, $field->type, $field->value );

		$html .= '</p>';

		return $html;
	}

	public function html_field( $name, $type, $value )
	{
		$html = '';

		switch ( $type )
		{
			case 'input':
				$html = '<input type="text" class="text big" name="' . $name . '" value="' . $value . '">';
				break;

			case 'select':
				$html = '<select name="' . $name . '">';

				$values = $value;

				foreach( $values as $title => $value )
				{
					$html .= '<option value="' . $value . '">' . $title . '</option>';
				}

				$html .= '</select>';
				break;

			case 'radio':
				$values = $value;

				$i = 0;
				foreach( $values as $title => $value )
				{
					$html .= '<label><input type="radio" name="' . $name . '" value="' . $value . '" '. ( ( $i == 0 ) ? 'checked' : '' ) .'>' . $title . '</label>';
					$i++;
				}
				break;

			case 'datepicker':
				$html = '<input type="text" class="text date_picker" name="' . $name . '" value="' . $value . '">';
				break;
		}
		
		return $html;
	}
}


class Field
{
	public $title;
	public $type;
	public $name;
	public $value;

	/*
	 * @param $title	string
	 * @param $name		string
	 * @param $type		string
	 * @param $value	mixed 
	 */
	function __construct( $title = NULL, $name = NULL, $type = NULL, $value = NULL )
	{
		$this->title	= $title;
		$this->name		= $name;
		$this->type		= $type;
		$this->value	= $value;
	}
}