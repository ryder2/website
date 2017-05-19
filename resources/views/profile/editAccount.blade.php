@extends('layouts.app')
@section('content')
@if (Auth::user()->mecano == 1)
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      <script>
        // Set your Stripe publishable API key here
        Stripe.setPublishableKey('pk_test_kJGCpNwM6w61Su1koNNv1Jf9');
        $(function () {
          var $form = $('#payment-form');
          $form.submit(function (event) {
            // Clear any errors
            $form.find('.has-error').removeClass('has-error');
            // Disable the submit button to prevent repeated clicks:
            $form.find('.submit').prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> Modifying account");
            // Request a token from Stripe:
            Stripe.bankAccount.createToken($form, stripeResponseHandler);

            // Prevent the form from being submitted:
            return false;
          });
          // Switch or hide 'routing number' depending on currency
          $('#currency').change(function () {
            $('#routing_number_div').show();
            $('#ssn_div').hide();
            $('#ssn_number').removeAttr('data-stripe');
            $('#account_number_label').text('Account Number').next('input').attr('placeholder', '');
            $('#routing_number').attr('data-stripe', 'routing_number');
            switch (this.value) {
              case "usd":
                $('#ssn_div').show();
                $('#ssn_number').attr('data-stripe', 'ssn_last_4');
                $('#routing_number_label').text('Routing Number').next('input').attr('placeholder', '111000000');
                break;
              case "eur":
                // No routing number needed
                $('#routing_number_div').hide();
                $('#routing_number').removeAttr('data-stripe');
                $('#account_number_label').text('IBAN').next('input').attr('placeholder', 'XX9828737432389');
                break;
              case "cad":
                $('#routing_number_label').text('Transit & Institution Number');
                break;
              case "gbp":
                $('#routing_number_label').text('Sort Code').next('input').attr('placeholder', '12-34-56');
                break;
              case "mxn":
                $('#routing_number_label').text('CLABE');
                break;
              case 'aud':
              case "nzd":
                $('#routing_number_label').text('BSB').next('input').attr('placeholder', '123456');
                break;
              case 'sgd':
              case "jpy":
              case "brl":
              case "hkd":
                $('#routing_number_label').text('Bank / Branch Code');
                break;
            }
          });

          $('#account_holder_type').change(function () {
            switch (this.value) {
              case "individual":
                $('#company_div').hide();
                $('#business_tax_id').removeAttr('data-stripe');
                $('#business_name').removeAttr('data-stripe');
                break;
              case "company":
                // No routing number needed
                $('#company_div').show();
                $('#business_tax_id').attr('data-stripe', 'business_tax_id');
                $('#business_name').attr('data-stripe', 'business_name');
                break;
            }
          });
        });

        function stripeResponseHandler(status, response) {
          var $form = $('#payment-form');
          if (response.error) {
            // Show the errors on the form
            $form.find('.errors').text(response.error.message).addClass('alert alert-danger');
            $form.find('.' + response.error.param).parent('.form-group').addClass('has-error');
            $form.find('button').prop('disabled', false).text('Add bank account'); // Re-enable submission
          } else { // Token was created!
            $form.find('.submit').html("<i class='fa fa-check'></i> Account Modified");

            // Get the token ID:
            var token = response.id;
            // Insert the token and name into the form so it gets submitted to the server:
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            // Submit the form:
            $form.get(0).action = "{{ url('/bankaccountmodify') }}";
            $form.get(0).submit();
          }
        }
      </script>
      <div class="panel panel-default">
        <div class="panel-heading"> Modify bank account
        </div>
        <div class="panel-body">
          <form action="" method="POST" enctype="multipart/form-data" id="payment-form">
            {{ csrf_field() }}
            <div class="errors"></div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Country</label>
                  <select class="form-control" id="country" name="country" data-stripe="country">
                    <option value="US">United States</option>
                    <option value="AU">Australia</option>
                    <option value="AT">Austria</option>
                    <option value="BE">Belgium</option>
                    <option value="BR">Brazil</option>
                    <option value="CA">Canada</option>
                    <option value="DK">Denmark</option>
                    <option value="FI">Finland</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                    <option value="HK">Hong Kong</option>
                    <option value="IE">Ireland</option>
                    <option value="IT">Italy</option>
                    <option value="JP">Japan</option>
                    <option value="LU">Luxembourg</option>
                    <option value="MX">Mexico</option>
                    <option value="NZ">New Zealand</option>
                    <option value="NL">Netherlands</option>
                    <option value="NO">Norway</option>
                    <option value="PT">Portugal</option>
                    <option value="SG">Singapore</option>
                    <option value="ES">Spain</option>
                    <option value="SE">Sweden</option>
                    <option value="CH">Switzerland</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Currency</label>
                  <select class="form-control" id="currency" name="currency" data-stripe="currency">
                    <option value="usd">USD</option>
                    <option value="aud">AUD</option>
                    <option value="brl">BRL</option>
                    <option value="cad">CAD</option>
                    <option value="eur">EUR</option>
                    <option value="gbp">GBP</option>
                    <option value="hkd">HKD</option>
                    <option value="jpy">JPY</option>
                    <option value="mxn">MXN</option>
                    <option value="nzd">NZD</option>
                    <option value="sgd">SGD</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Full Legal Name</label>
                  <input class="form-control account_holder_name" name="account_holder_name" id="account_holder_name" type="text" data-stripe="account_holder_name" placeholder="Jane Doe" autocomplete="off">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Account Type</label>
                  <select class="form-control account_holder_type" name="account_holder_type" id="account_holder_type" data-stripe="account_holder_type">
                    <option value="individual">Individual</option>
                    <option value="company">Company</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row" id="company_div" style="display: none;">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Business Name</label>
                  <input class="form-control business" name="business_name" id="business_name" type="text" placeholder="RoadMecs" autocomplete="off">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Business Tax Id</label>
                  <input class="form-control business" name="business_tax_id" id="business_tax_id" type="tel" placeholder="123456" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" id="routing_number_div">
                <div class="form-group">
                  <label id="routing_number_label">Routing Number</label>
                  <input class="form-control bank_account" name="routing_number" id="routing_number" type="tel" data-stripe="routing_number" placeholder="111000025" autocomplete="off">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label id="account_number_label">Account Number</label>
                  <input class="form-control bank_account" name="account_number" id="account_number" type="tel"  data-stripe="account_number" placeholder="000123456789" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6" id="ssn_div">
                <div class="form-group">
                  <label id="ssn_label">SSN last 4</label>
                  <input class="form-control bank_account" name="ssn_number" id="ssn_number" type="tel" data-stripe="ssn_last_4" placeholder="1234" autocomplete="off">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label id="personal_id_number_label">Personal id number</label>
                  <input class="form-control bank_account" name="idnumber" id="idnumber" type="text" placeholder="G1234 " autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="idimg" class="col-md-4 control-label">Personnal Id Image</label>
              <div class="col-md-6">
                <img id="id_image" width="200 " height="100"><br><br>
                <input id="idimg" type="file" name="idimg" accept="image/*" onchange="preview_id_image(event)">
                <br><br>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <p class="submit-note">
                <center>
                  <b>
                  By registering your account, you agree to our <a target="_blank" class="btn-link" href="{{ url('/termsandconditions') }}">Services Agreement</a> and the <a target="_blank" class="btn-link" href="https://stripe.com/connect-account/legal">Stripe Connected Account Agreement.</a>
                  </b>
                </center>
                </p>
                <button class="btn btn-block btn-primary submit" type="submit">Modify bank account informations</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function preview_id_image(event) {
    var reader = new FileReader();
    reader.onload = function () {
      var output = document.getElementById('id_image');
      output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endif
@endsection