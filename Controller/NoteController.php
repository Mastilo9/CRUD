<?php

namespace Controller;

use Services\DatabaseService;
use Services\SessionService;
use Services\ViewService;

class NoteController {

  private $content;
  private $database;
  private $session;

  public function __construct(DatabaseService $database, SessionService $session) {
    $this->database = $database;
    $this->session = $session;
    $this->content = "";
  }

  public function list() : void {
    $username = $this->session->getSessionParam('username');

    $getUserIdQuery = "SELECT * FROM users where username='$username'";
    try {
      $usersArray = $this->database->executeQuery($getUserIdQuery);
    } catch (\Exception $e) {
        echo "Error =>" . $e;
    }
    //executeQuery mi vraca rezultate u nizu nizova, pa ako imam samo jedan povratni to mi je opet prvi clan niza koji je niz,
    //da li treba zbog ovog da razdvajam, na fje gde ocekujem vise i na fje gde ocekujem jedan red iz tabele kao povratnu vrednost?
    $userId = $usersArray[0]['id'];

    $getNotesQuery = "SELECT * FROM diary where user_id = '$userId'";
    try {
      $diary = $this->database->executeQuery($getNotesQuery);
      //da li je bolje stavljati ovako odvojena dva try i catch bloka ili je bolje da obmotam sve ovo u jedan?
      //ovde sam razdvojio, dole sam obmotao u jedan
    } catch (\Exception $e) {
        echo "Error =>" . $e;
    }

    $viewService = new ViewService();
    try {
      $viewService->render($username, 'Views/UserInfoRenderer.php');
      $viewService->renderContentArray($diary, 'Views/NotesRenderer.php');
      $viewService->render('', 'Views/LogoutRenderer.php');
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

    $viewService =  new ViewService();
    $viewService->render("", "Views/AddNoteRenderer.php");


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
        $viewService->renderContentArray($errors, 'Views/ErrorsRenderer.php');
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

        $viewService = new ViewService();
        $viewService->render($idNote, "Views/UpdateNoteRenderer.php");
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

          $viewService->renderContentArray($errors, 'Views/ErrorsRenderer.php');
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