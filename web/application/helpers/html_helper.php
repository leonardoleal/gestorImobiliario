<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class html
{
	public static function is_checked( $checked ) // string
	{
		if ( $checked == 1 OR $checked === TRUE OR $checked == '1' )
		{
			return ' checked="checked"';
		}
		else
		{
			return '';
		}
	}

	public static function is_selected( $selected ) // string
	{
		if ( $selected == 1 OR $selected === TRUE OR $selected == '1' )
		{
			return ' selected="selected"';
		}
		else
		{
			return '';
		}
	}

	public static function is_active_page( $page ) // string
	{
		if ( class_exists( $page ) )
		{
			return ' active';
		}
		else
		{
			return '';
		}
	}

	public static function get_file_by_ext( $path, $name, $extensions )
	{
		foreach( $extensions as $extension )
		{
			if ( file_exists( $path . $name . '.' . $extension ) )
			{
				return $name . '.' . $extension;
			}
		}

		return FALSE;
	}

	public static function attribute( $attribute, $value )
	{
		if ( $attribute != NULL )
		{
			return ' ' . $attribute . '="' . $value . '"';
		}
		else
		{
			return '';
		}
	}

	public static function ie_attribute( $attribute, $value )
	{
		if ( $attribute != NULL AND html::is_ie() )
		{
			return html::attribute( $attribute, $value );
		}
		else
		{
			return '';
		}
	}

	public static function ie_tag( $tag, $class = NULL )
	{
		if ( html::is_ie() )
		{
			return '<div'. html::attribute( 'class', $tag . ' ' . $class ) . '>';
		}
	}


	public static function ie_tag_close( $tag = 'div' )
	{
		if ( html::is_ie() )
		{
			return '</' . $tag . '>';
		}
	}

	public static function is_ie()
	{
		if ( isset( $_SERVER[ 'HTTP_USER_AGENT' ] ) AND ( strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 8' ) !== FALSE XOR strpos( $_SERVER[ 'HTTP_USER_AGENT' ], 'MSIE 7' ) !== FALSE ) )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public static function write( $string )
	{
		echo htmlspecialchars( $string );
	}

	public static function write_html( $string )
	{
		echo $string;
	}

	public static function write_text_area( $string )
	{
		echo nl2br( $string );
	}

	public static function write_url( $string )
	{
		echo site::strclean( $string );
	}
}