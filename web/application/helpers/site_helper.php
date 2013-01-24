<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class site
{
	public static function is_current_section( $section = 'a' )
	{
//		echo(uri_string());
/*		if ( strpos( current_url(), $section ) === FALSE )
		{
			return '';
		}
		else
		{
			return ' Active';
		}*/
	}

	public static function strclean( $str, $replacement = '-' )
	{
		$a		= 'ÆÐØÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýýþÿŔŕ';
		$b		= 'ADObsaaaaaaaceeeeiiiidnoooooouuuuyybyrr';
		$clean	= utf8_decode( $str );
		$clean	= strtr( $clean, utf8_decode( $a ), $b );
		$clean	= utf8_encode( $clean );


		$clean	= preg_replace( "/[^a-zA-Z0-9\/_|+ -]/", '', $clean );
		$clean	= strtolower( trim( $clean, '-' ) );
		$clean	= preg_replace( "/[\/_|+ -]+/", $replacement, $clean );

		return $clean;
	}	
	
	public static function is_admin()
	{
		$_ci = get_instance();
		return ( $_ci->session->userdata( 'manager.user.level' ) == 1 );
	}
	
	public static function project_photo_info( $project_id, $photo_id, $size = 'm' )
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file_path		= $ci->application->projects_path . $project_id;
		$file_name		= html::get_file_by_ext( $file_path, $photo_id , array( 'jpg', 'jpeg', 'gif', 'png' ) );
		$file_size_name	= html::get_file_by_ext( $file_path, $photo_id . '_' . $size , array( 'jpg', 'jpeg', 'gif', 'png' ) );

		if ( ! empty( $file_name ) AND ! empty( $file_size_name ) )
		{
			list( $width, $height, $type, $attr ) = getimagesize( $file_path . $file_name );

			return array(
				'url' => 		$ci->application->projects_url . $project_id . '/' . $file_name,
				'width' =>		$width,
				'height' =>		$height,
				'file_name' =>	$file_name
			);
		}
		else
		{
			return FALSE;
		}
	}

	public static function project_highlight_info( $project_id, $position = 1 )
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file_path		= $ci->application->projects_path;
		$file_name		= html::get_file_by_ext( $file_path, $project_id . '_' . $position, array( 'jpg', 'jpeg', 'gif', 'png' ) );

		if ( $file_name )
		{
			list( $width, $height, $type, $attr ) = getimagesize( $file_path . $file_name );

			return array(
				'url' => 		$ci->application->projects_url . $file_name,
				'width' =>		$width,
				'height' =>		$height,
				'file_name' =>	$file_name
			);
		}
		else
		{
			return FALSE;
		}
	}


	public static function resize_image( $source, $destination, $new_width, $new_height )
	{
		//
		// verifica a extensão do arquivo
		//
		$extension = end( explode( '.', $source ) );

		switch ( $extension )
		{
			case 'jpg':
			case 'jpeg':
				$source_image	= imagecreatefromjpeg( $source );
				break;
			case 'gif':
				$source_image	= imagecreatefromgif( $source );
				break;
			case 'png':
				$source_image	= imagecreatefrompng( $source );
				break;
			default:
				return FALSE;
		}


		//
		// pega dados da imagem de origem
		//
		$image	= site::get_image_x_y( $source_image );
		$new	= imagecreatetruecolor( $new_width, $new_height );
		imagealphablending($new, false);
		imagesavealpha($new, true); 


		//
		// Verifica se a imagem é horizontal ou vertical
		//
		if ( $image->width > $image->height )
		{
			// SE LARGURA ORIGINAL < LIMITE DE LARGURA
			if ( $image->width < $new_width )
			{
				$percent	= $new_width / $image->width;
				$ratio		= $image->height * $percent;

				imagecopyresampled( $new, $image->file, 0, 0, 0, 0, $new_width, $ratio, $image->width, $image->height );

				$image = site::get_image_x_y( $new );
			}


			// SE ALTURA MODIFICADA != LIMITE DE ALTURA
			if ( $image->height != $new_height )
			{
				$percent	= $new_height / $image->height;
				$ratio		= $image->width * $percent;

				imagecopyresampled( $new, $image->file, 0, 0, 0, 0, $ratio, $new_height, $image->width, $image->height );

				$image = site::get_image_x_y( $new );
			}


			// SE LARGURA MODIFICADA < LIMITE DE LARGURA
			if ( $image->width < $new_width )
			{
				$percent	= $new_width / $image->width;
				$ratio		= $image->height * $percent;

				imagecopyresampled( $new, $image->file, 0, 0, 0, 0, $new_width, $ratio, $image->width, $image->height );

				$image = site::get_image_x_y( $new );
				echo '$image->width < $new_width';
			}
		}
		else
		{
			// SE ALTURA ORIGINAL < LIMITE DE ALTURA
			if ( $image->height < $new_height )
			{
				$percent	= $new_height / $image->height;
				$ratio		= $image->width * $percent;

				imagecopyresampled( $new, $image->file, 0, 0, 0, 0, $ratio, $new_height, $image->width, $image->height );

				$image = site::get_image_x_y( $new );
			}


			// SE LARGURA MODIFICADA != LIMITE DE LARGURA
			if ( $image->width != $new_width )
			{
				$percent	= $new_width / $image->width;
				$ratio		= $image->height * $percent;

				imagecopyresampled( $new, $image->file, 0, 0, 0, 0, $new_width, $ratio, $image->width, $image->height );

				$image = site::get_image_x_y( $new );
			}


			// SE ALTURA MODIFICADA < LIMITE DE ALTURA
			if ( $image->height < $new_height )
			{
				$percent	= $new_height / $image->height;
				$ratio		= $image->width * $percent;

				imagecopyresampled( $new, $image->file, 0, 0, 0, 0, $ratio, $new_height, $image->width, $image->height );

				$image = site::get_image_x_y( $new );
			}
		}


		// @FIXME cortar imagem de ambos lados

		// SE ALTURA > LIMITE DE ALTURA - CROPA A IMAGEM
		if ( $image->height > $new_height )
		{
			$top	= round( ( $image->height - $new_height ) / 2 );

			imagecopy( $new, $image->file, 0, 0, 0, $top, $image->width, $image->height );

			$image	= site::get_image_x_y( $new );
		}

		// SE LARGURA > LIMITE DE LARGURA - CROPA A IMAGEM
		if ( $image->width > $new_width )
		{
			$left	= round( ( $image->width - $new_width ) / 2 );

			imagecopy( $new, $image->file, 0, 0, $left, 0, $image->width, $image->height );

			$image	= site::get_image_x_y( $new );
		}


		return imagepng( $image->file, $destination, 8 );
	}


	public static function get_image_x_y( $image )
	{
		$result			= new stdClass();
		$result->file	= $image;
		$result->width	= imagesx( $image );
		$result->height	= imagesy( $image );


		return $result;
	}


	public static function get_first_photo( $project_id )
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file_path = $ci->application->projects_path;;

		$records = new ProjectPhoto();
		$records->where( 'project_id', $project_id );
		$records->get();


		foreach( $records as $record )
		{
			$file_name = html::get_file_by_ext( $file_path, $project_id . '_' . $record->id . '_t', array( 'jpg', 'jpeg', 'gif', 'png' ) );

			if ( $file_name !== FALSE )
			{
				return $ci->application->projects_url . $file_name;
			}
		}

		return FALSE;
	}

	public static function view_photo( $product_id, $photo, $show_if_null = TRUE, $facebox = TRUE ) // string
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file = html::get_file_by_ext( $ci->application->products_path . $product_id . '/', $photo, array( 'png', 'jpg', 'jpeg', 'gif' ) );

		if ( !$file )
		{
			if ( $show_if_null )
			{
				return '<a href="javascript: void(0)">Vazio</a>';
			}
			else
			{
				return '';
			}
		}
		else
		{
			$file = $ci->application->products_url . $product_id . '/' . $file;

			if ( $facebox )
			{
				return '<a href="' . $file . '" rel="facebox">Visualizar</a>';
			}
			else
			{
				return '<img src="' . $file . '">';
			}
		}
	}

	public static function view_customer_photo( $name, $show_if_null = TRUE ) // string
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file = html::get_file_by_ext( $ci->application->customers_path, $name, array( 'png', 'jpg', 'jpeg', 'gif' ) );

		if ( !$file )
		{
			if ( $show_if_null )
			{
				return 'Não cadastrada';
			}
			else
			{
				return '';
			}
		}
		else
		{
			$file = $ci->application->customers_url . $file;
			return '<a href="' . $file . '" rel="facebox">Visualizar</a>';
		}
	}

	public static function remove_photo( $name, $show_if_null = TRUE ) // string
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file = html::get_file_by_ext( $ci->application->projects_path, $name, array( 'png', 'jpg', 'jpeg', 'gif' ) );

		if ( !$file )
		{
			if ( $show_if_null )
			{
				return 'Não cadastrada';
			}
			else
			{
				return '';
			}
		}
		else
		{
			$file = $ci->application->projects_url . $file;
			return '<a href="' . $file . '" rel="remove_photo">Remover</a>';
		}
	}

	public static function remove_customer_photo( $name, $show_if_null = TRUE ) // string
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		$file = html::get_file_by_ext( $ci->application->customers_path, $name, array( 'png', 'jpg', 'jpeg', 'gif' ) );

		if ( !$file )
		{
			if ( $show_if_null )
			{
				return 'Não cadastrada';
			}
			else
			{
				return '';
			}
		}
		else
		{
			$file = $ci->application->customers_url . $file;
			return '<a href="' . $file . '" rel="remove_photo">Remover</a>';
		}
	}

	public static function customer_photo_info( $customer_id )
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();

		$file_path		= $ci->application->customers_path;
		$file_name		= html::get_file_by_ext( $file_path, $customer_id, array( 'jpg', 'jpeg', 'gif', 'png' ) );

		if ( ! empty( $file_name ) )
		{
			list( $width, $height, $type, $attr ) = getimagesize( $file_path . $file_name );

			return array(
				'url' => 		$ci->application->customers_url . $file_name,
				'width' =>		$width,
				'height' =>		$height,
				'file_name' =>	$file_name
			);
		}
		else
		{
			return FALSE;
		}
	}
}