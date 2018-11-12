<?php

include 'base.php';


if(isset($_SESSION['token'])){
	unset($_SESSION['token']);
}


echo "Logout successful. <a href='/afl294/index.php'>Click here to Log Back In</a>";

exit();

?>