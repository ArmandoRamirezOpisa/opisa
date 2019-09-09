<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent:: __construct();
		$this->load->library('email');
	}

	public function index()
	{
		$this->load->view('includes/header');
		$this->load->view('home_view');
		$this->load->view('includes/footer');
	}
	public function nosotros(){
		$this->load->view('nosotros_view');
	}
	public function servicios(){
		$this->load->view('servicios_view');
	}
	public function programas(){
		$this->load->view('programas_view');
	}
	public function catalogo(){
		$this->load->view('catalogo_view');
	}
	public function sendMail(){
		$nombrePersona = $this->input->post('nombrePersona');
		$correoPersona = $this->input->post('correoPersona');
		$telefonoPersona = $this->input->post('telefonoPersona');
		$empresaPersona = $this->input->post('empresaPersona');
		$mensajePersona = $this->input->post('mensajePersona');

		//Configuracion de SMTP
		$config['smtp_host'] = 'm176.neubox.net';
		$config['smtp_user'] = 'envios@opisa.com';//envios@opisa.com
		$config['smtp_pass'] = '3hf89w';//3hf89w
		$config['smtp_port'] = 465;
		$config['mailtype'] = 'html';

		/* Estructura del correo de reconocelo */
		$message = '<!DOCTYPE html>
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>OPI mail</title>
			</head>
			<body>
			<h1>Correo Contacto OPISA</h1>
			<hr>
			<label><strong> Nombre de la persona: </strong></label>'.$nombrePersona.'
			<br>
			<label><strong>Correo de la persona: </strong></label>'.$correoPersona.'
			<br>
			<label><strong>Telefono de la persona: </strong></label>'.$telefonoPersona.'
			<br>
			<label><strong>Empresa de la persona: </strong></label>'.$empresaPersona.'
			<br>
			<label><strong>Mensaje de la persona de la persona: </strong></label>
			<br>
			<p>'.$mensajePersona.'</p>
			</body>
		</html>';
		/* Fin de la Estructura del correo de reconocelo */
				   
		//Inicializa
		$this->email->initialize($config);
		//Envío de alerta de canje.
		$this->email->from('no_reply@opisa.com.mx', 'Operadora de programa de incentivos');
		$this->email->to('info@opisa.com');//operaciones@opisa.com

		$this->email->subject('Contacto');
		$this->email->message($message);

		$this->email->send();
	}
}
