@extends('layouts.app')
@section('content')
@if (Auth::user()->mecano && Auth::user()->approuved)
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(count($offres))
                @foreach($offres as $offre)
                @if(!$offre->completed)
                    <?php $offerCanBeDeleted = false ?>
                    <?php $offerAsBeenAcceptedForHim = false ?>
                    <?php $offerAsBeenAcceptedNotForHim = false ?>
                    <?php $offerCanBeApply = false ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $offre->title }} @if($offre->created_at > \Carbon\Carbon::now()->subDays(1))<i class="fa fa-exclamation pull-right" style="color:red;"></i>@endif</div>

                        <div class="panel-body">
                            Car : {{ $offre->car }} <br>
                            Message : {{ $offre->message }} <br>
                            City : {{ $offre->city }} <br>
                            @if($offreapplications->count())
                                @foreach($offreapplications as $offreapplication)
                                    @if ($offreapplication->offre_id == $offre->id)
                                        @if (!$offreapplication->accepted)
                                            @if($offreapplication->name === Auth::user()->name)
                                                <?php $offerCanBeDeleted = true ?>
                                                <?php $deletedoffer = $offreapplication ?>
                                            @endif
                                        @endif
                                        @if ($offreapplication->accepted)
                                            @if($offreapplication->name === Auth::user()->name)
                                                <?php $offerAsBeenAcceptedForHim = true ?>
                                                <?php $acceptedoffer = $offreapplication ?>
                                            @endif
                                        @endif 
                                        @if ($offreapplication->accepted)
                                            @if($offreapplication->name != Auth::user()->name)
                                                <?php $offerAsBeenAcceptedNotForHim = true ?>
                                            @endif
                                        @endif
                                        @if(!$offreapplication->accepted)
                                            @if($offreapplication->name != Auth::user()->name)
                                                <?php $offerCanBeApply = true ?>
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                                @if(!$offerAsBeenAcceptedNotForHim)
                                    @if(!$offerAsBeenAcceptedForHim)
                                        @if(!$offerCanBeDeleted)
                                            <form role="form" method="POST" action="{{ url('/applyoffer') }}">
                                                <div class="form-group">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $offre->id }}">
                                                </div>
                                                <button type="submit" class="btn btn-success">Apply on this offer</button>
                                            </form>
                                        @else
                                        <form role="form" method="delete" action="{{ action('MyoffersController@deleteofferapplication') }}">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="{{ $offre->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="idapplication" value="{{ $deletedoffer->id }}">
                                                </div>
                                                <button type="submit" class="btn btn-danger">Delete my offer</button>
                                            </form>
                                        @endif
                                    @else
                                        <br><button id="seeacceptedoffer" name="seeacceptedoffer" type="button" class="btn btn-success accepted">Your offer as been accepted! See details</button>

                                                <div id="offeracceptedDiv" style="display: none;" class="offeracceptedDiv">
                                                    <br>
                                                    Montant : {{ $acceptedoffer->montant }} $ <br>
                                                    Move : 
                                                    @if($acceptedoffer->sedeplace)
                                                         Yes 
                                                    @else
                                                         No 
                                                    @endif <br>
                                                    Address to do the work : {{ $acceptedoffer->address }}<br>
                                                    Fournit parts : @if($acceptedoffer->fournitpiece) Yes @else No @endif<br>
                                                    @if(!$acceptedoffer->completed)
                                                        <form role="form" method="POST" action="{{ url('/completedofferapplication') }}">
                                                            <div class="form-group">
                                                                {{ csrf_field() }}
                                                                <input type="hidden" name="id" value="{{ $acceptedoffer->id }}">
                                                            </div>
                                                            <button type="submit" class="btn btn-success">Completed</button>
                                                        </form>
                                                    @else
                                                        <br>
                                                        <div class="alert alert-warning">This offer as been completed but not paid yet. Please make sure that your customer pay is bill.</div>
                                                    @endif
                                                </div>
                                    @endif
                                @else
                                    <h3><span class="label label-danger">This offer as been given to an other mechanic</span></h3>
                                @endif
                            @else
                                <form role="form" method="POST" action="{{ url('/applyoffer') }}">
                                    <div class="form-group">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $offre->id }}">
                                    </div>
                                    <button type="submit" class="btn btn-success">Apply on this offer</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
                @endforeach
                @else
                There's no offer in your area at the moment please try again later
                @endif
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
    </script>
@else
    Good try buddy
@endif
@endsection
