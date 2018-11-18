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



$mysqli = new mysqli("localhost", "root", "", "afl294");

if ($mysqli->connect_errno) {
    error_log("Connect failed:");
    error_log( print_r( $mysqli->connect_error, true ) );
    exit();
}


$user = check_login_token($mysqli);


$username = $_POST['username'];
$password = $_POST['password'];


function register($username, $password, $mysqli) {
	//Check if a user already exists with this username
	$user = execute_select_query($mysqli, "SELECT id, name, password, salt FROM user WHERE name = ? LIMIT 1", $username);
	if($user != null){
		echo "A user with this username already exists. <br>";
		return false;
	}
	
	$new_salt = random_string();
	
	$hash_password = hash('sha512', $password . $new_salt);
	
	//Create new user in database
	$user_id = execute_insert_query($mysqli, "INSERT INTO user(name, password, salt) VALUES (?, ?, ?)", array($username, $hash_password, $new_salt), "sss");
	
	//Delete the old login token
	execute_delete_query($mysqli, "DELETE FROM login_token WHERE user_id = ?", $user_id);

	//Create a new login token
	$new_token = random_string();	
	execute_insert_query($mysqli, "INSERT INTO login_token(token, user_id) VALUES (?, ?)", array($new_token, $user_id), "ss");

	$user['login_token'] = $new_token;
	$user['id'] = $user_id;
	
	return $user;
}


$user = register($username, $password, $mysqli);
if($user == null){
	echo "Error registering user. Go back to the <a href='/afl294/index.php'>Login Page</a>";
	exit();
}

//Store newly created login token into users session
$_SESSION['token'] = $user['login_token'];


//Log successful account creation
log_activity($mysqli, $user['id'], "create_account_success", "");


$mysqli->close();

header("Location: home.php");

exit();













?>