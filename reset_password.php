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

<style>
  .confirm-btn {
    background-color: coral;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 10px;
  }
</style>

<?php include('layouts/header.php') ?>

<!-- Reset Password -->
<section id="contact" class="container my-5 py-5">
    <div class="container text-center mt-5">
        <h2>Reset Password</h2>
        <hr class="mx-auto" />
        <p>Please enter a new password.</p>

        <form method="POST" action="process_reset_password.php">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <div class="row justify-content-center">
                <div class="col-12 col-md-4">
                    <div class="d-grid gap">
                        Password<input required type="password" name="password" id="password" placeholder="Enter new password" class="form-control mb-3">
                        Confirm Password<input required type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm new password" class="form-control">
                        <button class="confirm-btn">Confirm</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>