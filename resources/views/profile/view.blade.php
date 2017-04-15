@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>

                <div class="panel-body">
                <center><img id="profileimage" src="{{ Auth::user()->avatar ? Auth::user()->avatar : 'storage/users/profile/default.png'}}" width="150 " height="200"> <br><br>
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
                        CPA Card : 
                        @if(Auth::user()->cartemecano)
                            <br>
                            <img src="{{ Auth::user()->cartemecano }}" alt="CPA Card" style="width:200px;height:200px;">
                        @else
                            <b>Please make sure to upload your card to get approuved</b>
                        @endif
                    @else 
                        No 
                    @endif
                    @if (Auth::user()->mecano == 1)
                    <br><br>Rating :  @for ($i=1; $i <= 5 ; $i++)
                              <span class="glyphicon glyphicon-star{{ ($i <= Auth::user()->rating_cache) ? '' : '-empty'}}"></span>
                            @endfor
                            {{ Auth::user()->rating_cache }} / 5 ({{ Auth::user()->rating_count }} reviews)
                            <br>
                    @endif
                </center></div>
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
        @if (Auth::user()->mecano == 1)
        @if(count($reviews))
        <div class="col-md-8 col-md-offset-2">
        <br>
            <div class="panel panel-default">
                <div class="panel-heading">Reviews</div>
                <div class="panel-body">
                    @foreach($reviews as $review)
                        @for ($i=1; $i <= 5 ; $i++)
                          <span class="glyphicon glyphicon-star{{ ($i <= $review->rating) ? '' : '-empty'}}"></span>
                        @endfor

                        {{ $review->user ? $review->user->name : 'Anonymous'}} <span class="pull-right">{{$review->timeago}}</span> 

                        <p>{{{$review->comment}}}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection