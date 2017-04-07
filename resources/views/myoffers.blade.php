@extends('layouts.app')

@section('content')
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
                        Message : {{ $offre->message }}
                        <form role="form" method="delete" action="{{ url('/deleteoffer') }}">
                            {{ method_field('DELETE') }}
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{ $offre->id }}">
                            </div>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection