<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class hash
{
	public static function generate( $length = 8, $test_unique = FALSE )
	{
		// valid chars to mount string
		$valid_chars = '0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		// start with an empty random string
		$random_string = "";
		
		// count the number of chars in the valid chars string so we know how many choices we have
		$num_valid_chars = strlen( $valid_chars );
		
		// repeat the steps until we've created a string of the right length
		for ( $i = 0; $i < $length; $i++ )
		{
			// pick a random number from 1 up to the number of valid chars
			$random_pick = mt_rand( 1, $num_valid_chars );
			
			// take the random character out of the string of valid chars
			// subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
			$random_char = $valid_chars[ $random_pick-1 ];
			
			// add the randomly-chosen char onto the end of our string so far
			$random_string .= $random_char;
		}

		if ( $test_unique )
		{
			return hash::is_unique( $random_string );
		}
		else
		{
			return $random_string;
		}
	}

	public static function is_unique( $hash )
	{
		$record = new File();

		if ( $record->is_unique_hash( $hash ) )
		{
			return $hash;
		}
		else
		{
			hash::generate( NULL, TRUE );
		}
	}
}