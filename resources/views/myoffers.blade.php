@extends('layouts.app')

@section('content')
@if (!Auth::user()->mecano)
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <button type="button" class="btn btn-success" onclick="window.location='{{ url("/addoffer") }}'">Add new offer</button> <br><br>
            @foreach($offres as $offre)
                @if(!$offre->completed)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $offre->title }}

                        </div>
                        <div class="panel-body">
                            Car : {{ $offre->car }} <br>
                            Message : {{ $offre->message }} <br>
                            Offers count : 
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
                                <br><br><button id="seeacceptedoffer" name="seeacceptedoffer" type="button" class="btn btn-success accepted">You already accepted an offer. See accepted offers</button>

                                <div id="offeracceptedDiv" style="display: none;" class="offeracceptedDiv">
                                    <br>Date : {{ $offre->wanteddate }}<br>
                                    Mechanic Name : {{ $acceptedofferapplication->name }}<br>
                                    Montant : {{ $acceptedofferapplication->montant }} $ <br>
                                    Move : 
                                    @if($acceptedofferapplication->sedeplace)
                                         Yes 
                                    @else
                                         No
                                    @endif <br>
                                    Address : {{ $acceptedofferapplication->address }} <br>
                                    Fournit parts : 
                                    @if($acceptedofferapplication->fournitpiece)
                                         Yes 
                                    @else
                                         No
                                    @endif<br>
                                    @if($acceptedofferapplication->completed)
                                        <form role="form" method="POST" action="{{ route('pay',$acceptedofferapplication->id) }}">
                                            <div class="form-group">
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
                                                Comment : <input type="text" name="comment" required>
                                                <input type="hidden" name="mecanoName" value="{{ $acceptedofferapplication->name }}">
                                                <input type="hidden" name="offreid" value="{{ $offre->id }}">
                                            </div>
                                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                data-key="pk_test_kJGCpNwM6w61Su1koNNv1Jf9"
                                                data-amount="{{ $acceptedofferapplication->montant }}"
                                                data-name="Stripe.com"
                                                data-description="Widget"
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