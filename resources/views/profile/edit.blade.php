@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="{{ url('/saveprofile') }}">
                <div class="panel panel-default">
                    <div class="panel-heading">Informations</div>

                    <div class="panel-body">
                        
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="profileimg" class="col-md-4 control-label">Profile Image</label>

                            <div class="col-md-6">
                                <img id="profile_image" src="{{ Auth::user()->avatar ? Auth::user()->avatar : 'storage/users/profile/default.png'}}" width="150 " height="200">
                                <input id="profileimg" type="file" class="form-control" name="profileimg" accept="image/*" onchange="preview_profile_image(event)">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('rue') ? ' has-error' : '' }}">
                            <label for="rue" class="col-md-4 control-label">Street</label>

                            <div class="col-md-6">
                                <input id="rue" type="text" class="form-control" name="rue" value="{{ Auth::user()->rue }}" required>

                                @if ($errors->has('rue'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rue') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('codepostal') ? ' has-error' : '' }}">
                            <label for="codepostal" class="col-md-4 control-label">Postal Code</label>

                            <div class="col-md-6">
                                <input id="codepostal" type="text" class="form-control" name="codepostal" value="{{ Auth::user()->codepostal }}" required>

                                @if ($errors->has('codepostal'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('codepostal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ville') ? ' has-error' : '' }}">
                            <label for="ville" class="col-md-4 control-label">City</label>

                            <div class="col-md-6">
                                <input id="ville" type="text" class="form-control" name="ville" value="{{ Auth::user()->ville }}" required>

                                @if ($errors->has('ville'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ville') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                            <label for="province" class="col-md-4 control-label">Province</label>

                            <div class="col-md-6">
                                <input id="province" type="text" class="form-control" name="province" value="{{ Auth::user()->province }}" required>

                                @if ($errors->has('province'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('province') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('pays') ? ' has-error' : '' }}">
                            <label for="pays" class="col-md-4 control-label">Country</label>

                            <div class="col-md-6">
                                <input id="pays" type="text" class="form-control" name="pays" value="{{ Auth::user()->pays }}" required>

                                @if ($errors->has('pays'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pays') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @if (Auth::user()->mecano == 1)
                            <div class="form-group">
                                <label for="cartemecano" class="col-md-4 control-label">Mechanic card</label>

                                <div class="col-md-6">
                                 <input id="cartemecano" type="file" class="form-control" name="cartemecano" accept="image/*" onchange="preview_image(event)">
                                    <img id="output_image" src="{{ Auth::user()->cartemecano ? Auth::user()->cartemecano : ''}}" width="200 " height="100">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">About me</div>

                    <div class="panel-body">
                        
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6">
                                <input id="apropos" type="text" class="form-control" name="apropos" value="{{ Auth::user()->apropos }}" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                 @if (Auth::user()->mecano == 1)
                    <div class="panel panel-default">
                        <div class="panel-heading">Experience</div>

                            <div class="panel-body">
                                {{ csrf_field() }}

                            <div class="form-group">
                                <div class="col-md-6">
                                    <input id="experience" type="text" class="form-control" name="experience" value="{{ Auth::user()->experience }}">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">
                                        Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type='text/javascript'>
        function preview_image(event) 
        {
         var reader = new FileReader();
         reader.onload = function()
         {
          var output = document.getElementById('output_image');
          output.src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
        }
        function preview_profile_image(event) 
        {
         var reader = new FileReader();
         reader.onload = function()
         {
          var output = document.getElementById('profile_image');
          output.src = reader.result;
         }
         reader.readAsDataURL(event.target.files[0]);
        }
</script>
@endsection