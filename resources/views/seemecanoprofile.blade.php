@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>

                <div class="panel-body">
                    Name : {{ $mecano->name }} <br>
                    Mechanic : 

                    @if ($mecano->mecano == 1)
                        Yes <br>
                        Approuved : 
                        @if ($mecano->approuved == 1)
                            Yes <br>
                        @else
                            No <br>
                        @endif

                        Stars : 0
                    @else 
                        No 
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">About me</div>

                <div class="panel-body">
                    {{ $mecano->apropos }}
                </div>
            </div>
            @if ($mecano->mecano == 1)
                <div class="panel panel-default">
                    <div class="panel-heading">Experience</div>

                    <div class="panel-body">
                        {{ $mecano->experience }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection