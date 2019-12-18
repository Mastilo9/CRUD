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
<form action="<?php
echo getRelativeURL('index.php');
?>/register" method="post">
  <div>
    <label>Username</label>
    <input type="text" name="username" required/>
  </div>

  <div>
    <label>E-mail</label>
    <input type="email" name="email" required/>
  </div>

  <div>
    <label>Password</label>
    <input type="password" name="password1" required/>
  </div>

  <div>
    <label>Confirm Password</label>
    <input type="password" name="password2" required/>
  </div>

  <button type="submit" name="register">Register</button>
</form>

</body>
</html>