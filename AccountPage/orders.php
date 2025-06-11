
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">

  <title>Your Orders</title>
  
<link rel="stylesheet" href="css/topbar.css">
<link rel="stylesheet" href="css/ordersStyle.css">


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




  <h1>Your Orders</h1>
<h3><p style="text-align: center; color: black; font-size: 16px;">
  Here you can view, track, return, or reorder your past purchases.
 </p></h3>

  <div class="order-list">
    <div class="order-item">
      <h2>Order #1</h2>
      <p>Date: 2025-05-20</p>
      <p>Status: Read for pick up</p>
      <button>View Details</button>
      <button>Reorder</button>
    </div>
    <div class="order-item">
      <h2>Order #2</h2>
      <p>Date: 2025-05-21</p>
      <p>Status: In Transit</p>
      <button>Track Package</button>
      <button>Cancel Order</button>
    </div>
  </div>

<a class="back-link" href="account.php">« Back to Account</a>


</body>
</html>
