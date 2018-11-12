<html>


<?php 

include 'base.php';

$user = check_login_token($mysqli);
if($user == null){
	echo "User not logged in";
	header("Location: index.php");
	exit();
}


?>

<head>

<body>


<div>Current Logged in User: <?php echo $user['name']; ?>



<form action="resize_image.php" method="post" enctype="multipart/form-data">
    <p>Select a JPG image to upload:</p>
	<br>
    <input type="file" name="file_upload" id="fileToUpload" accept="image">
	
	<br><br>
	
	<p>Width:</p><input type="number" name="width" min="10" max="5000" value="200">
	<br>
	
	<p>Height</p><input type="number" name="height" min="10" max="5000" value="200">
	
	<br><br>
    <input type="submit" value="Upload Image" name="submit">
</form>


<br>

<a href="/afl294/logout.php">Log out</a>

<div>
	<h3>Your images</h3>
	
	
	<?php
	
	$stmt = execute_select_query($mysqli, "SELECT id, user_id, path, time FROM upload WHERE user_id = ?", $user['id'], true);
	$result = $stmt->get_result();
	while($upload_obj = $result->fetch_assoc()){
		echo "<image src='" . $upload_obj['path'] . "'>";
		echo "<p>Resized image: " . $upload_obj['path'] . "</p>";
	}
	
	$stmt->close();

	?>



</div>



</body>

</html>




