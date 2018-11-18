<html>

<?php


include 'base.php';

$user = check_login_token($mysqli);
if($user == null){
	echo "User not logged in";
	header("Location: index.php");
	exit();
}

if(!isset($_FILES["file_upload"])){
	header("Location: home.php");
	exit();
}

if(!isset($_POST["width"])){
	header("Location: home.php");
	exit();
}

if(!isset($_POST["height"])){
	header("Location: home.php");
	exit();
}


function resize_image($html_file_input_name, $new_img_width, $new_img_height) {
    $target_dir = "";
	
	$file_name = $_FILES[$html_file_input_name]["name"];
	$new_file_name = "resized_" . $file_name;
    $new_file_path = $target_dir . basename($new_file_name);

    $image = new PHPImage();
    $image->load($_FILES[$html_file_input_name]['tmp_name']);
    $image->resize($new_img_width, $new_img_height);
    $image->save($new_file_path);
    return $new_file_path; 
}


$new_width = (int)$_POST['width'];
$new_height = (int)$_POST['height'];


$new_image_path = resize_image("file_upload", $new_width, $new_height);

$upload_id = execute_insert_query($mysqli, "INSERT INTO upload(user_id, path) VALUES (?, ?)", array($user['id'], $new_image_path), "ss");


//Log image upload
log_activity($mysqli, $user['id'], "image_upload", '{"upload_id": ' . $upload_id . '}');

header("Location: home.php");








class PHPImage {

   var $image;
   var $image_type;

   function load($filename) {
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];
      if( $this->image_type == IMAGETYPE_JPEG ) {

         $this->image = imagecreatefromjpeg($filename);
      } elseif( $this->image_type == IMAGETYPE_GIF ) {

         $this->image = imagecreatefromgif($filename);
      } elseif( $this->image_type == IMAGETYPE_PNG ) {

         $this->image = imagecreatefrompng($filename);
      }
   }
   
   function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null) {

      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image,$filename,$compression);
      } elseif( $image_type == IMAGETYPE_GIF ) {

         imagegif($this->image,$filename);
      } elseif( $image_type == IMAGETYPE_PNG ) {

         imagepng($this->image,$filename);
      }
      if( $permissions != null) {

         chmod($filename,$permissions);
      }
   }
   
   function output($image_type=IMAGETYPE_JPEG) {
      if( $image_type == IMAGETYPE_JPEG ) {
         imagejpeg($this->image);
      } elseif( $image_type == IMAGETYPE_GIF ) {
         imagegif($this->image);
      } elseif( $image_type == IMAGETYPE_PNG ) {
         imagepng($this->image);
      }
   }
   
   function getWidth() {
      return imagesx($this->image);
   }
   
   function getHeight() {
      return imagesy($this->image);
   }
   
   function resizeToHeight($height) {
      $ratio = $height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width,$height);
   }

   function resizeToWidth($width) {
      $ratio = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width,$height);
   }

   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getheight() * $scale/100;
      $this->resize($width,$height);
   }

   function resize($width,$height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }      

}
?>

</html>




