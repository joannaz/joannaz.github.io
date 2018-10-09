<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function index()
	{

		if(!isset($_SESSION)){
			session_start();
		}
		
		$this->load->model('Messages_model');
		$this->load->view('Login');

	}
	
	/**
	* Displays all messages by a user
	* @param the user to be viewed 
	* displays the messages in ViewMessages view
	*/
	public function view($name = null)
	{
		//if session isnt set, start the session
		if(!isset($_SESSION)){
			session_start();
		}
		
		//if the name wasn't supplied, give an error
		if($name == null){
			//break out
			show_error('The user doesnt appear to exist',404,"Error: User does not exist");
			return;
		}

		if(isset($_SESSION["user"])){
			if($_SESSION['user'] != $name){
				//if the page the user is viewing is not the same user
				$this->load->model('Users_model');
				//to see if user is following the viewed user
				$boolean = $this->Users_model->isFollowing($_SESSION['user'],$name);
				if($boolean){
					//then they is following user
					$data['follow'] = true;
				}else{
					//they arent following the user
					$data['follow'] = false;
					$data['followed'] = $name;
				}
			}

		}
		$this->load->model('Messages_model');
		$data['query'] = $this->Messages_model->getMessagesByPoster($name);

		//404 if specified user does not exist
		if($data['query'] == null || count($data['query']) == 0){
			show_error('The user doesnt appear to exist',404,"Error: User does not exist");
			return;
		}

		$this->load->view('ViewMessages', $data);
	}

	/**
	* Logs the user in
	*/
	public function login()
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$this->load->view('Login');
	}

	/**
	* Retrieves the data from the form via POST
	* and calls the function from Users_model to see if the user can log in
	* If they can, start session
	* if not, error
	*/
	public function doLogin()
	{
		if(!isset($_SESSION)){
			session_start();
		}

		if(isset($_POST['username']) && isset($_POST['password'])){
		//asigns the values from POST to variables
			$username = strtolower($_POST['username']);
			$password = $_POST['password'];

		//load Users_model
			$this->load->model('Users_model');
		//calls checkLogin in Users_model, returns true if information is valid
		// assigns it to a variable called $check
			
			$check = $this->Users_model->checkLogin($username,$password);
		}
		else{
			echo "Please enter your username and password";
			return;
		}

		//if $check is true
		if($check){
			//password and username are correct
			//logs the user in and redirects to 
			//the user's messages
			$_SESSION['user'] = $username; 
			$_SESSION['valid'] = true;
			redirect("user/view/$username");

		}
		
		
		else{
		//user is not logged in
		//redirects user to login page
		//global var is false, so prints out error in view
			$_SESSION['valid'] = false;
			redirect("user/login");
		}
		
	}

	/*
	* Function to log the user out
	* Redirects to login page
	*/
	public function logout()
	{
		if(!isset($_SESSION)){
			session_start();
		}
		//clears the session variables
		$_SESSION['valid'] = null;
		$_SESSION['user'] = null;
		//calls the method to clear session variables too as backup
		session_unset(); 
		//destroy session BAM
		session_destroy();
		redirect("user/login");
	}

	/*
	* Function to follow a user
	* @param the User to be followed
	* loads the logged in users feed afterwards
	*/
	public function follow($followed){
		$this->load->model('Users_model');
		//follow viewed user
		$this->Users_model->follow($followed);
		//load session's users feed
		$this->feed($_SESSION['user']);
	}

	/*
	* Function to view a user's feed
	* @param the name of the user's feed
	*/
	public function feed($name = null){

		//start session if not already started
		if(!isset($_SESSION)){
			session_start();
		}
		$this->load->model('Messages_model');
		if($name == null){
			//if name is null, redirect to session user's feed
			$this->feed($_SESSION['user']);
		}
		elseif($name !== $_SESSION['user']){
			//if user is trying to view someone else's feed, redirect 
			//to current users feed
			$thisname = $_SESSION['user'];
			redirect("user/feed/$thisname");
		}
		else{

			$data['query'] = $this->Messages_model->getFollowedMessages($name);
			$this->load->view('ViewMessages',$data);
		}
	}


}
