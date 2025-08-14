<?php
include('layouts/header.php');
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}

// Handle profile update
if (isset($_POST['save_changes'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_SESSION['user_email'];

    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=? WHERE user_email=?");
    $stmt->bind_param('sss', $first_name, $last_name, $email);
    $stmt->execute();

    $_SESSION['user_name'] = $first_name . ' ' . $last_name;

    header('location: my_profile.php?message=Profile updated successfully');
    exit;
}

// Handle password change
if (isset($_POST['change_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $email = $_SESSION['user_email'];

    $stmt = $conn->prepare("SELECT user_password FROM users WHERE user_email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_pass, $hashed_password)) {
        header('location: my_profile.php?error=Current password is incorrect');
        exit;
    }
    if ($new_pass !== $confirm_pass) {
        header('location: my_profile.php?error=Passwords do not match');
        exit;
    }
    if (strlen($new_pass) < 6) {
        header('location: my_profile.php?error=Password must be at least 6 characters');
        exit;
    }

    $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
    $stmt->bind_param('ss', $hashed_new_pass, $email);

    if ($stmt->execute()) {
        header('location: my_profile.php?message=Password updated successfully');
    } else {
        header('location: my_profile.php?error=Could not update password');
    }
    exit;
}
?>

<style>
    body {
        padding-top: 110px;
        /* Increased so heading is fully visible */
        font-family: 'Poppins', sans-serif;
    }

    .account-container {
        max-width: 1200px;
        margin: auto;
    }

    .account-title {
        font-size: 40px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 40px;
    }

    .sidebar {
        padding-right: 20px;
    }

    .sidebar h5 {
        margin-bottom: 20px;
        font-weight: 500;
    }

    .sidebar a {
        display: block;
        padding: 8px 0;
        color: #000;
        text-decoration: none;
    }

    .sidebar a.active {
        color: #F15A29;
        font-weight: 600;
    }

    .content-box {
        background: #fff;
        padding: 30px;
        border-radius: 6px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .content-box h5 {
        color: #F15A29;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .content-box label {
        margin-top: 10px;
        font-weight: 400;
    }

    .btn-orange {
        background-color: #F15A29;
        color: #fff;
        border: none;
        padding: 8px 18px;
    }

    .btn-orange:hover {
        background-color: #d94d20;
    }

    hr {
        border: 0;
        height: 2px;
        background-color: #F15A29;
        width: 40px;
        margin: 20px 0;
    }
</style>

<section class="account-container">
    <h2 class="account-title">Account</h2>
    <?php if (isset($_GET['error'])) { ?>
        <p style="color:red; text-align:center;"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <?php if (isset($_GET['message'])) { ?>
        <p style="color:green; text-align:center;"><?php echo $_GET['message']; ?></p>
    <?php } ?>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <h5>Manage My Account</h5>
            <a href="my_profile.php" class="active">My Profile</a>
            <a href="my_orders.php">My Orders</a>
        </div>

        <!-- Profile Form -->
        <div class="col-md-9">
            <div class="content-box">
                <h5>Edit Your Profile</h5>
                <form method="POST" action="my_profile.php">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control"
                        value="<?php echo explode(' ', $_SESSION['user_name'])[0]; ?>" required>

                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control"
                        value="<?php echo explode(' ', $_SESSION['user_name'])[1] ?? ''; ?>" required>

                    <label>Email</label>
                    <input type="email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>" disabled>

                    <br>
                    <button type="submit" name="save_changes" class="btn btn-orange">Save Changes</button>
                </form>

                <hr>

                <h5>Password Changes</h5>
                <form method="POST" action="my_profile.php">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>

                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" required>

                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>

                    <br>
                    <button type="submit" name="change_password" class="btn btn-orange">Change Password</button>
                </form>





                <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
                    <p><a href="my_profile.php?logout=1" id="logout-btn">Logout</a></p>
                </div>






            </div>
        </div>
    </div>
</section>

<?php include('layouts/footer.php'); ?>