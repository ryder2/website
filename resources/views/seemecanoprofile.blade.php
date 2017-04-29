@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Informations</div>
                <div class="panel-body">
                    <center><img id="profileimage" src="{{ $mecano->avatar ? '/' . $mecano->avatar : '/storage/users/profile/default.png'}}" width="150 " height="200"> <br><br>
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

                        Rating : 
                        @for ($i=1; $i <= 5 ; $i++)
                        <span class="glyphicon glyphicon-star{{ ($i <= $mecano->rating_cache) ? '' : '-empty'}}"></span>
                        @endfor
                        {{ $mecano->rating_cache }} / 5 ({{ $mecano->rating_count }} reviews)
                        @else 
                        No 
                        @endif
                    </center>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">About me</div>

                <div class="panel-body">
                    <?php echo(nl2br($mecano->apropos)) ?>
                </div>
            </div>
            @if ($mecano->mecano == 1)
            <div class="panel panel-default">
                <div class="panel-heading">Experience</div>

                <div class="panel-body">
                    <?php echo(nl2br($mecano->experience)) ?>
                </div>
            </div>
            @endif
        </div>
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
                <center>{{ $reviews->links() }}</center>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection