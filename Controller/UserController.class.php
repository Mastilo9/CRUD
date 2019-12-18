<?php
namespace Controller;

use Services\DatabaseService;
use Services\SessionService;

include "PathService.php";

class UserController {

  private $connection;
  private $database;

  public function getConnection(): \mysqli
  {
    return $this->connection;
  }

  public function setConnection(\mysqli $connection)
  {
    $this->connection = $connection;
  }

  public function getDatabase(): DatabaseService
  {
    return $this->database;
  }

  public function setDatabase(DatabaseService $database)
  {
    $this->database = $database;
  }

  function __construct(\mysqli $connection, DatabaseService $database) {
    $this->connection = $connection;
    $this->database = $database;
  }

  public function login() : array
  {
    $errors = array();

    if (isset($_POST['login'])){
      //initializing variables
      $username = "";
      $password = "";

      //user data for login
      $username = mysqli_real_escape_string($this->connection, $_POST['username']);
      $password = mysqli_real_escape_string($this->connection, $_POST['password']);

      if(empty($username))
        array_push($errors, "Username is required!");
      if(empty($password))
        array_push($errors, "Password is required!");

      //register user if everything is ok
      if (count($errors) == 0) {
        $encryptedPassword = md5($password);
        $loginUserQuery = "select * from users where username='$username' and password='$encryptedPassword'";

        $results = $this->database->executeQuery($this->connection, $loginUserQuery);

        if(mysqli_num_rows($results)){
          $_SESSION['username'] = $username;

          $tmp = getRelativeURL('index.php');

          header("location: {$tmp}/notes");
        }
        else {
          array_push($errors, "Wrong username or password ");
        }
      }
    }
    return $errors;
  }

  public function register() : array {
    $errors = array();
    if (isset($_POST['register'])) {
      //initializing variables
      $username = "";
      $email = "";
      $password1 = "";
      $password2 = "";

      //register users
      $username = mysqli_real_escape_string($this->connection, $_POST['username']);
      $email = mysqli_real_escape_string($this->connection, $_POST['email']);
      $password1 = mysqli_real_escape_string($this->connection, $_POST['password1']);
      $password2 = mysqli_real_escape_string($this->connection, $_POST['password2']);


      //handling form validation
      if (empty($username))
        array_push($errors, "Username is required!");
      if (empty($email))
        array_push($errors, "Email is required!");
      if (empty($password1))
        array_push($errors, "Password is required!");
      if (empty($password2))
        array_push($errors, "Confirmation is required!");
      if ($password1 != $password2)
        array_push($errors, "Passwords does not match");

      if (count($errors) == 0) {
        //check db for existing user with same username or email
        $userCheckQuery = "SELECT * FROM users WHERE username = '$username' or email = '$email' LIMIT 1";
        $results = $this->database->executeQuery($this->connection, $userCheckQuery);
        $user = mysqli_fetch_assoc($results);

        if ($user) {
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

          //ovde mozda mogu da napisem novu funkciju koja ne vraca rezultat za query, jer je tip upisa
          $results = $this->database->executeQuery($this->connection, $registerUserQuery);

          $_SESSION['username'] = $username;


          $tmp = getRelativeURL('index.php');

          header("location: {$tmp}/notes");
        }
      }
    }
    return $errors;
  }

  public function logout(SessionService $service, string $param) {
    $service->destroy();
    $service->unsetParam($param);

    $tmp = getRelativeURL('index.php');
    header("location: {$tmp}");
  }
}
