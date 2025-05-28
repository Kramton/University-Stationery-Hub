<!DOCTYPE html>
<html lang="en">



<head>
  <meta charset="UTF-8">
  <title>Account Page</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .account-box img {
      width: 60px;
      height: 60px;
      margin-bottom: 10px;
    }

    .box-header {
  display: flex;
  align-items: center;
  gap: 10px;
}

.box-header img {
  width: 30px;
  height: 30px;
}
  </style>
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





  <br><br><h1>Your Account</h1><br>
  
  <div class="account-grid">

 <a class="account-box" href="orders.php">
  <div class="box-header">
    <img src="Png/order.jpg" alt="Orders Icon">
    <h2>Your Orders</h2>
  </div>
  <p>Track, return, cancel an order, download invoice or buy again</p>
</a>



    <a class="account-box" href="security.php">
 <div class="box-header">
      <img src="Png/user.jpg" alt="Security Icon">
      <h2>Login & Security</h2>
      
      </div>

      <p>Edit login, name, and mobile number</p>
    </a>



    <a class="account-box" href="address.php">
   <div class = "box-header">
      <img src="Png/home.jpg" alt="Address Icon">
      <h2>Your Addresses</h2>
</div>
      <p>Edit, remove or set default address</p>
    </a>



    <a class="account-box" href="support.php">
        <div class = "box-header">
      <img src="Png/services.jpg" alt="Support Icon">
      <h2>Customer Service</h2>
</div>
      <p>Browse self service options, help articles or contact us</p>
    </a>
 

    <a class="account-box" href="payments.php">
<div class = "box-header">
      <img src="Png/payment.jpg" alt="Payments Icon">
      <h2>Your Payments</h2>
</div>
      <p>Add or manage payment methods and view transaction history</p>
    </a>

    

    
  </div>
</body>
</html>

