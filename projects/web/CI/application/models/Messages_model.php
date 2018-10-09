<?php
class Messages_model extends CI_Model {
	
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	/*
	* Function to search messages 
	* @param keyword to be searched
	* @return the query results
	*/
	public function searchMessages($string){
		$sql = "SELECT * FROM Messages WHERE text like ? ORDER BY posted_at DESC";
		$query = $this->db->query($sql,"%".$string."%");
		return $query;
	}

	/*
	* Function to retrieve messages by certain poster
	* @param username to be searched
	* @return the query results
	*/
	public function getMessagesByPoster($name){
		$sql = "SELECT * FROM Messages WHERE user_username = ? ORDER BY posted_at DESC";
		$query = $this->db->query($sql,$name);
		return $query;
	}		
	/*
	* Function to insert message by the logged in user
	* @param the current logged in user, and the message to be posted
	* @return the query results
	*/
	public function insertMessage($poster,$string){
		$date = date('Y/m/d G:i:s');
		$data = array (
			'user_username' => $poster,
			'text' => $string,
			'posted_at' => $date,
			);
		$this->db->insert('Messages',$data);
	}
	/*
	* Function to retrieve all messages that the user follows
	* @param the user who has followed the people
	* @return the query results
	*/
	public function getFollowedMessages($name){
		$sql = "SELECT Messages.user_username, Messages.text, Messages.posted_at 
		FROM Messages
		INNER JOIN User_Follows
		ON User_Follows.follower_username= ? AND Messages.user_username=User_Follows.followed_username
		ORDER BY Messages.posted_at DESC";
		$query = $this->db->query($sql,$name);
		return $query;
	}

}