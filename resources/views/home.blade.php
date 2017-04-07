@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @foreach($offres as $offre)
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $offre->title }} <i class="fa fa-exclamation pull-right" style="color:red;"></i></div>

                    <div class="panel-body">
                        Car : {{ $offre->car }} <br>
                        Message : {{ $offre->message }} <br>
                        @foreach($offreapplications as $offreapplication)
                            @if ($offreapplication->offre_id == $offre->id)
                                <form role="form" method="POST" action="{{ url('/applyoffer') }}">
                                    <div class="form-group">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $offre->id }}">
                                    </div>
                                    <button type="submit" class="btn btn-danger">Delete my offer</button>
                                </form>
                            @break
                            @else
                                <form role="form" method="POST" action="{{ url('/applyoffer') }}">
                                    <div class="form-group">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{ $offre->id }}">
                                    </div>
                                    <button type="submit" class="btn btn-success">Apply on this offer</button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
