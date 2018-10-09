<?php
class Users_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/*
	*Function to check if the user has logged in with the correct username and password
	*@param String username, String password
	*@return TRUE if user has entered the correct password. FALSE if not. 
	*/
	public function checkLogin($username,$pass){
		$hashedpass = sha1($pass);
		//sha1 hash the password (SHA1 is bad, never use it IRL)
		$sql = "SELECT * FROM Users WHERE username = ? AND password = ? LIMIT 1";
		$data = array (
			$username,
			$hashedpass,
			);
		$query = $this->db->query($sql,$data);
		//if there is a result (number of rows is greater than 0)
		if($query->num_rows()>0){
			return TRUE;
		}
		return FALSE;
	}

	/*
	*Function to check if a user is following another user
	*@param String follower(current user), and String followed(user they are viewing)
	*@return TRUE if they do follow the user, FALSE if not
	*/
	public function isFollowing($follower,$followed){
		$sql = "SELECT * FROM User_Follows WHERE follower_username = ?
		AND followed_username = ?";
		$data = array (
			$follower,
			$followed,
			);
		$query = $this->db->query($sql,$data);

		if($query->num_rows() == 1){
			return TRUE;
		}
		else {
			return FALSE; 
		}

	}
	/*
	*Function to follow a user by entering data into the database
	*@param String user to be followed
	* does not return anything
	*/
	public function follow($followed){
		//start a session if session hasnt been stasrted
		if(!isset($_SESSION)){
			session_start();
		}
		$follower = $_SESSION['user'];
		$sql = "INSERT into User_Follows VALUES (?,?)";

		$data = array (
			$follower,
			$followed,
			);

		$query = $this->db->query($sql,$data);
	}


}