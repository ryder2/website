@extends('layouts.app')

@section('content')
@if (!Auth::user()->mecano)
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <button type="button" class="btn btn-success" onclick="window.location='{{ url("/addoffer") }}'">Add new offer</button> <br><br>
            @foreach($offres as $offre)
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
                                Fournit parts : @if($acceptedofferapplication->fournitpiece) Yes @else No @endif<br>
                            </div>

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
You can't acces this section
@endif
@endsection