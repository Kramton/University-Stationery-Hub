
<?php include('layouts/header.php') ?>

<!-- Reset Password -->
<section id="contact" class="container my-5 py-5">
    <div class="container text-center mt-5">
        <h3>Reset Password</h3>
        <hr class="mx-auto" />

        <form method="POST" action="send_password_reset.php">

            <label for="email">Email</label>
            <input type="email" name="email" id="email">

            <button>Send</button>

        </form>

        <!-- <p class="w-50 mx-auto">Phone number: <span>123 456 7890</span></p>
        <p class="w-50 mx-auto">
          Email Address: <span>universitystationaryhub@mail.com</span>
        </p>
        <p class="w-50 mx-auto">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate
          omnis aperiam magni facere cupiditate laudantium, laboriosam, cum,
          voluptates vero recusandae dolores repellat doloribus porro? Provident
          consequuntur quisquam sapiente adipisci error!
        </p>
      </div> -->
</section>

<!-- Footer -->
<?php include('layouts/footer.php') ?>


<?php

?>