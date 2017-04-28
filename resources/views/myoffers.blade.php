@extends('layouts.app')

@section('content')
@if (!Auth::user()->mecano)
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            <button type="button" class="btn btn-success" onclick="window.location='{{ url("/addoffer") }}'">Add new offer</button> <br><br>
            @foreach($offres as $offre)
                @if(!$offre->completed)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $offre->title }}

                        </div>
                        <div class="panel-body">
                            <?php
                                // Delimiters may be slash, dot, or hyphen
                                $datehour = $offre->wanteddate;
                                list($date, $hour) = explode('T', $datehour);
                                $hour = substr($hour,0,2).':'.substr($hour,2,2);
                                echo "<b>Date : </b>$date <br /> <b>Time : </b>$hour <br />\n";
                            ?>
                            <b>Car : </b>{{ $offre->car }} <br>
                            <b>Message : </b>{{ $offre->message }} <br>
                            <b>Offers count : </b>
                                <?php $pos=0 ?>
                                <?php $acceptedofferapplication=null ?>
                                @foreach($offreapplications as $offreapplication)
                                    @if ($offreapplication->offre_id == $offre->id)
                                        <?php $pos = $pos + 1 ?>
                                            @if ($offreapplication->accepted)
                                                <?php $acceptedofferapplication = $offreapplication ?>
                                            @endif
                                    @endif
                                @endforeach
                                <?php print $pos ?>
                            @if(!$acceptedofferapplication)
                                @if (count($offreapplications))
                                    <form role="form" method="POST" action="{{ url('/viewofferapplication') }}">
                                        <div class="form-group">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="id" value="{{ $offre->id }}">
                                        </div>
                                        <button type="submit" class="btn btn-success">See offers</button>
                                    </form>
                                @endif
                                <form role="form" method="delete" action="{{ url('/deleteoffer') }}">
                                    {{ method_field('DELETE') }}
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="{{ $offre->id }}">
                                    </div>
                                    <button type="submit" class="btn btn-danger pull-right">Delete</button>
                                </form>
                            @else
                                @if($acceptedofferapplication->completed)
                                    <br><br><button id="seeacceptedoffer" name="seeacceptedoffer" type="button" class="btn btn-danger accepted">Completed, Please pay your bill</button>
                                @else
                                    <br><br><button id="seeacceptedoffer" name="seeacceptedoffer" type="button" class="btn btn-success accepted">You already accepted an offer. See accepted offers</button>
                                @endif

                                <div id="offeracceptedDiv" style="display: none;" class="offeracceptedDiv">
                                    <br>
                                    <b>Mechanic Name : </b><a href="{!! route('seemecanoprofil', ['name'=>$offreapplication->user_id]) !!}" class="btn btn-default">{{ App\User::find($offreapplication->user_id)->name }}</a><br>
                                    <b>Montant : </b>{{ number_format($acceptedofferapplication->montant, 2) }} $ <br>
                                    <b>Move : </b>
                                    @if($acceptedofferapplication->sedeplace)
                                         Yes 
                                    @else
                                         No
                                    @endif <br>
                                    <b>Address : </b>{{ $acceptedofferapplication->address }} <br>
                                    <b>Fournit parts : </b>
                                    @if($acceptedofferapplication->fournitpiece)
                                         Yes 
                                    @else
                                         No
                                    @endif<br>
                                    @if($acceptedofferapplication->completed)
                                        <form role="form" method="POST" action="{{ route('pay',$acceptedofferapplication->id) }}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <div class="stars">
                                                    <input class="star star-5 {{ $acceptedofferapplication->id }}" id="star-5{{ $acceptedofferapplication->id }}" type="radio" value="5" name="star"/>
                                                    <label class="star star-5 {{ $acceptedofferapplication->id }}" for="star-5{{ $acceptedofferapplication->id }}"></label>
                                                    <input class="star star-4 {{ $acceptedofferapplication->id }}" id="star-4{{ $acceptedofferapplication->id }}" type="radio" value="4" name="star"/>
                                                    <label class="star star-4 {{ $acceptedofferapplication->id }}" for="star-4{{ $acceptedofferapplication->id }}"></label>
                                                    <input class="star star-3 {{ $acceptedofferapplication->id }}" id="star-3{{ $acceptedofferapplication->id }}" type="radio" value="3" name="star"/>
                                                    <label class="star star-3 {{ $acceptedofferapplication->id }}" for="star-3{{ $acceptedofferapplication->id }}"></label>
                                                    <input class="star star-2 {{ $acceptedofferapplication->id }}" id="star-2{{ $acceptedofferapplication->id }}" type="radio" value="2" name="star"/>
                                                    <label class="star star-2 {{ $acceptedofferapplication->id }}" for="star-2{{ $acceptedofferapplication->id }}"></label>
                                                    <input class="star star-1 {{ $acceptedofferapplication->id }}" id="star-1{{ $acceptedofferapplication->id }}" type="radio" value="1" name="star"/>
                                                    <label class="star star-1 {{ $acceptedofferapplication->id }}" for="star-1{{ $acceptedofferapplication->id }}"></label>
                                                </div>
                                                <input id="{{ $acceptedofferapplication->id }}" class="rating" type="hidden" value="0" name="rating"> <br>
                                                Comment : <input type="text" name="comment" required><br><br>
                                                <input type="hidden" name="user_id" value="{{ $offreapplication->user_id }}">
                                                <input type="hidden" name="offreid" value="{{ $offre->id }}">
                                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                data-key="pk_test_kJGCpNwM6w61Su1koNNv1Jf9"
                                                data-amount="{{ preg_replace('|[^0-9]|i', '', number_format($acceptedofferapplication->montant, 2)) }}"
                                                data-name="RoadMecs"
                                                data-email="{{Auth::user()->email}}"
                                                data-description="{{$offre->title}}"
                                                data-currency="cad"
                                                data-locale="auto">
                                            </script>
                                        </form>

                                    @else
                                        <br><b>This offer as not been completed yet</b>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

      $(".accepted").click(function(e){
        e.preventDefault();
        var acceptedIndex = $('.accepted').index(this);
        $('.offeracceptedDiv').each(function(index, elm) {
            if(acceptedIndex == index) {
                if ($(elm).is(':visible'))
                    $(elm).fadeOut('slow');
                else 
                    $(elm).fadeIn('slow');
            }
        });
      });
    });
    $(document).ready(function(){
        $('.star').click(function(e){
            var userRating = this.value;
            var starClassName = this.className;
            $('.rating').each(function(index, elm) {
                if(starClassName.includes(this.id)) {
                    this.value = userRating;
                }
            });
        }); 
    });
</script>
@else
    You can't acces this section
@endif
@endsection