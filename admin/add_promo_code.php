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
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

    $stmt = $conn->prepare("INSERT INTO promo_codes (code, description, discount_type, discount_value, min_purchase, end_date, is_active) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param(
        "sssddsi",
        $code,
        $description,
        $discount_type,
        $discount_value,
        $min_purchase,
        $end_date,
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

<style>
  /* Toggle Switch Styles */
  .toggle-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
  }

  .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 24px;
  }

  .toggle-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
  }

  input:checked + .toggle-slider {
    background-color: #28a745;
  }

  input:checked + .toggle-slider:before {
    transform: translateX(26px);
  }
</style>

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
                         <div class="col-md-12">
                            <label for="min_purchase" class="form-label">Minimum Purchase ($)</label>
                            <input type="number" step="0.01" class="form-control" id="min_purchase" name="min_purchase" value="0.00" required>
                        </div>
                    </div>
                     <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="end_date" class="form-label">End Date (Optional)</label>
                            <input type="datetime-local" class="form-control" id="end_date" name="end_date">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block">Status</label>
                        <label class="toggle-switch">
                            <input type="checkbox" id="is_active" name="is_active" checked>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="ms-2">Active (Promo code will be immediately available for use)</span>
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
<script src="https://unpkg.com/feather-icons"></script>
<script>
  feather.replace();
</script>
</body>
</html>