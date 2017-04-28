@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label for="dob" class="col-md-4 control-label">Date of birth</label>
                            <div class="col-md-6" name="dob">
                                <select class="form-control" name="dobday" id="dobday" required></select>
                                <select class="form-control" name="dobmonth" id="dobmonth" required></select>
                                <select class="form-control" name="dobyear" id="dobyear" required></select>
                            </div>
                        </div>

                        <div id="locationField" class="form-group">
                            <label for="autocomplete" class="col-md-4 control-label">Address</label>
                            <div class="col-md-6">
                                <input id="autocomplete" name="autocomplete" class="form-control" placeholder="Enter your address"
                                 onFocus="geolocate()" type="text"></input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('street_number') ? ' has-error' : '' }}">
                            <label for="street_number" class="col-md-4 control-label">Street Number</label>

                            <div class="col-md-6">
                                <input id="street_number" type="text" class="form-control" name="street_number" value="{{ old('street_number') }}" readonly required>

                                @if ($errors->has('street_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('street_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('rue') ? ' has-error' : '' }}">
                            <label for="rue" class="col-md-4 control-label">Street Name</label>

                            <div class="col-md-6">
                                <input id="route" type="text" class="form-control" name="rue" value="{{ old('rue') }}" readonly required>

                                @if ($errors->has('rue'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rue') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('codepostal') ? ' has-error' : '' }}">
                            <label for="codepostal" class="col-md-4 control-label">Postal Code</label>

                            <div class="col-md-6">
                                <input id="postal_code" type="text" class="form-control" name="codepostal" value="{{ old('codepostal') }}" readonly required>

                                @if ($errors->has('codepostal'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codepostal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ville') ? ' has-error' : '' }}">
                            <label for="ville" class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <input id="locality" type="text" class="form-control" name="ville" value="{{ old('ville') }}" readonly required>

                                @if ($errors->has('ville'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ville') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                            <label for="province" class="col-md-4 control-label">Province</label>

                            <div class="col-md-6">
                                <input id="administrative_area_level_1" type="text" class="form-control" name="province" value="{{ old('province') }}" readonly required>

                                @if ($errors->has('province'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('pays') ? ' has-error' : '' }}">
                            <label for="pays" class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <input id="country" type="text" class="form-control" name="pays" value="{{ old('pays') }}" readonly required>

                                @if ($errors->has('pays'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pays') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="hidden" name="mecano" value="0">
                                        <input class="mecano" type="checkbox" value="1" name="mecano" {{ old('mecano') ? 'checked' : '' }}> I want to register as a mechanic
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('TermsAndConditions') ? ' has-error' : '' }}">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input class="TermsAndConditions" type="checkbox" name="TermsAndConditions" required {{ old('TermsAndConditions') ? 'checked' : '' }}> I agree with the <a href="/termsandconditions">terms and conditions</a>
                                        @if ($errors->has('TermsAndConditions'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('TermsAndConditions') }}</strong>
                                            </span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ asset('js/dobPicker.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $.dobPicker({
        // Selectopr IDs
        daySelector: '#dobday',
        monthSelector: '#dobmonth',
        yearSelector: '#dobyear',

        // Default option values
        dayDefault: 'Day',
        monthDefault: 'Month',
        yearDefault: 'Year',

        // Minimum age
        minimumAge: 12,

        // Maximum age
        maximumAge: 99
      });
    });
</script>

    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        for (var component in componentForm) {
          document.getElementById(component).value = '';
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcvRHv5pRhvL-3AiVlNKxTSHY0nMZwzzQ&libraries=places&callback=initAutocomplete&language=en&region=US"
        async defer></script>
@endsection
