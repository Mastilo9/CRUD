<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration</title>
</head>
<body>
<div>
  <h2>Register</h2>
</div>
<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>/register" method="post">
  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required/>
  </div>

  <div>
    <label for="email">E-mail</label>
    <input type="email" name="email" id="email" required/>
  </div>

  <div>
    <label for="password">Password</label>
    <input type="password" name="password1" id="password" required/>
  </div>

  <div>
    <label for="password2">Confirm Password</label>
    <input type="password" name="password2" id="password2" required/>
  </div>

  <button type="submit" name="register">Register</button>
</form>

</body>
</html>