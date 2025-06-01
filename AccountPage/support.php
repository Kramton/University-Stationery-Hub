<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Customer Support</title>
  <link rel="stylesheet" href="css/topbar.css">
  <link rel="stylesheet" href="css/supportStyle.css">
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




  <div class="support-content">
 <h1>Customer Support</h1>

<section class="contact-info">
 <h2>Contact Information</h2>
 <p>If you have any questions or need assistance, please contact us through any of the following methods:</p>
 <ul>
 <li><strong>Email:</strong> support@universitystationeryhub.com</li>
 <li><strong>Phone:</strong> +64</li>
 <li><strong>Office Hours:</strong> Monday - Friday, 9:00 AM - 6:00 PM</li><br>
 </ul></section> 





    <section class="faq">
      <h2>Frequently Asked Questions</h2>
      <div class="faq-item">
        <strong>Q: How do I track my order?</strong>
        <p>A: You can track your order by logging into your account and navigating to the 'Order History' section.</p>
      </div>
      <div class="faq-item">
        <strong>Q: What payment methods do you accept?</strong>
        <p>A: We accept all major credit cards, debit cards, PayPal and pay in cash at the store.</p>
      </div>
      <div class="faq-item">
        <strong>Q: Can I return a product?</strong>
        <p>A: Yes, we have a 15-day return policy.</p>
      </div>
    </section>

    <section class="contact-form">
      <h2>Submit a Request</h2>
      <p>If you couldn't find the answer you're looking for, please fill out the form below to submit a support request:</p>
      <form action="submit_ticket.php" method="POST">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Submit Request</button>
      </form>
    </section>
  </div>

  <script>
    // You can add any JavaScript if needed (e.g., form validation or interactivity)
  </script>
</body></html>
