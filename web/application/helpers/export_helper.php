<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class export
{
	public static function to_excel( $query, $filename = 'data' ) // true
	{
		$headers	= ''; // just creating the var for field headers to append to below
		$data		= ''; // just creating the var for field data to append to below

		$ci =& get_instance();

		$fields = $query->field_data();

		if ( $query->num_rows() == 0 )
		{
			return FALSE;
		}
		else
		{
			foreach ( $fields as $field )
			{
				$headers .= $field->name . "\t";
			}
		
			foreach ( $query->result() as $row )
			{
				$line = '';

				foreach( $row as $value )
				{
					if ( ( !isset( $value ) ) OR ( $value == '' ) )
					{
						$value = "\t";
					}
					else
					{
						$value = str_replace( '"', '""', $value );
						$value = '"' . $value . '"' . "\t";
					}

					$line .= utf8_decode( $value );
				}

				$data .= trim( $line ) . "\n";
			}
		
			$data = str_replace( "\r", '', $data );

			header( 'Pragma: public' );
			header( 'Expires: 0' );
			header( 'Content-Transfer-Encoding: binary' );
			header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header( 'Content-Description: File Transfer' );
			header( 'Content-Type: application/x-msdownload; charset=utf-8' );
			header( 'Content-Disposition: attachment; filename=' . $filename . '.xls' );

			echo( $headers . "\n" . $data );

			return TRUE;
		}
	}
}