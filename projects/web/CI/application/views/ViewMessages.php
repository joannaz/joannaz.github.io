<html>
<head>
	<title>My Blog</title>

	<link rel = "stylesheet" type = "text/css" 
	href = "<?php echo base_url(); ?>css/style.css">
</head>
<body>
	<h1> TWEETER </h1>

	<!-- Check if session is valid -->
	<?php if(isset($_SESSION['valid'])) { 
		if($_SESSION['valid'] == true) { ?>
		<!-- If valid display who is logged in and a logout link -->
		<div id="userdata">
			User: <?php echo $_SESSION["user"]; ?> <br>
			<a href="<?php echo base_url(); ?>index.php/User/logout"> Logout</a>
		</div>

		<hr>
		<!-- Menu goes here -->
		<?php } } ?>
		<ul>
			<li><a href="<?php echo base_url() . "index.php/search"; ?> ">Search</a></li>
			<li><a href="<?php echo base_url() . "index.php/Message"; ?> ">Post</a></li>
			<!-- If user is logged in, display the feed option -->
			<?php if(isset($_SESSION['valid'])){
				if($_SESSION['valid'] == true){ ?>
				<li><a href="<?php echo base_url() . "index.php/user/feed/" . $_SESSION['user']; ?> ">Feed</a></li>
				<?php }} ?>
			</ul>
			<!-- If the logged in user is not following the user they are viewing, display a follow button -->
			<?php
			if(isset($_SESSION['valid']) && $_SESSION['valid']==true){
				if(isset($follow)){
					if($follow == false){
						echo '<form action="'.base_url().'index.php/User/follow/'. $followed.'""><input type="submit" value="Follow" /> </form>';
					}
					else{
						echo 'You are already following this user';
					}
				}
			}
			echo '<br>';
			if($query == null){
				echo "Your search term has not been found";	
			}

			else{
				echo '<table>';
				echo '<th> Name </th>';
				echo '<th> Message </th>';
				echo '<th> Date </th>';
				foreach($query->result() as $row){

					echo "<tr>";
					echo '<td> <a href=' . base_url() . 'index.php/user/view/' . $row->user_username .'\>' . $row->user_username .'</a> </td>';
					echo '<td>' . $row->text . "</td>";
					echo '<td>' . $row->posted_at . '</td>' . '</tr>';		
				}
				echo '</table>';
			}	


			?>

		</body>
		</html>