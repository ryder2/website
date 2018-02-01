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
                                <select name="car_years" class="form-control" id="car_years" form="myForm" required></select>  
                                <select name="car_makes" class="form-control" id="car_makes" form="myForm" required></select> 
                                <select name="car_models" class="form-control" id="car_models" form="myForm" required></select>
                                <select name="car_model_trims" class="form-control" id="car_model_trims" form="myForm" required></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="car_model_trims_txt" type="hidden" class="form-control" name="car_model_trims_txt">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="car_makes_txt" type="hidden" class="form-control" name="car_makes_txt">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Type of job</label>
                            <div class="col-md-6">
                                <select class="form-control" name="title" id="title">
                                    @foreach($jobtypes as $jobtype)
                                    <option value="{{$jobtype->job}}">{{$jobtype->job}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-md-4 control-label">Message</label>
                            <div class="col-md-6 textwrapper">
                                <textarea id="message" class="form-control" rows="4" cols="5" name="message" form="myForm" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="wanteddate" class="col-md-4 control-label">Date and time</label>
                            <div class="col-md-6">
                                <input id="wanteddate" type="datetime-local" class="form-control" name="wanteddate" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="username" type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="city" type="hidden" class="form-control" name="city" value="{{ Auth::user()->ville }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="province" type="hidden" class="form-control" name="province" value="{{ Auth::user()->province }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="country" type="hidden" class="form-control" name="country" value="{{ Auth::user()->pays }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div style="text-align: right;margin: 0px 20px 0px 0px">
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
<script type="text/javascript">
    $(document).ready(
        function () {
            var carquery = new CarQuery();
            carquery.init();
            carquery.initYearMakeModelTrim('car_years', 'car_makes', 'car_models', 'car_model_trims');
        });
    $("#myForm").submit(function () {
        $("[name=car_model_trims_txt]").val($("[name=car_model_trims]").find("option:selected").text());
        $("[name=car_makes_txt]").val($("[name=car_makes]").find("option:selected").text());
    });
</script>
<script type="text/javascript">
    $('.btn-primary').click(function(e){
        var trim = $("[name=car_model_trims]").find("option:selected").text();
        var make = $("[name=car_makes]").find("option:selected").text();
        var model = $("[name=car_models]").find("option:selected").text();
        var year = $("[name=car_years]").find("option:selected").text();

        var title = $("#title").find("option:selected").text();
        var message = $("#message").val();

        var messageLength = message.length;
        var maxLength = 50;
        var nbOfBrToEnter = parseInt(messageLength/maxLength);

        var index;

        if(nbOfBrToEnter > 0) {
            for (index = 0; index < nbOfBrToEnter; index++) {
                message = message.substring(0, maxLength) + "<br>" + message.substring(maxLength, message.length);
                maxLength = maxLength + 54;
            }
        }
        
        
        var res = $("#wanteddate").val().split("T");
        var date = res[0];
        var time= res[1];

        var form = this.closest("form");
        e.preventDefault();
        bootbox.confirm({
            backdrop: false,
            title: "Are you sure?",
            message: "<b>Do you want to add this offer?</b> <br><br>" +
                    "<b>Car : </b>" + year + " " + model + " " + make + " " + trim + "<br>" +
                    "<b>Job type : </b>" + title + "<br>" +
                    "<b>Message : </b>" + message + "<br>" +
                    "<b>Date : </b>" + date + "<br>" +
                    "<b>Time : </b>" + time,
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Add Offer',
                    className: "btn btn-primary",
                }
            },
            callback: function (result) {
                if(result) {
                    bootbox.dialog({ closeButton: false, message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>' })
                    $(form).submit();
                }
            }
        });
    });
</script>
@else
<center><b>You can't acces this section as a mechanic</b></center>
@endif
@endsection