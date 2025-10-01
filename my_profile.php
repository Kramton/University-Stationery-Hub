<?php
include('layouts/header.php');
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
  header('location: login.php');
  exit;
}

/* ---- Helpers ---- */
function split_name($full)
{
  $parts = preg_split('/\s+/', trim($full ?? ''), 2);
  return [$parts[0] ?? '', $parts[1] ?? ''];
}
[$firstNamePrefill, $lastNamePrefill] = split_name($_SESSION['user_name'] ?? '');

/* ---- Handle Logout (bottom button) ---- */
if (isset($_GET['logout']) && $_GET['logout'] === '1') {
  unset($_SESSION['logged_in'], $_SESSION['user_email'], $_SESSION['user_name']);
  header('location: login.php');
  exit;
}

/* ---- Submit: profile (and optional password) ---- */
if (isset($_POST['save_all'])) {
  $email = $_SESSION['user_email'];
  $first_name = trim($_POST['first_name'] ?? '');
  $last_name = trim($_POST['last_name'] ?? '');

  // Update profile
  if ($first_name !== '' || $last_name !== '') {
    $full_name = trim($first_name . ' ' . $last_name);
    $stmt = $conn->prepare("UPDATE users SET user_name=? WHERE user_email=?");
    $stmt->bind_param('ss', $full_name, $email);
    $stmt->execute();
    $stmt->close();
    $_SESSION['user_name'] = $full_name;
  }

  // Optional password change (only if any field provided)
  $current_pass = $_POST['current_password'] ?? '';
  $new_pass = $_POST['new_password'] ?? '';
  $confirm_pass = $_POST['confirm_password'] ?? '';
  $changing = ($current_pass !== '' || $new_pass !== '' || $confirm_pass !== '');

  if ($changing) {
    if ($current_pass === '' || $new_pass === '' || $confirm_pass === '') {
      header('location: my_profile.php?error=Please+fill+all+password+fields');
      exit;
    }
    if ($new_pass !== $confirm_pass) {
      header('location: my_profile.php?error=Passwords+do+not+match');
      exit;
    }
    if (strlen($new_pass) < 6) {
      header('location: my_profile.php?error=Password+must+be+at+least+6+characters');
      exit;
    }

    $stmt = $conn->prepare("SELECT user_password FROM users WHERE user_email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($hash);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_pass, $hash)) {
      header('location: my_profile.php?error=Current+password+is+incorrect');
      exit;
    }

    $new_hash = password_hash($new_pass, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
    $stmt->bind_param('ss', $new_hash, $email);
    $stmt->execute();
    $stmt->close();

    header('location: my_profile.php?message=Profile+and+password+updated+successfully');
    exit;
  }

  header('location: my_profile.php?message=Profile+updated+successfully');
  exit;
}
?>

<style>
  body {
    padding-top: 110px;
    font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif
  }

  .container-account {
    max-width: 1120px;
    margin: 0 auto;
    padding: 0 16px
  }

  .page-title {
    font-size: 36px;
    font-weight: 700;
    text-align: center;
    margin: 6px 0 26px
  }

  .grid {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 40px;
    align-items: start
  }

  @media(max-width:992px) {
    .grid {
      grid-template-columns: 1fr
    }
  }

  /* Sidebar (no borders; no logout) */
  .sidebar-title {
    font-size: 14px;
    color: #7a7a7a;
    margin-bottom: 12px
  }

  .navlink {
    display: block;
    padding: 6px 0;
    color: #111;
    text-decoration: none
  }

  .navlink.active {
    color: #F15A29;
    font-weight: 600
  }

  /* Main content */
  .section-title {
    font-size: 16px;
    font-weight: 600;
    margin: 6px 0 12px;
    color: #222
  }

  .muted {
    color: #666;
    font-size: 13px;
    margin-bottom: 10px
  }

  .row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px
  }

  @media(max-width:576px) {
    .row-2 {
      grid-template-columns: 1fr
    }
  }

  /* Inputs (flat, light placeholders) */
  .control {
    width: 100%;
    padding: 12px 14px;
    border: none;
    border-radius: 6px;
    background: #f5f5f5;
    color: #111;
    font-size: 14px
  }

  .control::placeholder {
    color: #9d9d9d
  }

  .control[disabled] {
    background: #e9e9e9;
    color: #666
  }

  .block {
    margin-bottom: 28px
  }

  .msg,
  .err {
    margin: 0 0 14px;
    font-size: 14px
  }

  .msg {
    color: #1a7f37
  }

  .err {
    color: #b42318
  }

  .actions {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 12px;
    flex-wrap: wrap
  }

  .link-cancel {
    color: #666;
    text-decoration: none;
    font-weight: 500
  }

  .link-cancel:hover {
    text-decoration: underline;
    color: #333
  }

  .btn-primary {
    background: #F15A29;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 10px 16px;
    font-weight: 600;
    cursor: pointer
  }

  .btn-primary:hover {
    background: #e14e1e
  }

  .btn-secondary {
    background: #efefef;
    color: #111;
    border: none;
    border-radius: 6px;
    padding: 10px 16px;
    font-weight: 600;
    cursor: pointer
  }

  .btn-secondary:hover {
    background: #e6e6e6
  }
