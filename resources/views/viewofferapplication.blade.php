@extends('layouts.app')
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
    </style>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($offreapplications))
            @foreach($offreapplications as $offreapplication)
                <div class="panel panel-default">
                    <div class="panel-heading">Montant : {{ number_format($offreapplication->montant, 2, '.', '') }} $</div>
                    <div class="panel-body">
                        Mechanic : <a href="{!! route('seemecanoprofil', ['name'=>$offreapplication->name]) !!}" class="btn btn-default">{{ $offreapplication->name }}</a><br>
                        Move : 
                        @if($offreapplication->sedeplace)
                             Yes 
                        @else
                             No <br> Address : {{ $offreapplication->address }} 
                        @endif <br>
                        Fournit parts : @if($offreapplication->fournitpiece) Yes @else No @endif<br>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/acceptofferapplication') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{ $offreapplication->id }}">
                            </div>
                            @if (!$offreapplication->address)
                                <div class="form-group">
                                    <label for="address" class="col-md-1 control-label">Address</label>

                                    <div class="col-md-6">
                                        <input id="pac-input" type="text" class="form-control" name="address" required>
                                    </div>
                                </div>
                                <div id="map"></div> <br>
                            @endif
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-0">
                                    <button type="submit" class="btn btn-success">Accept this offer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
            @else
                There's no mechanic application on your offer at the moment, please try again later.
            @endif
        </div>
    </div>
</div>
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
