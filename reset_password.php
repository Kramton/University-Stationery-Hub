<!-- https://youtu.be/R9bfts9ZFjs?si=_4Gu_A2MJBd-ZBfz -->

<?php

$token = $_GET["token"];
$token_hash = hash("sha256", $token);

include('server/connection.php');

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token_hash);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if($user === null) {
    die("token not found");
}

if(strtotime($user["reset_token_expires_at"]) <= time()) {
    die("token has expired");
}

?>


<?php include('layouts/header.php') ?>

<!-- Reset Password -->
<section id="contact" class="container my-5 py-5">
    <div class="container text-center mt-5">
        <h3>Reset Password</h3>
        <hr class="mx-auto" />

        <form method="POST" action="process_reset_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            
            <p>Password</p>
            <label for="password"></label>
            <input type="text" id="password" name="password">

            <p>Confirm Password</p>
            <label for="password_confirmation"></label>
            <input type="text" id="password_confirmation" name="password_confirmation">

            <button>Send</button>
        </form>

</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>