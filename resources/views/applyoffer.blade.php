@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($offres as $offre)
                <div class="panel panel-default">
                    <div class="panel-heading">Appliquer sur l'offre : {{$offre->title}}</div>

                    <div class="panel-body">
                        Description : {{$offre->message}} <br><br>
                        <form class="form-horizontal" role="form" method="POST" action="{{ action('MyoffersController@applyonoffer') }}">
                        {{ csrf_field() }}
                            <div class="form-group">
                                <label for="montant" class="col-md-1 control-label">Montant</label>

                                <div class="col-md-6">
                                    <input id="montant" type="number" step="0.01" class="form-control" name="montant" required>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="sedeplace" value="0">
                                    <input id="sedeplace" type="checkbox" value="1" name="sedeplace"> I move
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="fournitpiece" value="0">
                                    <input type="checkbox" value="1" name="fournitpiece"> I fournit part
                                </label>
                            </div>
                            <div id="addressDiv" class="form-group">
                                <label for="address" class="col-md-1 control-label">Address</label>

                                <div class="col-md-6">
                                    <input id="pac-input" type="text" class="form-control test" name="address">
                                </div>
                                <div id="map"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <input id="name" type="hidden" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <input id="offre_id" type="hidden" class="form-control" name="offre_id" value="{{$offre->id}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Apply</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#sedeplace').change(function () {
            if (this.checked) {
                $('#addressDiv').fadeOut('slow');
                $('.test').val("");  
            }
            else 
                $('#addressDiv').fadeIn('slow');
        });
    });
</script>
    <script>

      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);


        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcvRHv5pRhvL-3AiVlNKxTSHY0nMZwzzQ&libraries=places&callback=initAutocomplete"
         async defer></script>
@endsection
