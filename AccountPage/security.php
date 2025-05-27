<!-- security.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login & Security</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Login & Security</h1>
  <form action="#" method="post">
    <label for="username">Username / Email:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Current Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="new-password">New Password:</label><br>
    <input type="password" id="new-password" name="new-password"><br><br>

    <label for="phone">Mobile Number:</label><br>
    <input type="tel" id="phone" name="phone"><br><br>

    <input type="submit" value="Update Info">
  </form>

  <a href="account.php">← Back to Account</a>
</body>
</html>

