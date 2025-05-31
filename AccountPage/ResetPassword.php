 <!-- Restpw.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>ResetPassword</title>

<link rel="stylesheet" href="css/topbar.css">
<link rel="stylesheet" href="css/resetPasswordStyle.css">

</head>
<body>




  <!-- topbar -->
<div class="topbar">
  <div class="topbar-left">
    <img src="Png/USHlogo.jpg" alt="Logo" class="logo">
    <span class="brand-name">University Stationery Hub</span>
  </div>

<div class="topbar-right">
<a href="index.html">Home</a>
<a href="products.html">Product</a>

<input type="text" placeholder="Search...">
<button>Search</button>
 <a href="account.php" class="user-account-link" style="display: flex; align-items: center; gap: 5px;">
  <img src="Png/user.jpg" alt="User" class="user-img">
  <span class="user-name">User1</span>
</a>

</div></div>









<br><br>  <h1>Reset Password</h1>
  <div class="container">
    <form method="post" action="update_security.php">

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br><br>

      <label for="phone">Mobile Number:</label><br>
<input type="tel" id="phone" name="phone"
       pattern="\d{10,12}"
       title="Mobile number must be 10 to 12 digits"
       required><br><br>


      <label for="password">Current Password:</label><br>
    <input type="password" id="password" name="password" 
       pattern="(?=.*[A-Z]).{10,12}" 
       title="Password must be 10-12 characters long and include at least one uppercase letter." 
       required><br><br>

<label for="new-password">New Password:</label><br>
<input type="password" id="new-password" name="new-password"
       pattern="(?=.*[A-Z]).{10,12}" 
       title="Password must be 10-12 characters long and include at least one uppercase letter." 
><br><br>


      <button type="submit">Update Information</button>
    </form>
  </div>


  <a class="back-link" href="security.php">« Back to Login & Security</a>


</body>
</html>
