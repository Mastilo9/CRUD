<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>userWelcome</title>
</head>
<body>
<div>
  <?php
  session_start();
  if(isset($_SESSION['username'])) : ?>
    <div>
      <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
    </div>
  <?php endif; ?>

  <form action="server.php" method="post">
    <div>
      <h2>Your diary</h2>
      <?php
      //connect to database
      $database = mysqli_connect('localhost', 'root', 'root', 'crud') or die("could not connect to database");

      session_start();
      $username__ = $_SESSION['username'];

      $getUserIdQuery = "SELECT * FROM users where username='$username__'";
      $results1 = mysqli_query($database, $getUserIdQuery);

      $userId = mysqli_fetch_assoc($results1)['id'];

      //get current user id from database
      $getNotesQuery = "SELECT * FROM diary where user_id = '$userId'";

      $results = mysqli_query($database, $getNotesQuery);
        while ($row = mysqli_fetch_array($results)){  ?>
        <div>
            <label>Title</label>
            <label> <?php echo $row['title']; ?>
            </label>    Essay</label><label> <?php echo $row['essay']; ?></label>
            <a href="server.php?del=<?php echo $row['id'] ?>">delete</a>
        </div>
          <?php } ?>
    </div>
    <div>
        <h2>Create Note</h2>
      <div>
        <label>Title</label>
        <input type="text" name="title" required/>
      </div>
      <div>
        <label>Essay</label>
        <textarea rows="2" cols="80" name="essay" required></textarea>
      </div>
    </div>
    <div>
      <button type="submit" name="save" >SAVE</button>
    </div>
  </form>

    <form action="userWelcome.php" method="post">
        <div>
            <h2>Update Note</h2>
            <div>
                <label>Title(this is for search)</label>
                <input type="text" name="title" required/>
            </div>
            <div>
                <label>Essay(this will be edited)</label>
                <textarea rows="2" cols="80" name="essay" required></textarea>
            </div>
        </div>

        <button type="submit" name="edit" >EDIT</button>
    </form>

  <form action="userWelcome.php" method="get">
    <button type="submit" name="logout" >logout</button>
  </form>

</div>
</body>
</html>

<?php
  if(isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['username']);
      header("location: login.php");
  }
?>