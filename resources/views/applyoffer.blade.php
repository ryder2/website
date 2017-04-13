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
                                    <input id="address" type="text" class="form-control" name="address">
                                </div>
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
            if (this.checked) 
               $('#addressDiv').fadeOut('slow');
            else 
                $('#addressDiv').fadeIn('slow');
        });
    });
</script>
@endsection