</style>

<div class="container-account">
  <h2 class="page-title">Account</h2>

  <?php if(isset($_GET['error'])): ?>
    <p class="err" style="text-align:center;"><?= htmlspecialchars($_GET['error']) ?></p>
  <?php endif; ?>
  <?php if(isset($_GET['message'])): ?>
    <p class="msg" style="text-align:center;"><?= htmlspecialchars($_GET['message']) ?></p>
  <?php endif; ?>

  <div class="grid">
    <!-- Sidebar -->
    <aside>
      <div class="sidebar-title">Manage My Account</div>
      <a class="navlink active" href="my_profile.php">My Profile</a>
      <a class="navlink" href="my_orders.php">My Orders</a>
    </aside>

    <!-- Main -->
    <main>
      <form method="POST" action="my_profile.php">
        <!-- Profile -->
        <section class="block">
          <div class="section-title">Edit Your Profile</div>

          <div class="row-2" style="margin-top:8px;">
            <div>
              <label class="muted">First Name</label>
              <input class="control" type="text" name="first_name" value="<?= htmlspecialchars($firstNamePrefill) ?>"
                required>
            </div>
            <div>
              <label class="muted">Last Name</label>
              <input class="control" type="text" name="last_name" value="<?= htmlspecialchars($lastNamePrefill) ?>"
                required>
            </div>
          </div>

          <div style="margin-top:14px;">
            <label class="muted">Email</label>
            <input class="control" type="email" value="<?= htmlspecialchars($_SESSION['user_email']) ?>" disabled>
          </div>
        </section>

        <!-- Password (single vertical stack) -->
        <section class="block">
          <div class="section-title">Password Changes</div>

          <div style="margin:8px 0;">
            <input class="control" type="password" name="current_password" placeholder="Current Password">
          </div>

          <div style="margin:8px 0;">
            <input class="control" type="password" name="new_password" placeholder="New Password">
          </div>

          <div style="margin:8px 0;">
            <input class="control" type="password" name="confirm_password" placeholder="Confirm New Password">
          </div>
        </section>

        <!-- Bottom actions: Cancel, Save, Logout -->
        <div class="actions">
          <a class="link-cancel" id="cancelBtn" href="my_profile.php" style="display:none;">Cancel</a>
          <button class="btn-primary" type="submit" name="save_all">Save Changes</button>
        </div>
        <script>
        // Show Cancel button only if any input is changed
        const cancelBtn = document.getElementById('cancelBtn');
        const form = document.querySelector('form[action="my_profile.php"]');
        const watchedFields = [
          ...form.querySelectorAll('input[name="first_name"], input[name="last_name"], input[name="current_password"], input[name="new_password"], input[name="confirm_password"]')
        ];
        let pristine = true;
        watchedFields.forEach(field => {
          field.addEventListener('input', () => {
            if (pristine && (field.value.trim() !== '')) {
              cancelBtn.style.display = '';
              pristine = false;
            }
          });
        });
        </script>
        <div style="margin-top:100px;">
          <a class="btn-secondary" href="my_profile.php?logout=1">Logout</a>
        </div>
      </form>
    </main>
  </div>
</div>

<?php include('layouts/footer.php'); ?>