<html>
<head>
	<title>Login</title>
	<link rel = "stylesheet" type = "text/css" 
	href = "<?php echo base_url(); ?>css/style.css">
</head>
<body>
	<h1> TWEETER </h1>
	<hr>
	<br>

	<div id="middle">
		<div id="login">
			<!-- Check if session is set, and if so, if valid is false -->
			<?php if(isset($_SESSION['valid']) && $_SESSION['valid'] == false){
				echo "Please enter the correct credentials";
			}
			?>
			<!-- Form to submit via POST -->
			<form action="<?php echo base_url(). 'index.php/user/dologin'?>" method="post" class="login">
				Username: <br><input type="text" name="username" placeholder="Username"><br><br>
				Password: <br> <input type="password" name="password" placeholder="Password"> <br><br>
				<input type="submit" value="Login">
			</form>
		</div>
	</div>


</body>
</html>