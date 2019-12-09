<?php

session_start();
$errors = array();


//connect to database
$database = mysqli_connect('localhost', 'root', 'root', 'crud') or die("could not connect to database");


if (isset($_POST['register'])){

  //initializing variables
  $username = "";
  $email = "";
  $password1 = "";
  $password2 = "";

  //register users
  $username = mysqli_real_escape_string($database, $_POST['username']);
  $email = mysqli_real_escape_string($database, $_POST['email']);
  $password1 = mysqli_real_escape_string($database, $_POST['password1']);
  $password2 = mysqli_real_escape_string($database, $_POST['password2']);

  //handling form validation
  if(empty($username))
    array_push($errors, "Username is required!");
  if(empty($email))
    array_push($errors, "Email is required!");
  if(empty($password1))
    array_push($errors, "Password is required!");
  if(empty($password2))
    array_push($errors, "Confirmation is required!");
  if($password1 != $password2)
    array_push($errors, "Passwords does not match");

  //check db for existing user with same username or email
  $userCheckQuery = "SELECT * FROM users WHERE username = '$username' or email = '$email' LIMIT 1";

  $results = mysqli_query($database, $userCheckQuery);
  $user = mysqli_fetch_assoc($results);

  if($user) {
    if ($user['username'] === $username) {
      array_push($errors, "User with the same username already exist");
    } elseif ($user['email'] === $email) {
      array_push($errors, "User with the same email already exist");
    }
  }

  //register user if everything is ok
  if (count($errors) == 0) {
    $encryptedPassword = md5($password1);
    $registerUserQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$encryptedPassword')";

    mysqli_query($database, $registerUserQuery);

    $_SESSION['username'] = $username;

    header("location: userWelcome.php");
  }
}elseif (isset($_POST['login'])){
  //initializing variables
  $username = "";
  $password = "";

  //user data for login
  $username = mysqli_real_escape_string($database, $_POST['username']);
  $password = mysqli_real_escape_string($database, $_POST['password']);

  //handling form validation
  if(empty($username))
    array_push($errors, "Username is required!");
  if(empty($password))
    array_push($errors, "Password is required!");

  //register user if everything is ok
  if (count($errors) == 0) {
    $encryptedPassword = md5($password);
    $loginUserQuery = "select * from users where username='$username' and password='$encryptedPassword'";

    $results = mysqli_query($database, $loginUserQuery);

    if(mysqli_num_rows($results)){
      $_SESSION['username'] = $username;

      header("location: userWelcome.php");

    }
    else {
      array_push($errors, "Wrong username or password ");
    }
  }
  }
  if (isset($_POST['save'])){

  //initializing variables
  $username = $_SESSION['username'];
  $userID= 0;
  $title = "";
  $essay = "";

  //get data for diary
  $title = mysqli_real_escape_string($database, $_POST['title']);
  $essay = mysqli_real_escape_string($database, $_POST['essay']);


  //handling form validation
  if(empty($title))
    array_push($errors, "Title is required!");
  if(empty($essay))
    array_push($errors, "Essay is required!");

  //get current user id from database
  $getUserIdQuery = "SELECT * FROM users WHERE username='$username'";

  $results = mysqli_query($database, $getUserIdQuery);
  $userID = mysqli_fetch_assoc($results)['id'];

  //insert data into database
  if (count($errors) == 0) {  //pitanje da l su potrebne greske ovde kad imam required na poljima

    $saveDiaryQuery = "INSERT INTO diary (title, essay, user_id) VALUES ('$title', '$essay', '$userID')";

    mysqli_query($database, $saveDiaryQuery);

    header("location: userWelcome.php");
  }
}

  if (isset($_GET['del'])){
    $idNote= $_GET['del'];

    $deleteNoteQuery = "delete from diary where id='$idNote'";
    mysqli_query($database, $deleteNoteQuery);
    header("location: userWelcome.php");
  }

if (isset($_POST['edit'])) {

  //initializing variables
  $username = "";
  $essay = "";

  //register users
  $title = mysqli_real_escape_string($database, $_POST['title']);
  $essay = mysqli_real_escape_string($database, $_POST['essay']);

  //check db for existing user with same title
  $updateNoteQuery = "update diary set essay='$essay' where title = '$title' ";

  mysqli_query($database, $updateNoteQuery);

  header("location: userWelcome.php");


}