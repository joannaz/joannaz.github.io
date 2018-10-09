<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	 function __construct() { 
         parent::__construct(); 
      } 

	
	public function index()
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$this->load->view('Search');
	}

	/**
	* Retrieves string from GET parameters in view/Search and runs 
	* searchMessages() in Messages_model model
	* and then loads the the view "ViewMessages" with the results
	* @param String to be searched
	*/
	public function doSearch()
	{	
		if(!isset($_SESSION)){
			session_start();
		}
		if(empty($_GET['message'])){
			$searchstring = null;
		}

		else{
			$searchstring = $_GET['message'];
		}

		if($searchstring == null){
			//trying to print error message in search view, instead of new page
			//$error = "Please enter a search term";
			//$this->load->view('Search');
			echo "Error, please enter search term";
			return;
		}

		$this->load->model('Messages_model');
		$data['query'] = $this->Messages_model->searchMessages($searchstring);
		$this->load->view('ViewMessages', $data);
	}
}
		
		
