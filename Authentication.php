<?php 
	
	if (isset($_POST['submit'])) {
				// If player clicked login (which he/she obviously did or they wouldn't get to this page).


		$con = @mysql_connect('localhost', 'root', 'root') or die("Could not establish a DB connection");
		mysql_select_db('db', $con);

				// Check connection
		if (mysqli_connect_errno($con))
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }else{
		  	$user = $_POST['username'];
		  	$pepper = 'RS%11(\T]?^by7f';
		  	$salt = '[}086Sd5ee3!8k8';
		  					// Salt the password and pepper the hash.
		  	$password = sha1($_POST['password'].$salt);
		  	
		  					// Check the database for any match with the username and password.
		  	$sql = mysql_query("SELECT * FROM user WHERE username=\"$user\"") or die(mysql_error());
		  	$row = mysql_fetch_array($sql);

							// Pepper the hashed password.
			if (hash('sha512', $_POST['username'].$password.$pepper) === $row['password']) {
				session_start();
							// Start a session and set login to true and save the username aswell as the password for good meassure.
				$_SESSION['login'] = 'true';
				$_SESSION['username'] = $user;
				$_SESSION['password'] = hash('sha512', $_POST['username'].$password.$pepper);

				if (is_null($row['character_name'])) {
							// Check if the user has a character, if not then go to "char-create.php".
					mysql_close($con);
					header('location: /char-create.php');
				}else{
							// If user does have a character then go to "stat-sheet.php".
					mysql_close($con);
					header('location: /stat-sheet.php');
				}
			}else {
				echo "Wrong Username or Password";
			}
		  }

		

	}


 ?>
