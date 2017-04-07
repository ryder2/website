@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>

                <div class="panel-body">
                    Name : {{ Auth::user()->name }} <br>
                    Email : {{ Auth::user()->email }} <br>
                    Address : {{ Auth::user()->rue }}, {{ Auth::user()->codepostal }}, {{ Auth::user()->ville }}, {{ Auth::user()->province }}, {{ Auth::user()->pays }} <br>
                    Mechanic : 

                    @if (Auth::user()->mecano == 1)
                        Yes <br>
                        Approuved : 
                        @if (Auth::user()->approuved == 1)
                            Yes <br>
                        @else
                            No <br>
                        @endif

                        CPA Card : Empty for now
                    @else 
                        No 
                    @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">About me</div>

                <div class="panel-body">
                    {{ Auth::user()->apropos }}
                </div>
            </div>
            @if (Auth::user()->mecano == 1)
                <div class="panel panel-default">
                    <div class="panel-heading">Experience</div>

                    <div class="panel-body">
                        {{ Auth::user()->experience }}
                    </div>
                </div>
            @endif
                <button type="button" class="btn btn-primary" onclick="window.location='{{ url('/editprofile') }}'">Edit my profile</button>
        </div>
    </div>
</div>
@endsection