<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
<div>
  <h2>Login</h2>
</div>
<form action="login.php" method="post">
  <?php include ('errors.php') ?>

  <div>
    <label>Username</label>
    <input type="text" name="username" required/>
  </div>

  <div>
    <label>Password</label>
    <input type="password" name="password" required/>
  </div>

  <button type="submit" name="login">Login</button>
</form>

</body>
</html>
