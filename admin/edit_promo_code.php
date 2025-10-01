<?php include('header.php'); ?>

<?php
if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

// Logic to fetch the promo code data
if (isset($_GET['promo_code_id'])) {
    $promo_code_id = $_GET['promo_code_id'];
    $stmt = $conn->prepare("SELECT * FROM promo_codes WHERE id = ?");
    $stmt->bind_param('i', $promo_code_id);
    $stmt->execute();
    $promo_code = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$promo_code) {
        header('location: promo_codes.php?edit_failure_message=Promo code not found.');
        exit();
    }
} else if (isset($_POST['edit_promo_code_btn'])) {
    // Logic to update the promo code
    $promo_code_id = $_POST['promo_code_id'];
    $code = trim($_POST['code']);
    $description = trim($_POST['description']);
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $min_purchase = $_POST['min_purchase'];

    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

    $stmt = $conn->prepare("UPDATE promo_codes SET code=?, description=?, discount_type=?, discount_value=?, min_purchase=?, end_date=? WHERE id=?");
    
    $stmt->bind_param(
        "sssddsi",
        $code,
        $description,
        $discount_type,
        $discount_value,
        $min_purchase,
        $end_date,
        $promo_code_id
    );

    if ($stmt->execute()) {
        header('location: promo_codes.php?edit_success_message=Promo code has been updated successfully!');
    } else {
        header('location: promo_codes.php?edit_failure_message=Error: Could not update promo code.');
    }
    $stmt->close();
    exit();
} else {
    // If no ID is provided, redirect
    header('location: promo_codes.php');
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include('sidemenu.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Promo Code</h1>
            </div>

            <div class="mx-auto container">
                <form id="edit-promo-code-form" method="POST" action="edit_promo_code.php">
                    <input type="hidden" name="promo_code_id" value="<?php echo htmlspecialchars($promo_code['id']); ?>">

                    <div class="mb-3">
                        <label for="code" class="form-label">Promo Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="<?php echo htmlspecialchars($promo_code['code']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <input type="text" class="form-control" id="description" name="description" value="<?php echo htmlspecialchars($promo_code['description']); ?>">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select class="form-select" id="discount_type" name="discount_type" required>
                                <option value="percent" <?php if($promo_code['discount_type'] == 'percent') echo 'selected'; ?>>Percentage (%)</option>
                                <option value="fixed" <?php if($promo_code['discount_type'] == 'fixed') echo 'selected'; ?>>Fixed Amount ($)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="number" step="0.01" class="form-control" id="discount_value" name="discount_value" value="<?php echo htmlspecialchars($promo_code['discount_value']); ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                         <div class="col-md-12">
                            <label for="min_purchase" class="form-label">Minimum Purchase ($)</label>
                            <input type="number" step="0.01" class="form-control" id="min_purchase" name="min_purchase" value="<?php echo htmlspecialchars($promo_code['min_purchase']); ?>" required>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="end_date" class="form-label">End Date (Optional)</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="<?php echo !empty($promo_code['end_date']) ? date('Y-m-d\TH:i', strtotime($promo_code['end_date'])) : ''; ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="edit_promo_code_btn">Update Promo Code</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>