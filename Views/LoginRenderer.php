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

<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>/login" method="post">

  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required/>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required/>
  </div>

  <button type="submit" name="login">Login</button>
</form>

</body>
</html>