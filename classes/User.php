<?php
  require_once "Database.php";//Include Datebase class to inherit database connection properties and method

  class User extends Database{

    //Method to store a new user in the database
    public function store($request){
      //Extract form data form the $request array
        $first_name    = $request['first_name'];
        $last_name     = $request['last_name'];
        $username      = $request['username'];
        $password      = $request['password'];

        //Securely hash the password before storing it
        $password =  password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query to insert the new user into the 'user' table
        $sql = "INSERT INTO users (`first_name`,`last_name`,`username`,`password`)
                VALUE ('$first_name','$last_name','$username','$password')";

              //Execute the query and check if it was successful
                if($this->conn->query($sql)){
                  //Redirect to the login page (index.php in the views folder) if the user was created successfully
                    header('location: ../views');
                    exit;//Stop further script execution
                } else{
                  //Display an errror massege if there was a problem creating the user
                    die('Error creating the user: '. $this->conn->error);
                }
    }

    public function login($request){
      //Step1  Get the username and password from the $request array (usually from $_POST)
      $username = $request['username'];
      $password = $request['password'];


      //Step2  Create an SQL query to find the user by their username
      $sql = "SELECT * FROM users WHERE username = '$username'";

      //Step3  Run the query on the database connecyion ($this->conn) and store the result
      $request = $this->conn->query($sql);

      //Step4  Check if auser with this usrename exists in database
      if($request->num_rows == 1){
        //Step5 Get the user's data from the database
        $user = $request->fetch_assoc();

        //Step6 Verify the password
        if(password_verify($password,$user['password'])){
          //Step7 Start a session to keep the user logged in
          session_start();

          //Step8 Store user details in the session so we can use them on other pages
          $_SESSION['id']          =$user['id'];
          $_SESSION['username']    =$user['username'];
          $_SESSION['full_name']   =$user['first_name']." ".$user['last_name'];

          //Step9 Redirect the user to the dashbord page after successful login
          header('location:../views/dashboard.php');
          exit;
      }else{
        //If the password is incorrect, display an error message
          die('Password is incorrect');
        }
      }else{
        //If no user with this username is found, display an error message
        die('Username not found');
      }

    }

    public function logout(){
      //Step1 Start the session so we can access session data
      session_start();

      //Step2 Remove all session variables
      session_unset();

      //Step3 Destroy the session
      session_destroy();

      //Step4 Redirect the user to the login or home page
      header('location: ../views');
      exit;
    }

   
    public function getAllUsers(){
      //Step1 Write the SQL query to select certain columns from the 'users' table
      $sql = "SELECT id,first_name,last_name,username,photo FROM users";

      //Step2 Run the query on the database connection ($this->conn)
      if($result = $this->conn->query($sql)){
         return $result;
      }else{
        die('Error retrieving all users:' .$this->conn->error);
      }
    }


    public function getUser($id){

      $sql = "SELECT * FROM users WHERE id = $id";

      if($result = $this->conn->query($sql)){
        return $result->fetch_assoc();
      }else{
        die('Error retrieving the user: ' .$this->conn->error);
      }
    }


    public function update($request, $files){
      session_start();


      //Step1 Retrive the current logged-in user's ID from the session
      $id = $_SESSION['id'];

      //Step2 Get the data from the form and the uploaded file
      $first_name = $request['first_name'];
      $last_name = $request['last_name'];
      $username = $request['username'];
      $photo = $files['photo']['name'];
      $tmp_photo = $files['photo']['tmp_name'];

      //Step3 Write the SQL query to updata the user's name and username in the database
      $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $id";

      //Step4 Execute the query to updata the user's information (name and username)
      if($this->conn->query($sql)){
        $_SESSION['username'] = $username;
        $_SESSION['full_name'] = "$first_name $last_name";

        //Step5 Check if a photo was uploaded
        if($photo){
          $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";

          $destination = "../assets/images/$photo";

          //Step6 Excute the query to updata the photo in the database
          if($this->conn->query($sql)){
            //Step7 Move the uploaded the photo from the temporary location to the destination folder
            if(move_uploaded_file($tmp_photo, $destination)){
              header('location: ../views/dashboard.php');
              exit;
            }else{
              die('Error moving the photo.');
            }
          }else{
            die('Erroro uploading photo: ' . $this->conn->error);
          }
        }

        //Step8 If no photo is uploaded, just redirect to the dashboard
        header('location: ../views/dashboard.php');
        exit;
      }else{
        die('Error updating the user: ' . $this->conn->error);
      }

    }


    public function delete(){
      session_start();

      $id = $_SESSION['id'];

      $sql = "DELETE FROM users WHERE id = $id";

      //Execute the query
      if($this->conn->query($sql)){
 
        //If successful, destroy the session and redirect to the homepage
        session_unset();
        session_destroy();
        header('location: ../views/index.php');
        exit;
      }else{
 
        //If an error occurs, show an error message
        die('Error deleting user: ' . $this->conn->error);
      }
    }
  }


?>