<?php
session_start();

if (isset($_POST['order_pay_btn'])) {
  $order_status = $_POST['order_status'];
  $order_total_price = $_POST['order_total_price'];
}


?>

<?php include('layouts/header.php') ?>

<!-- Payment -->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-5">
    <h2 class="form-weight-bold">Payment</h2>
    <hr class="mx-auto" />
  </div>
  <div class="mx-auto container text-center">

    <?php if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>

      <?php $amount = $_SESSION['total']; ?>

      <p>Total payment: $<?php echo $_SESSION['total']; ?></p>
      <!-- <input class="btn btn-primary" type="submit" value="Pay Now"> -->
      <!-- Set up container element for the button -->
      <div id="paypal-button-container"></div>

    <?php } else if (isset($_POST['order_status']) && $_POST['order_status'] == "not paid") { ?>
      <?php $amount = $_POST['order_total_price']; ?>
        <p>Total Payment: $<?php echo $_POST['order_total_price']; ?></p>
        <!-- <input class="btn btn-primary" type="submit" value="Pay Now"> -->
        <!-- Set up container element for the button -->
        <div id="paypal-button-container"></div>

    <?php } else { ?>
        <p>Your cart is empty!</p>
    <?php } ?>



  </div>
</section>


<p id="result-message"></p>
<!-- Initialize the JS-SDK -->
<script
  src="https://www.paypal.com/sdk/js?client-id=AYVYkWacTQ3tL6cxbCL_dadNr50VG2t0_Lhc3zKvlOA-h_tmHoAgQ7a7CdpkKcutRDig3PTuwYMrJP8c&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
  data-sdk-integration-source="developer-studio"></script>
<script>
  const paypalButtons = window.paypal.Buttons({
   style: {
        shape: "rect",
        layout: "vertical",
        color: "gold",
        label: "paypal",
    },
   message: {
        amount: <?php echo $amount; ?>,
    },
   async createOrder() {
        try {
            const response = await fetch("/api/orders", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                // use the "body" param to optionally pass additional order information
                // like product ids and quantities
                body: JSON.stringify({
                    cart: [
                        {
                            id: "YOUR_PRODUCT_ID",
                            quantity: "YOUR_PRODUCT_QUANTITY",
                        },
                    ],
                }),
            });

            const orderData = await response.json();

            if (orderData.id) {
                return orderData.id;
            }
            const errorDetail = orderData?.details?.[0];
            const errorMessage = errorDetail
                ? `${errorDetail.issue} ${errorDetail.description} (${orderData.debug_id})`
                : JSON.stringify(orderData);

            throw new Error(errorMessage);
        } catch (error) {
            console.error(error);
            // resultMessage(`Could not initiate PayPal Checkout...<br><br>${error}`);
        }
    },
   async onApprove(data, actions) {
        try {
            const response = await fetch(
                `/api/orders/${data.orderID}/capture`,
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );

            const orderData = await response.json();
            // Three cases to handle:
            //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
            //   (2) Other non-recoverable errors -> Show a failure message
            //   (3) Successful transaction -> Show confirmation or thank you message

            const errorDetail = orderData?.details?.[0];

            if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                // recoverable state, per
                // https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
                return actions.restart();
            } else if (errorDetail) {
                // (2) Other non-recoverable errors -> Show a failure message
                throw new Error(
                    `${errorDetail.description} (${orderData.debug_id})`
                );
            } else if (!orderData.purchase_units) {
                throw new Error(JSON.stringify(orderData));
            } else {
                // (3) Successful transaction -> Show confirmation or thank you message
                // Or go to another URL:  actions.redirect('thank_you.html');
                const transaction =
                    orderData?.purchase_units?.[0]?.payments?.captures?.[0] ||
                    orderData?.purchase_units?.[0]?.payments
                        ?.authorizations?.[0];
                resultMessage(
                    `Transaction ${transaction.status}: ${transaction.id}<br>
          <br>See console for all available details`
                );
                console.log(
                    "Capture result",
                    orderData,
                    JSON.stringify(orderData, null, 2)
                );
            }
        } catch (error) {
            console.error(error);
            resultMessage(
                `Sorry, your transaction could not be processed...<br><br>${error}`
            );
        }
    },

   
});
paypalButtons.render("#paypal-button-container");


// Example function to show a result to the user. Your site's UI library can be used instead.
function resultMessage(message) {
    const container = document.querySelector("#result-message");
    container.innerHTML = message;
}
</script>

<?php include('layouts/footer.php') ?>