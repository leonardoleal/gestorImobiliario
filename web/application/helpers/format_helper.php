<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class format
{

	public static function fill( $input, $size = 6, $string = '0', $side = STR_PAD_LEFT ) // string
	{
		return str_pad( $input, $size, $string, $side );
	}

	public static function float2time( $float = 0 ) // time
	{
		$timestamp	= (int)$float;
		$position	= strrpos( $float, '.' ) + 1;
		$micro		= str_pad( substr( $float, $position, 3 ), 3, '0' );

		return date( 'i:s.', $timestamp ) . $micro;
	}

	public static function datetime2date( $str ) // date
	{
		if ( !empty( $str ) )
		{ 
		    list( $date, $time) = explode( ' ', $str );
	    	list( $year, $month, $day) = explode( '-', $date );
		    list( $hour, $minute, $second) = explode( ':', $time );

    		$timestamp = mktime( $hour, $minute, $second, $month, $day, $year );

		    return date( 'd/m/Y', $timestamp );
		}

		return FALSE;
	}

	public static function datetime2br( $str ) // time
	{
		if ( !empty( $str ) )
		{ 
	    	list( $date, $time) = explode( ' ', $str );
    		list( $year, $month, $day) = explode( '-', $date );
	    	list( $hour, $minute, $second) = explode( ':', $time );

    		$timestamp = mktime( $hour, $minute, $second, $month, $day, $year );

	   		return date( 'd/m/Y H:i:s', $timestamp );
		}

		return FALSE;
	}

	public static function date2br( $str ) // time
	{
		if ( !empty( $str ) )
		{ 
    		list( $year, $month, $day) = explode( '-', $str );

    		$timestamp = mktime( '00', '00', '00', $month, $day, $year );

	   		return date( 'd/m/Y', $timestamp );
		}

		return FALSE;
	}

	public static function datebr2sql( $str ) // date
	{
		if ( !empty( $str ) )
		{ 
			list( $day, $month, $year) = explode( '/', $str );

			$timestamp = mktime( '00', '00', '00', $month, $day, $year );

			return date( 'Y-m-d H:i:s', $timestamp );
		}

		return FALSE;
	}

	public static function datebr2datesql( $str ) // date
	{
		if ( !empty( $str ) )
		{ 
			list( $day, $month, $year) = explode( '/', $str );

			$timestamp = mktime( '00', '00', '00', $month, $day, $year );

			return date( 'Y-m-d', $timestamp );
		}

		return FALSE;
	}

	public static function bit2word( $bit )
	{
		if ( $bit == 1 )
		{
			return 'Sim';
		}
		else
		{
			return 'Não';
		}
	}

	public static function decimalus2br( $value )
	{
		return number_format( $value, 2, ',', '.' );
	}

	public static function decimalbr2us( $value )
	{
		return number_format( $value, 2, '.', ',' );
	}

	public static function decimalbr2sql( $value )
	{
		$value = str_replace( '.', '', $value );
		$value = str_replace( ',', '.', $value );

		return $value;
	}
}