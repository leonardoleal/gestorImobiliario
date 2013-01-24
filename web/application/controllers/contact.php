<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class Contact extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->views( 'contact' );
	}


	public function send()
	{
		$message = '';


		//
		// recebe os e monta a mensagem
		// 
		foreach( $this->application->config->contact_form as $field )
		{
			$message .= $field->alias . ': ' . $this->input->post( $field->title ) . '<br>';
		}

		$this->load->library( 'email' );

		$this->email->from( $this->application->config->system->noreply->value, 'Site' );
		$this->email->to( $this->application->config->system->email_contact->value );
		$this->email->subject( 'Contato através do site' );
		$this->email->message( $message );


		if ( $this->email->send() )
		{
			$this->session->set_flashdata( 'contact_message', 'Mensagem enviada!' );
		}
		else
		{
			$this->session->set_flashdata( 'contact_message', 'Falha no envio, tente mais tarde!' );
		}


		redirect( $this->application->contact );
	}


	public function views( $content, $data = NULL )
	{
		$this->load->view( 'layout/header' );
		$this->load->view( $content, $data );
		$this->load->view( 'layout/footer' );
	}
}