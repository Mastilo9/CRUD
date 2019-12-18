<?php
include 'autoloader.php';

use Controller\NoteController;
use Controller\UserController;
use Services\DatabaseService;
use Services\SessionService;
use Services\ViewService;

$session = new SessionService();
$session->init();

$database = new DatabaseService('localhost', 'root', 'root', 'crud');
//mozda je bolje da sam konekciju zapamtio kao privatni parametar objekta, pa da sam ga onda dohvatao kad god mi treba
//a ne slao kao povratnu vrednost fje
$connection = $database->connect();

//prepare url for switch function
function prepareURL(string $url) :string {
  $relativeURL = str_replace("/crud", "",$url);
  return strtok($relativeURL, '?');
}

  try {
    switch (prepareURL($_SERVER['REQUEST_URI'])) {
      case '/index.php/notes':
        $controller = new NoteController($connection, $database);
        $userContent = $session->getSessionParam('username');
        $controller->list($userContent);
        $content = $controller->getContent();
        $viewService = new ViewService();
        $viewService->render($userContent, 'Views/UserInfoRenderer.php');
        $viewService->render($content, 'Views/NotesRenderer.php');
        $viewService->render('', 'Views/LogoutRenderer.php');
        break;

      case '/index.php/notes/delete':
        if (isset($_GET['del'])){
          $idNote= $_GET['del'];
          $controller = new NoteController($connection, $database);
          $controller->delete($idNote);
        }
        break;

      case '/index.php/notes/edit':
        if (isset($_GET['edit'])){
          $idNote= $_GET['edit'];
          $viewService =  new ViewService();
          $viewService->render($idNote, "Views/UpdateNoteRenderer.php");
          $controller = new NoteController($connection, $database);
          $errors = $controller->edit($idNote);
          $viewService->renderContentArray($errors, 'Views/ErrorsRenderer.php');
        }
        break;

      case '/index.php/notes/add':
        $viewService =  new ViewService();
        $viewService->render("", "Views/AddNoteRenderer.php");
        $controller = new NoteController($connection, $database);
        $username = $session->getSessionParam('username');
        $errors = $controller->add($username);
        $viewService->renderContentArray($errors, 'Views/ErrorsRenderer.php');
        break;

      case '/index.php' :
        $viewService = new ViewService();
        $content = "";
        $viewService->render($content, 'Views/HomeRenderer.php');
        break;

      case '/index.php/login':
        $controller = new UserController($connection, $database);
        $errors = $controller->login();
        $viewService = new ViewService();
        $viewService->renderContentArray($errors, 'Views/ErrorsRenderer.php');
        $viewService->render("", 'Views/LoginRenderer.php');

        break;


      case '/index.php/logout':
        $controller = new UserController($connection, $database);
        $controller->logout($session, 'username');
        break;

      case '/index.php/register':
        $controller = new UserController($connection, $database);
        $errors = $controller->register();
        $viewService = new ViewService();
        $viewService->renderContentArray($errors, 'Views/ErrorsRenderer.php');
        $viewService->render("", 'Views/RegistrationRenderer.php');
        break;

    }
  } catch (Exception $exception) {
    echo "Greska";
  }

//  $session->close();


