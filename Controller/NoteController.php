<?php

namespace Controller;

class NoteController {

  private $database;
  private $session;
  private $view;

  public function __construct() {
    $this->database = func_get_arg(0);
    $this->session = func_get_arg(1);
    if (func_num_args() === 3) {
      $this->view = func_get_arg(2);
    }
  }

  public function list() : void {
    $username = $this->session->getSessionParam('username');

    $getUserIdQuery = "SELECT * FROM users where username='$username'";
    try {
      $usersArray = $this->database->executeQuery($getUserIdQuery);
    } catch (\Exception $e) {
        echo "Error =>" . $e;
    }
    $userId = $usersArray[0]['id'];

    $getNotesQuery = "SELECT * FROM diary where user_id = '$userId'";
    try {
      $diary = $this->database->executeQuery($getNotesQuery);
    } catch (\Exception $e) {
        echo "Error =>" . $e;
    }

    try {
      $newArray = array();
      array_push($newArray, $username);
      $this->view->render('Views/UserInfoRenderer.php',  $newArray);
      $this->view->render('Views/NotesRenderer.php', $diary);
      $this->view->render('Views/LogoutRenderer.php');
    } catch (\Exception $e) {
      echo "Error => ". $e;
    }
  }

  public function delete() : void {
    try {
      if (isset($_GET['del'])) {
        $idNote = $_GET['del'];
        $deleteNoteQuery = "delete from diary where id='$idNote'";

        //ne znam sta smo rekli, da li da pravim drugacije funkcije u databaseService-u kada ne ocekujem povratnu vrednost
        //ili da mi ostane da koristim ovako
        $results = $this->database->executeQuery($deleteNoteQuery);

        header("location: {$_SERVER['SCRIPT_NAME']}/notes");
      } else {
        throw new \Exception("Note isn't selected for removing");
      }
    } catch (\Exception $e) {
        echo "Error =>" . $e;
    }
  }

  public function add() : void {
    try {
    $username = $this->session->getSessionParam('username');

      $this->view->render("Views/AddNoteRenderer.php");

      if (isset($_POST['save'])) {
        $errors = array();

        //get data for diary
        //da li ove podatke koje dohvatam iz forme, mozda treba nekako drugacije citati, da se ne ponavlja neki kod?
        $title = mysqli_real_escape_string($this->database->getConnection(), $_POST['title']);
        $essay = mysqli_real_escape_string($this->database->getConnection(), $_POST['essay']);

        //handling form validation
        if(empty($title))
          array_push($errors, "Title is required!");
        if(empty($essay))
          array_push($errors, "Essay is required!");

        if (count($errors) == 0) {
          //get current user id from database
          $getUserIdQuery = "SELECT * FROM users WHERE username='$username'";
          $usersArray = $this->database->executeQuery($getUserIdQuery);
          $userID =$usersArray[0]['id'];

          //insert data into database
          $saveDiaryQuery = "INSERT INTO diary (title, essay, user_id) VALUES ('$title', '$essay', '$userID')";
          $results = $this->database->executeQuery($saveDiaryQuery);

          header("location: {$_SERVER['SCRIPT_NAME']}/notes");
        }
        $this->view->render('Views/ErrorsRenderer.php', $errors);
      }elseif (!empty($errors)) {
        throw new \Exception("Content not sent!");
      }
    } catch (\Exception $e) {
        echo "Error => ". $e;
    }
  }

  public function edit() : void {
    //mozda komplikujem sa throw i catch?
    try {
      if (isset($_GET['edit'])) {
        $idNote = $_GET['edit'];

        $renderArray = array();
        array_push($renderArray, $idNote);
        $this->view->render("Views/UpdateNoteRenderer.php", $renderArray);
        if (isset($_POST['edit'])) {
          $errors = array();

          $title = mysqli_real_escape_string($this->database->getConnection(), $_POST['title']);
          $essay = mysqli_real_escape_string($this->database->getConnection(), $_POST['essay']);

          //handling form validation
          if (empty($title))
            array_push($errors, "Title is required!");
          if (empty($essay))
            array_push($errors, "Essay is required!");

          if (count($errors) == 0) {
            $updateNoteQuery = "update diary set essay='$essay', title='$title' where id='$idNote'";
            $results = $this->database->executeQuery($updateNoteQuery);

            header("location: {$_SERVER['SCRIPT_NAME']}/notes");
          }

          $this->view->render('Views/ErrorsRenderer.php', $errors);
        }elseif (!isset($_GET['edit']) && !empty($errors)) {
          throw new \Exception("Update data has not been set!");
        }
      }elseif(!isset($_POST['edit']) && !empty($errors)) {
        throw new \Exception("Note isn't selected for editing");
      }
    } catch (\Exception $e) {
      echo "Error => ". $e;
    }
  }
}