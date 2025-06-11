<!-- payments.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payments</title>
 <!-- In payments.php -->
<link rel="stylesheet" href="css/topbar.css">
<link rel="stylesheet" href="css/paymentsStyle.css">

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
    <a href="account.php" class="user-account-link" style="display: flex; align-items: center; gap: 5px;">
      <img src="Png/user.jpg" alt="User" class="user-img">
      <span class="user-name">User1</span>
    </a>
  </div>
</div>

<br><br>
<h1>Payments</h1>

<div class="container">
  
 <!-- <div class="section">
    <h2>Wallet</h2>
    <p>Balance: <strong>$50.00</strong></p>
    <button style="margin-top: 10px;">Top Up Wallet</button>
  </div>-->

  <!-- cards & ac  -->
  <div class="section">
    <h2>Cards & Accounts</h2>
    <p>Visa ending in 1234</p>
  </div>

  <!-- add payment-->
  <div class="section">
    <h2>Add a Payment Method</h2>
    <form method="post" action="add_payment.php">
      <label for="cardNumber">Card Number:</label>
      <input type="text" id="cardNumber" name="cardNumber" required>

      <label for="expiryDate">Expiry Date:</label>
      <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>

      <label for="cvv">CVV:</label>
      <input type="text" id="cvv" name="cvv" required>

      <button type="submit">Add Card</button>
    </form>
  </div>
</div>

<a class="back-link" href="account.php">« Back to Account</a>

</body>
</html>
