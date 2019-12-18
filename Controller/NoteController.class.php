<?php

namespace Controller;

use Services\DatabaseService;

class NoteController {

  private $content;
  private $connection;
  private $database;

  public function getContent(): string
  {
    return $this->content;
  }

  public function setContent(string $content)
  {
    $this->content = $content;
  }

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

  public function __construct(\mysqli $connection, DatabaseService $database) {
    $this->connection = $connection;
    $this->database = $database;
    $this->content = "";
  }

  public function list($username__) {
    include "PathService.php";
    $getUserIdQuery = "SELECT * FROM users where username='$username__'";
    $results1 = $this->database->executeQuery($this->connection, $getUserIdQuery);

    $userId = mysqli_fetch_assoc($results1)['id'];

    //get current user id from database
    $getNotesQuery = "SELECT * FROM diary where user_id = '$userId'";

    $results = $this->database->executeQuery($this->connection, $getNotesQuery);

    ob_start();
    while ($row = mysqli_fetch_array($results)){ ?>
      <div>
        <label>Title</label>
        <label> <?php echo $row['title']; ?>
        </label>    Essay</label><label> <?php echo $row['essay']; ?></label>
        <a href="<?php echo getRelativeURL('index.php'); ?>/notes/delete?del=<?php echo $row['id'] ?>">delete</a>
        <a href="<?php echo getRelativeURL('index.php'); ?>/notes/edit?edit=<?php echo $row['id'] ?>">edit</a>
      </div>
    <?php } ;
    $this->content= ob_get_clean();
  }

  public function delete(int $idNote) {
    include "PathService.php";
    $deleteNoteQuery = "delete from diary where id='$idNote'";
    $results = $this->database->executeQuery($this->connection, $deleteNoteQuery);
    $tmp = getRelativeURL('index.php');

      header("location: {$tmp}/notes");
  }

  public function add(string $username) : array {

    $errors = array();

    if (isset($_POST['save'])) {
      //initializing variables
      $userID= 0;
      $title = "";
      $essay = "";

      //get data for diary
      $title = mysqli_real_escape_string($this->connection, $_POST['title']);
      $essay = mysqli_real_escape_string($this->connection, $_POST['essay']);

      //handling form validation
      if(empty($title))
        array_push($errors, "Title is required!");
      if(empty($essay))
        array_push($errors, "Essay is required!");

      //get current user id from database
      $getUserIdQuery = "SELECT * FROM users WHERE username='$username'";

      $results =  $this->database->executeQuery($this->connection, $getUserIdQuery);
      $userID = mysqli_fetch_assoc($results)['id'];

      //insert data into database
      if (count($errors) == 0) {

        $saveDiaryQuery = "INSERT INTO diary (title, essay, user_id) VALUES ('$title', '$essay', '$userID')";

        $results = $this->database->executeQuery($this->connection, $saveDiaryQuery);

        $tmp = getRelativeURL('index.php');

        header("location: {$tmp}/notes");
      }
    }
    return $errors;
  }

  public function edit($idNote) : array {

    $errors = array();

    if( isset($_POST['edit'])) {
      $title = "";
      $essay = "";

      $title = mysqli_real_escape_string($this->connection, $_POST['title']);
      $essay = mysqli_real_escape_string($this->connection, $_POST['essay']);

      //handling form validation
      if (empty($title))
        array_push($errors, "Title is required!");
      if (empty($essay))
        array_push($errors, "Essay is required!");

      if (count($errors) == 0) {
        $updateNoteQuery = "update diary set essay='$essay', title='$title' where id='$idNote'";

        $results = $this->database->executeQuery($this->connection, $updateNoteQuery);

        $tmp = getRelativeURL('index.php');

        header("location: {$tmp}/notes");
      }
    }
    return $errors;
  }
}