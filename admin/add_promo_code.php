<?php include('header.php'); ?>

<?php
if (!isset($_SESSION['admin_logged_in'])) {
    header('location: login.php');
    exit();
}

if (isset($_POST['add_promo_code_btn'])) {
    $code = trim($_POST['code']);
    $description = trim($_POST['description']);
    $discount_type = $_POST['discount_type'];
    $discount_value = $_POST['discount_value'];
    $min_purchase = $_POST['min_purchase'];
    $max_uses = $_POST['max_uses'];
    
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO promo_codes (code, description, discount_type, discount_value, min_purchase, start_date, end_date, max_uses, is_active) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param(
        "sssddssii",
        $code,
        $description,
        $discount_type,
        $discount_value,
        $min_purchase,
        $start_date,
        $end_date,
        $max_uses,
        $is_active
    );

    if ($stmt->execute()) {
        header('location: promo_codes.php?promo_code_created=Promo code has been created successfully!');
    } else {
        header('location: promo_codes.php?promo_code_failed=Error: Could not create promo code.');
    }
    $stmt->close();
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <?php include('sidemenu.php'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Promo Code</h1>
            </div>

            <div class="mx-auto container">
                <form id="add-promo-code-form" method="POST" action="add_promo_code.php">
                    <div class="mb-3">
                        <label for="code" class="form-label">Promo Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="e.g., SAVE20" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Internal description">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="discount_type" class="form-label">Discount Type</label>
                            <select class="form-select" id="discount_type" name="discount_type" required>
                                <option value="percent">Percentage (%)</option>
                                <option value="fixed">Fixed Amount ($)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="discount_value" class="form-label">Discount Value</label>
                            <input type="number" step="0.01" class="form-control" id="discount_value" name="discount_value" placeholder="e.g., 20 or 5.00" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                         <div class="col-md-6">
                            <label for="min_purchase" class="form-label">Minimum Purchase ($)</label>
                            <input type="number" step="0.01" class="form-control" id="min_purchase" name="min_purchase" value="0.00" required>
                        </div>
                        <div class="col-md-6">
                            <label for="max_uses" class="form-label">Max Uses</label>
                            <input type="number" class="form-control" id="max_uses" name="max_uses" value="1000" required>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date (Optional)</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date (Optional)</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="add_promo_code_btn">Add Promo Code</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>