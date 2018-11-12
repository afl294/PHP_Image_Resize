<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "afl294");

if ($mysqli->connect_errno) {
    error_log("Connect failed:");
    error_log( print_r( $mysqli->connect_error, true ) );
    exit();
}
 
function execute_delete_query($mysqli, $sql_command, $param_1 = null){	
	$delete_token_stmt = $mysqli->prepare($sql_command);
	if ( false === $delete_token_stmt ) {
		return null;
	}
	
	if($param_1 != null){
		$bind = $delete_token_stmt->bind_param('s', $param_1);
	}
		
	if($delete_token_stmt->execute()){ 
		$delete_token_stmt->close();
		return true; 
	}else {
		return false;
	}	
}


function execute_insert_query($mysqli, $sql_command, $params = null, $types = "s"){	
	$insert_stmt = $mysqli->prepare($sql_command);
	if ( false === $insert_stmt) {
		return null;
	}
	
	if($params != null){
		$bind = $insert_stmt->bind_param($types, ...$params);
	}	
		
	if($insert_stmt->execute()){ 
		$insert_stmt->close();
		return $mysqli->insert_id;
	}else {
		return false;
	}	
}

 
function execute_select_query($mysqli, $sql_command, $param_1 = null, $return_raw = false){
	$stmt = $mysqli->prepare($sql_command);
	if ( false === $stmt ) {
		return null;
	}

	if($param_1 != null){
		$stmt->bind_param('s', $param_1);
	}
	
	if(!$stmt->execute()){ 
		return null; 
	}
	
	

	if($return_raw){
		return $stmt;
	}else{
		$result = $stmt->get_result();
		if(!$result){
			return null;
		}
			
		$obj = $result->fetch_assoc();
		if(!$obj){
			return null;
		}
		
		$stmt->close();
		return $obj;	
	}
	

}



function get_login_attempt_count($mysqli, $user_id){
	$count = 0;
	
	
	$stmt = execute_select_query($mysqli, "SELECT id FROM login_attempt WHERE user_id = ? AND time >= DATE_SUB(NOW(),INTERVAL 1 HOUR)", $user_id, true);
	$result = $stmt->get_result();
	while($upload_obj = $result->fetch_assoc()){
		$count += 1;
	}
	
	$stmt->close();
	
	return $count;
}


function is_token_expired($mysqli, $token){
	$token_obj = execute_select_query($mysqli, "SELECT id FROM login_token WHERE token = ? AND time >= DATE_SUB(NOW(),INTERVAL 1 HOUR)", $token);

	if($token_obj != null){
		return false; //If we selected the token, its less than an hour old so it is not expired
	}

	echo "Token is expired. Log in again";
	return true; //If we didnt select the token, its older than an hour old so it is expired
}



function random_string(){	
	return md5(uniqid(rand(), true));
}

function check_login_token($mysqli){
	if(!isset($_SESSION['token'])){
		return false;
	}
	
	
	$token = $_SESSION['token'];
	
	//If the login token cookie is over an hour old, make the user log in again
	if(is_token_expired($mysqli, $token)){
		return null;
	}
	

	$login_token = execute_select_query($mysqli, "SELECT id, token, user_id FROM login_token WHERE token = ?", $token);

	if($login_token == null){ 
		//echo "Login token = null";
		return null; 
	}
	
	$user_id = $login_token['user_id'];
	
	
	$user = execute_select_query($mysqli, "SELECT id, name, password, salt FROM user WHERE id = ? LIMIT 1", $user_id);

	if($user == null){
		return null;
	}

	return $user;
}


?>