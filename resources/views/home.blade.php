@extends('layouts.app')
@section('content')
@if (Auth::user()->mecano && Auth::user()->approuved)
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($offres as $offre)
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $offre->title }} <i class="fa fa-exclamation pull-right" style="color:red;"></i></div>

                        <div class="panel-body">
                            Car : {{ $offre->car }} <br>
                            Message : {{ $offre->message }} <br>
                            @if($offreapplications->count())
                                @foreach($offreapplications as $offreapplication)
                                    @if ($offreapplication->offre_id == $offre->id)
                                        @if (!$offreapplication->accepted)
                                            <form role="form" method="delete" action="{{ action('MyoffersController@deleteofferapplication') }}">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="{{ $offre->id }}">
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="idapplication" value="{{ $offreapplication->id }}">
                                                </div>
                                                <button type="submit" class="btn btn-danger">Delete my offer</button>
                                            </form>
                                        @elseif($offreapplication->accepted && $offreapplication->name == Auth::user()->name)
                                            <br><button id="seeacceptedoffer" name="seeacceptedoffer" type="button" class="btn btn-success accepted">Your offer as been accepted! See details</button>

                                            <div id="offeracceptedDiv" style="display: none;" class="offeracceptedDiv">
                                                <br>
                                                Montant : {{ $offreapplication->montant }} $ <br>
                                                Move : 
                                                @if($offreapplication->sedeplace)
                                                     Yes 
                                                @else
                                                     No 
                                                @endif <br>
                                                Address to do the work : {{ $offreapplication->address }}<br>
                                                Fournit parts : @if($offreapplication->fournitpiece) Yes @else No @endif<br>
                                            </div>
                                        @else
                                            <h3><span class="label label-danger">Sorry this offer is over</span></h3>
                                        @endif
                                        @break
                                    @else
                                        @if($loop->last)
                                            <form role="form" method="POST" action="{{ url('/applyoffer') }}">
                                                <div class="form-group">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $offre->id }}">
                                                </div>
                                                <button type="submit" class="btn btn-success">Apply on this offer</button>
                                            </form>
                                        @endif
                                    @endif
                                @endforeach
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
                @endforeach
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
          $(".accepted").click(function(e){
            e.preventDefault();
            if ($('.offeracceptedDiv').is(':visible'))
                $('.offeracceptedDiv').fadeOut('slow');
            else 
                $('.offeracceptedDiv').fadeIn('slow');
          });
        });
    </script>
@else
    Good try buddy
@endif
@endsection
