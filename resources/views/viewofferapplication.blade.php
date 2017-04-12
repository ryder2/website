@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($offreapplications as $offreapplication)
                <div class="panel panel-default">
                    <div class="panel-heading">Montant : {{ $offreapplication->montant }} $</div>
                    <div class="panel-body">
                        Mechanic : {{ $offreapplication->name }}<br>
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
                                        <input id="address" type="text" class="form-control" name="address">
                                    </div>
                                </div>
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
        </div>
    </div>
</div>
@endsection
