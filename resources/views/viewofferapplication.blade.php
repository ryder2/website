@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($offreapplications))
            @foreach($offreapplications as $offreapplication)
            <div class="panel panel-default">
                <div class="panel-heading">Montant : {{ number_format($offreapplication->montant, 2, '.', '') }} $</div>
                <div class="panel-body">
                    <b>Mechanic : </b><a href="{!! route('seemecanoprofil', ['name'=>$offreapplication->user_id]) !!}" class="btn-link">{{ App\User::find($offreapplication->user_id)->name }}</a><br>
                    <b>Move : </b>
                    @if($offreapplication->sedeplace)
                    Yes 
                    @else
                    No <br><b> Address : </b>{{ $offreapplication->address }} 
                    @endif <br>
                    <b>Fournit parts : </b>@if($offreapplication->fournitpiece) Yes @else No @endif<br>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/acceptofferapplication') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" value="{{ $offreapplication->id }}">
                        </div>
                        @if (!$offreapplication->address)
                        <div class="form-group">
                            <label for="address" class="col-md-1 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="pac-input" value="{{ old('address') }}" type="text" class="form-control" name="address" required>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-0">
                                <button type="submit" class="btn btn-success" onclick=>Accept this offer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @endforeach
            @else
            <div class="alert alert-warning"><center><b>There's no mechanic application on your offer at the moment, please try again later.</b></center></div>

            @endif
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.btn').click(function(e){
        var form = this.closest("form");
        e.preventDefault();
        bootbox.confirm({
            backdrop: false,
            title: "Are you sure?",
            message: "Do you want to accept this offer? This cannot be undone.",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function (result) {
                if(result)
                    $(form).submit();
            }
        });
    });
    
</script>
@endsection
