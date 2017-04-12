@extends('layouts.app')

@section('content')
@if (!Auth::user()->mecano)
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add offer</div>
                <div class="panel-body">
                    <form id="myForm" class="form-horizontal" role="form" method="POST" action="{{ action('MyoffersController@create') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="car" class="col-md-4 control-label">Car</label>

                            <div class="col-md-6">
                                <input id="car" type="text" class="form-control" name="car" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-md-4 control-label">Message</label>

                            <div class="col-md-6">
                                <textarea id="message" rows="4" cols="50" name="message" form="myForm"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wanteddate" class="col-md-4 control-label">Date and time</label>

                            <div class="col-md-6">
                                <input id="wanteddate" type="datetime-local" class="form-control" name="wanteddate"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="username" type="hidden" class="form-control" name="username" value="{{ Auth::user()->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="city" type="hidden" class="form-control" name="city" value="{{ Auth::user()->ville }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="country" type="hidden" class="form-control" name="country" value="{{ Auth::user()->pays }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add Offer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var today = new Date().toISOString();
    today = today.substring(0, today.length - 8);
    document.getElementById("wanteddate").value = today
    document.getElementsByName("wanteddate")[0].setAttribute('min', today);
</script>
@else
You can't acces this section
@endif
@endsection
