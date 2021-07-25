<!-- Add the PayPal JavaScript SDK with both buttons and marks components -->
<script src="https://www.paypal.com/sdk/js?client-id=Ac9pq-kHeWuGvVAo2AYj26xJpIjetDLjfkVK0xebRl18lQpCrteZIjPE27k1KsrUQYGMcLyzUx0IPIhH&components=buttons,marks"></script>

<!-- Render the radio buttons and marks -->
<label>
  <input type="radio" name="payment-option" value="paypal" checked>
  <img src="paypal-mark.jpg" alt="Pay with PayPal">
</label>

<label>
  <input type="radio" name="payment-option" value="alternate">
  <div id="paypal-marks-container"></div>
</label>

<div id="paypal-buttons-container"></div>
<div id="alternate-button-container">
  <button>Pay with a different method</button>
</div>

<script>
  // Render the PayPal marks
  paypal.Marks().render('#paypal-marks-container');

  // Render the PayPal buttons
  paypal.Buttons().render('#paypal-buttons-container');

  // Listen for changes to the radio buttons
  document.querySelectorAll('input[name=payment-option]')
    .forEach(function (el) {
      el.addEventListener('change', function (event) {

        // If PayPal is selected, show the PayPal button
        if (event.target.value === 'paypal') {
          document.body.querySelector('#alternate-button-container')
            .style.display = 'none';
          document.body.querySelector('#paypal-button-container')
            .style.display = 'block';
        }

        // If alternate funding is selected, show a different button
        if (event.target.value === 'alternate') {
          document.body.querySelector('#alternate-button-container')
            .style.display = 'block';
          document.body.querySelector('#paypal-button-container')
            .style.display = 'none';
        }
      });
    });

  // Hide non-PayPal button by default
  document.body.querySelector('#alternate-button-container')
    .style.display = 'none';
</script>