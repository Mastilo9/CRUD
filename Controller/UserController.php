<?php
namespace Controller;

class UserController {

  private $database;
  private $session;
  private $view;

  public function __construct(array $services) {
    $this->database = $services['database'];
    $this->session = $services['session'];
    $this->view = $services['view'];
  }

  public function login() : void {
    try {
      $errors = array();
      if (isset($_POST['login'])) {
        //user data for login
        $username = mysqli_real_escape_string($this->database->getConnection(), $_POST['username']);
        $password = mysqli_real_escape_string($this->database->getConnection(), $_POST['password']);

        if (empty($username))
          array_push($errors, "Username is required!");
        if (empty($password))
          array_push($errors, "Password is required!");

        //register user if everything is ok
        if (count($errors) == 0) {
          $encryptedPassword = md5($password);
          $loginUserQuery = "select * from users where username='$username' and password='$encryptedPassword'";

          $results = $this->database->executeQuery($loginUserQuery);

          if (!empty($results)) {
            $this->session->setSessionParam('username', $username);

            header("location: {$_SERVER['SCRIPT_NAME']}/notes");
          } else {
            array_push($errors, "Wrong username or password ");
          }
        }
      } elseif (!empty($errors)) {
        //ovde ulazim samo ako nema gresaka u nizu errors(on predstavlja greske koje se mogu ispraviti)
        throw new \Exception("Login parameters not exists!");
      }

      $this->view->render('Views/ErrorsRenderer.php', $errors);
      $this->view->render('Views/LoginRenderer.php');
    }catch (\Exception $e) {
      echo "Error => ". $e;
    }
  }

  public function register() : void {
    try {
      $errors = array();
      if (isset($_POST['register'])) {
        //register users
        $username = mysqli_real_escape_string($this->database->getConnection(), $_POST['username']);
        $email = mysqli_real_escape_string($this->database->getConnection(), $_POST['email']);
        $password1 = mysqli_real_escape_string($this->database->getConnection(), $_POST['password1']);
        $password2 = mysqli_real_escape_string($this->database->getConnection(), $_POST['password2']);

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
          $results = $this->database->executeQuery($userCheckQuery);
          $user =$results[0];

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

            $results = $this->database->executeQuery($registerUserQuery);
            $this->session->setSessionParam('username', $username);

            header("location: {$_SERVER['SCRIPT_NAME']}/notes");
          }
        }
      }elseif (!empty($errors)) {
        throw new \Exception("Data for registration never arrived!");
      }
      $this->view->render('Views/ErrorsRenderer.php', $errors);
      $this->view->render('Views/RegistrationRenderer.php');
    } catch (\Exception $e) {
      echo "Error => ". $e;
    }
  }

  public function logout() : void {
    $this->session->logout('username');
    header("location: {$_SERVER['SCRIPT_NAME']}/");
  }
}
