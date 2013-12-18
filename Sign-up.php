<?php include('header.php'); ?>
	
<?php  
	if (isset($_POST['submit_sign'])) {
		
		$con = @mysqli_connect('localhost', 'root', 'root', 'wzed') or die("Could not establish a DB connection");

		// Check connection
		if (mysqli_connect_errno($con)) {
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}else{

			if (!empty($_POST['username_sign']) && !empty($_POST['password_sign'])) {

				$signup_username = $_POST['username_sign'];
				$signup_password = $_POST['password_sign'];
				
				$pepper = 'RS%11(\T]?^by7f';
				$salt = '[}086Sd5ee3!8k8';
				$password = sha1($signup_password.$salt);
				$encrypted = hash('sha512', $signup_username.$password.$pepper);


				echo "$password <br /> $encrypted <br />";
				$add = mysqli_query($con, "INSERT INTO user (user_id,username,password,character_money) VALUES ( NULL, '$signup_username', '$encrypted', 10)") or die("Could not establish a DB connection");
				/*if (!mysqli_query($con,$add))
				  {
				  die('Error: ' . mysqli_error());
				  }*/
				if ($add) {
					echo "Welcome to the game $signup_username !";
				}else{
					echo mysqli_error($con);
					
				}
			}
		}


		mysqli_close($con);

	}

?>

	<p>Sign up!</p>
	<form action="sign-in.php" method="post">
		<input type="text" name="username_sign" />Username<br />
		<input type="password" name="password_sign" />Password<br />
		<input type="submit" name="submit_sign" value="Sign Up" />
	</form>

</section>
</div>
</body>
</html>
