<?php

include 'base.php';

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");

if(!array_key_exists('username', $_POST)){
	echo "Username not set";
	exit();
}
if(!array_key_exists('password', $_POST)){
	echo "Password not set";
	exit();
}



//$user = check_login_token($mysqli);

$username = $_POST['username'];
$password = $_POST['password'];





function login($username, $password, $mysqli) {
	$user = execute_select_query($mysqli, "SELECT id, name, password, salt FROM user WHERE name = ? LIMIT 1", $username);
	if($user == null){
		//A user with this username does not exist in the database
		return false;
	}
	
	//Do not allow the user to login after 5 failed attempts in 1 hour
	$login_attempt_count = get_login_attempt_count($mysqli, $user['id']);
	if($login_attempt_count > 5){
		echo "Max Login Attempts Reached. Try again in 1 hour";
		return false;
	}
	
	//Check if the password that the user entered is correct
	$password_attempt = hash('sha512', $password . $user['salt']);
			
	if($password_attempt == $user['password']){
		//Login was successful
		
		//Delete the old login token
		execute_delete_query($mysqli, "DELETE FROM login_token WHERE user_id = ?", $user['id']);

		//Create a new login token
		$new_token = random_string();
			
		execute_insert_query($mysqli, "INSERT INTO login_token(token, user_id) VALUES (?, ?)", array($new_token, $user['id']), "ss");
		
		//Store login token for 
		$_SESSION['token'] = $new_token;

		return true;
	} else {
		echo "User failed to log in";
		execute_insert_query($mysqli, "INSERT INTO login_attempt(user_id) VALUES (?)", array($user['id']), "s");
		return false;
	}
}


$login_success = login($username, $password, $mysqli);

$mysqli->close();

if($login_success){
	header("Location: home.php");
}else{
	header("Location: index.php");
}

exit();













?>