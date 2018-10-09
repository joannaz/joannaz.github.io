<html>
<head>
	<title>Post</title>

	<link rel = "stylesheet" type = "text/css" 
	href = "<?php echo base_url(); ?>css/style.css">
</head>
<body>
	<h1> TWEETER </h1>
	<div id="userdata">
		<!-- This page can only be viewed if user is logged in, therefore dont need to check if session is set -->
		User: <?php echo $_SESSION["user"]; ?> <br>
		<a href="<?php echo base_url(); ?>index.php/User/logout"> Logout</a>
	</div>

	<hr>
	<!-- menu bar -->
	<ul >
		<li><a href="<?php echo base_url() . "index.php/search"; ?> ">Search</a></li>
		<li><a href="<?php echo base_url() . "index.php/Message"; ?> ">Post</a></li>
		<?php if(isset($_SESSION['valid'])){
			if($_SESSION['valid'] == true){ ?>
			<li><a href="<?php echo base_url() . "index.php/user/feed/" . $_SESSION['user']; ?> ">Feed</a></li>
			<?php }} ?>
		</ul>
		<br>
		<!-- Post box to post via POST-->
		<?php 

		if(isset($_SESSION)){

			?>
			<div id="middleblock">
				<br><br><br>
				<form action="Message/doPost" method="post">
					Post Message: <input type="text" name="message" placeholder="message">
					<input type="submit" value="Post">
				</form>
			</div>
			<?php }

			else{

				?>
				<!-- just in case -->
				Please <a href= <?php echo base_url(). "index.php/User/login".">"; ?> Login </a>
				<?php } ?>
			</body>
			</html>