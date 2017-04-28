@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>

                <div class="panel-body">
                <center><img id="profileimage" src="{{ Auth::user()->avatar ? Auth::user()->avatar : 'storage/users/profile/default.png'}}" width="150 " height="200"> <br><br>
                    Name : {{ Auth::user()->name }} <br>
                    Email : {{ Auth::user()->email }} <br>
                    Address : {{ Auth::user()->street_number }}, {{ Auth::user()->rue }}, {{ Auth::user()->codepostal }}, {{ Auth::user()->ville }}, {{ Auth::user()->province }}, {{ Auth::user()->pays }} <br>
                    Mechanic : 

                    @if (Auth::user()->mecano == 1)
                        Yes <br>
                        Approuved : 
                        @if (Auth::user()->approuved == 1)
                            Yes <br>
                        @else
                            No <br>
                        @endif
                        Mechanic Card : 
                        @if(Auth::user()->cartemecano)
                            <br>
                            <img src="{{ Auth::user()->cartemecano }}" alt="CPA Card" style="width:200px;height:200px;">
                        @else
                            <b>Please make sure to upload your card to get approuved</b>
                        @endif
                    @else 
                        No 
                    @endif
                    @if (Auth::user()->mecano == 1)
                    <br><br>Rating :  @for ($i=1; $i <= 5 ; $i++)
                              <span class="glyphicon glyphicon-star{{ ($i <= Auth::user()->rating_cache) ? '' : '-empty'}}"></span>
                            @endfor
                            {{ Auth::user()->rating_cache }} / 5 ({{ Auth::user()->rating_count }} reviews)
                            <br>
                    @endif
                </center></div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">About me</div>

                <div class="panel-body">
                    <?php echo(nl2br(Auth::user()->apropos)) ?>
                </div>
            </div>
            @if (Auth::user()->mecano == 1)
                <div class="panel panel-default">
                    <div class="panel-heading">Experience</div>

                    <div class="panel-body">
                        <?php echo(nl2br(Auth::user()->experience)) ?>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-md-8 col-md-offset-2">
              <button type="button" class="btn btn-primary" onclick="window.location='{{ url('/editprofile') }}'">Edit my profile</button><br><br>
            </div>
        @if (Auth::user()->mecano == 1)
            @if(!Auth::user()->stripe_id)
              <!-- Bootstrap Stripe.js bank account form starts here -->

              <!-- Stripe.js to collect payment details -->
              <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
              <script>
                // Set your Stripe publishable API key here
                Stripe.setPublishableKey('pk_test_kJGCpNwM6w61Su1koNNv1Jf9');
                $(function() {
                  var $form = $('#payment-form');
                  $form.submit(function(event) {
                    // Clear any errors
                    $form.find('.has-error').removeClass('has-error');
                    // Disable the submit button to prevent repeated clicks:
                    $form.find('.submit').prop('disabled', true).html("<i class='fa fa-spinner fa-spin'></i> Creating account");
                    // Request a token from Stripe:
                    Stripe.bankAccount.createToken($form, stripeResponseHandler);
                    
                    // Prevent the form from being submitted:
                    return false;
                  });
                  // Switch or hide 'routing number' depending on currency
                  $('#currency').change(function(){
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
                        $('#account_number_label').text('IBAN').next('input').attr('placeholder','XX9828737432389');
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
                      case 'aud': case "nzd":
                        $('#routing_number_label').text('BSB').next('input').attr('placeholder', '123456');
                        break;
                      case 'sgd': case "jpy": case "brl": case "hkd":
                        $('#routing_number_label').text('Bank / Branch Code');
                        break;
                    }
                  });

                  $('#account_holder_type').change(function(){
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
                  } 
                  else { // Token was created!
                    $form.find('.submit').html("<i class='fa fa-check'></i> Account added");
                    
                    // Get the token ID:
                    var token = response.id;
                    // Insert the token and name into the form so it gets submitted to the server:
                    $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                    // Submit the form:
                    $form.get(0).action = "{{ url('/bankaccountsetup') }}";
                    $form.get(0).submit();
                  }
                }
              </script>
                <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                    <div class="panel-heading"> Add a bank account
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
                                    <label for="profileimg" class="col-md-4 control-label">Personnal Id Image</label>

                                    <div class="col-md-6">
                                        <input id="idimg" type="file" class="form-control" name="idimg" accept="image/*" onchange="preview_image(event)">
                                        <img id="output_image" width="200 " height="100"><br><br>
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
                            <button class="btn btn-block btn-primary submit" type="submit">Add bank account</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <script type="text/javascript">
                    function preview_image(event) 
                    {
                     var reader = new FileReader();
                     reader.onload = function()
                     {
                      var output = document.getElementById('output_image');
                      output.src = reader.result;
                     }
                     reader.readAsDataURL(event.target.files[0]);
                    }
                </script>
                @else
                <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                    <div class="panel-heading"> My account informations
                    </div>
                    <div class="panel-body">
                    		<div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Charge Enabled :&nbsp</label>
                              <label><b>@if($account->charges_enabled)True @else False @endif</b></label>
                            </div>
                          </div>
                         </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Country :&nbsp</label>
                              <label><b>{{strtoupper($account->external_accounts->data[0]->country)}}</b></label>
                            </div>
                          </div>
                         </div>
                         <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Currency :&nbsp</label>
                              <label><b>{{strtoupper($account->external_accounts->data[0]->currency)}}</b></label>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Full Legal Name :&nbsp</label>
                              <label><b>{{strtoupper($account->external_accounts->data[0]->account_holder_name)}}</b></label>
                            </div>
                          </div>
                         </div>
                         <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Account Type :&nbsp</label>
                              <label><b>{{strtoupper($account->external_accounts->data[0]->account_holder_type)}}</b></label>
                            </div>
                          </div>
                        </div>
                        @if($account->external_accounts->data[0]->account_holder_type != "individual")
                        <div class="row" id="company_div">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Business Name :&nbsp</label>
                              <label><b>{{strtoupper($account->external_accounts->data[0]->account_holder_name)}}</b></label>
                            </div>
                          </div>
                         </div>
                         <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Business Tax Id :&nbsp</label>
                              <label><b>{{strtoupper($account->external_accounts->data[0]->account_holder_name)}}</b></label>
                            </div>
                          </div>
                        </div>
                        @endif
                        <div class="row">
                          <div class="col-md-6" id="routing_number_div">
                            <div class="form-group">
                              <label id="routing_number_label">Routing Number :&nbsp</label>
                              <label><b>{{$account->external_accounts->data[0]->routing_number}}</b></label>
                            </div>
                          </div>
                         </div>
                         <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label id="account_number_label">Account Number :&nbsp</label>
                              <label><b>*******{{$account->external_accounts->data[0]->last4}}</b></label>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12"">
                            <div class="form-group">
                              <label>Bank Name :&nbsp</label>
                              <label><b>{{$account->external_accounts->data[0]->bank_name}}</b></label>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
            @endif
            
        @if(count($reviews))
        <div class="col-md-8 col-md-offset-2">
        <br>
            <div class="panel panel-default">
                <div class="panel-heading">Reviews</div>
                <div class="panel-body">
                    @foreach($reviews as $review)
                        @for ($i=1; $i <= 5 ; $i++)
                          <span class="glyphicon glyphicon-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
                        @endfor

                        {{ $review->user ? $review->user->name : 'Anonymous'}} <span class="pull-right">{{$review->timeago}}</span> 

                        <p>{{{$review->comment}}}</p>
                    @endforeach
                </div>
                <center>{{ $reviews->links() }}</center>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection