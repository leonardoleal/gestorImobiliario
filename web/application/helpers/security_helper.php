<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

if ( ! function_exists( 'validate_tramper_proof' ) )
{

	function validate_tramper_proof( $tamper_proof, $params = NULL ) // bool
	{
		//
		// carrega a instancia ($this)
		//
		$ci =& get_instance();


		//
		// gera uma chave com os dados enviados
		//
		if ( $params )
		{
			$my_tamper_proof = sha1( $ci->config->item( 'encryption_key' ) . $params );
		}
		else
		{
			$my_tamper_proof = sha1( $ci->config->item( 'encryption_key' ) );
		}


		//
		// retorna se as chaves geradas são iguais
		//
		return ( $my_tamper_proof == $tamper_proof );
	}

}