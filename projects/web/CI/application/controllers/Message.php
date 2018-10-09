<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {


	public function index()
	{
		session_start();
			//if session is valid, display post view
		if(isset($_SESSION['valid']) && $_SESSION['valid']){
			$this->load->view('Post');

		}
		else{
			redirect("user/login");
		}
	}

	/*
	* Function to post messages
	*/
	public function doPost(){
		if(!isset($_SESSION)){
			session_start();
		}

		//if the session is not valid, then redirect to login page
		if($_SESSION['valid'] == false){
			redirect("user/login");		}
		//if is valid, then get the string using POST
		$this->load->model('Messages_model');
		$username = $_SESSION['user'];
		$string = $_POST['message'];		
		// and call the insertMessage function 
		$this->Messages_model->insertMessage($username,$string);

		//fetches all messages by the loggedin user
		$data['query'] = $this->Messages_model->getMessagesByPoster($username);

		//loads the users messages
		$this->load->view('ViewMessages',$data);
	}


}

?>