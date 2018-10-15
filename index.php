<html>
<head>

<body>

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


</body>

</html>




