<?php
include "../classes/User.php";

//Step1 Create a new User object (an instance of the User class)
$user = new User;

//Step2  Call the updata method on the User object
//Pass both $_POST (form data) and $_FILES (uploaded file data) to the updata method
$user->update($_POST, $_FILES);
?>