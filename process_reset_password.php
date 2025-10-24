<?php

$token = $_POST["token"];
$token_hash = hash("sha256", $token);

include('server/connection.php');

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user === null) {
    die("token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$sql = "UPDATE users
        SET user_password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $password_hash, $user["user_id"]);
$stmt->execute();

?>

<?php include('layouts/header.php') ?>

<style>
    .return-to-page-btn {
        background-color: coral;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
        text-decoration: none;
    }
</style>

<!-- Reset Password -->
<section id="contact" class="container my-5 py-5">
    <div class="container text-center mt-5">
        <h2 class="form-weight-bold">Password Changed</h2>
        <hr class="mx-auto" />

        <div>
            <p>Your password has been changed successfully.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                <div class="d-grid gap-2">
                    <a href="http://localhost/University-Stationery-Hub/login.php" class="return-to-page-btn">Continue</a>
                </div>
            </div>
        </div>
    </div>


</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>