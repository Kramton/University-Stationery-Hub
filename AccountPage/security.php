<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login & Security</title>
  <link rel="stylesheet" href="style.css">
  

</head>
<body>

<div class="topbar">
  <div class="topbar-left">
    <img src="Png/USHlogo.jpg" alt="Logo" class="logo">
    <span class="brand-name">University Stationery Hub</span>
  </div>

<div class="topbar-right">
<a href="index.html">Home</a>
<a href="products.html">Product</a>
 <a href="account.php">Account</a>
<input type="text" placeholder="Search...">
<button>Search</button>
<img src="Png/user.jpg" alt="User" class="user-img">
<span class="user-name">User1</span></div></div>






 <br> <br><h1 style="text-align:center;">Login & Security</h1>

  <div class="section">
    
    <!-- Name -->
    <div class="info-item">
      <div class="label-row">
        <div class="label-left">
          <strong>Name:</strong>
          <span id="name-display">User1</span>
        </div>
        <button class="edit-button" onclick="toggleEdit('name')">Edit</button>
      </div>
      <div class="edit-field" id="name-edit">
        <input type="text" id="name-input" value="User1">
        <button class="save-button" onclick="saveEdit('name')">Save</button>
      </div>
    </div>

    <!-- Email -->
    <div class="info-item">
      <div class="label-row">
        <div class="label-left">
          <strong>Email:</strong>
          <span id="email-display">abc@gmail.com</span></div>

        <button class="edit-button" onclick="toggleEdit('email')">Edit</button>
</div>
      <div class="edit-field" id="email-edit">
        <input type="email" id="email-input" value="abc@gmail.com">
        <button class="save-button" onclick="saveEdit('email')">Save</button>
      </div>
    </div>

    <!-- Password -->
    <div class="info-item label-row">
      <div class="label-left">
        <strong>Password:</strong>
        <span>**********</span>
      </div>
      <a href="ResetPassword.php"><button class="edit-button">Edit</button></a>
    </div>

  </div>

  <script>

    function toggleEdit(field) 
    {
      document.getElementById(`${field}-edit`).style.display = 'block';
    }

    function saveEdit(field) 
    {
      const input = document.getElementById(`${field}-input`).value;
      if (field === 'email') 
      {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(input)) 
        {
          alert("Please enter a valid email.");
          return;}}

      document.getElementById(`${field}-display`).textContent = input;
      document.getElementById(`${field}-edit`).style.display = 'none';
      alert(`${field.charAt(0).toUpperCase() + field.slice(1)} updated successfully!`);
    }
  </script>


<a class="back-link" href="account.php">« Back to Login & Security</a>
</body>
</html>

