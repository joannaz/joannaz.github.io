<html>
<head>
	<title>My Blog</title>

	<link rel = "stylesheet" type = "text/css" 
	href = "<?php echo base_url(); ?>css/style.css">
</head>
<body>
	<h1> TWEETER </h1>
	
	<!-- If session is valid, display who user is logged in as, and a logout option -->
	<?php if(isset($_SESSION['valid'])) { 
		if($_SESSION['valid'] == true) { ?>
		<div id="userdata">
			User: <?php echo $_SESSION["user"]; ?> <br>
			<a href="<?php echo base_url(); ?>index.php/User/logout"> Logout</a>
		</div>

		<hr>
		
		<?php } } ?>
		<!-- Menu goes here -->
		<ul>
			<li><a href="<?php echo base_url() . "index.php/search"; ?> ">Search</a></li>
			<li><a href="<?php echo base_url() . "index.php/Message"; ?> ">Post</a></li>
			<?php if(isset($_SESSION['valid'])){
				if($_SESSION['valid'] == true){ ?>
				<li><a href="<?php echo base_url() . "index.php/user/feed/" . $_SESSION['user']; ?> ">Feed</a></li>
				<?php }} ?>
			</ul>

			<hr>
			<br>
			<!-- Search box uses GET -->
			<div id="middleblock">

				<form action="Search/doSearch" method="get">
					Search Message: <input type="text" name="message" placeholder="Search..." class="input_box">
					<input type="submit" value="Search">
				</form>
			</div>


		</body>
		</html>