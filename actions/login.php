<?php
include "../classes/User.php";//Include the User class file, so we can use the User class and its methods

//Step1  Create a new User object (an instance of the User class)
$user = new User;

//Step2  Call the login method on the User object
//Pass the form date ($_POST) to the login method to check if user's credentials are correct
$user->login($_POST);
?>