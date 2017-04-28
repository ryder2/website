@extends('layouts.app')

@section('content')
@if (Auth::user()->role_id == 1)
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <div class="large-6 columns">
            <input type="text" id="search-input" class="form-control" onkeyup="searchup()" onkeydown="searchdown()" placeholder="Search By Name"><br>
            <meta name="csrf-token" content="{{ csrf_token() }}"></div>
            <div id="search-results">
                <script>
                    var mecano = [];
                    var approuved = [];
                    var admin = [];
                </script>
                @foreach($users as $user)
                <div class="panel panel-default">
                        <div class="panel-heading">{{$user->name}}</div>
                        <form role="form" method="POST" class="formtest" action="{{ url('/adminpanel') }}">
                        <div class="panel-body">
                            Mecano : {{$user->mecano}} <br>
                            Approuved : {{$user->approuved}} <br>
                            Admin : {{$user->role_id}}
                            <br><br>
                            
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <select class="selectpicker disable-example" name="selectpicker[]" multiple data-selected-text-format="count > 3">
                                      <option value="Mecano">Mecano</option>
                                      <option value="Approuved" disabled>Approuved</option>
                                      <option value="Admin">Admin</option>
                                    </select>
                                </div>
                                <input type="hidden" name="userid" value="{{ $user->id }}">
                                <br><button type="submit" class="btn btn-success">Save Changes</button>
                            </form> 
                        </div>
                        <script>
                            mecano.push("<?php echo $user->mecano; ?>");
                            approuved.push("<?php echo $user->approuved; ?>");
                            admin.push("<?php echo $user->role_id; ?>");
                        </script>
                    
                </div>
                @endforeach
            </div>              
            </div>
        </div>
    </div>
    <script>

        $('.disable-example').each(function(index){
            if(mecano[index] == 1) {
                $(this).find('[value=Mecano]').prop('selected', true);
                $(this).find('[value=Approuved]').prop('disabled', false);
                
            } 
            if(approuved[index] == 1) {
                $(this).find('[value=Approuved]').prop('disabled', false);
                $(this).find('[value=Approuved]').prop('selected', true); 
            }
            if(admin[index] == 1) {
                $(this).find('[value=Admin]').prop('selected', true);
                
            } 
            
            $(this).selectpicker('refresh');
        });
        $(function() {
            $('.disable-example').on('change', function(){
                if($(this).find("option:selected").val() == 'Mecano') {
                    $(this).find('[value=Approuved]').prop('disabled', false);
                } else {
                    $(this).find('[value=Approuved]').prop('selected', false);
                    $(this).find('[value=Approuved]').prop('disabled', true);
                }
                $(this).selectpicker('refresh');
            });
        });

        var timer;
        function searchup() {

         timer = setTimeout(function()
         {
            var keywords = $('#search-input').val();
                var data = {
                    'keywords': keywords,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                };
                $.post('/executeSearch', data, function(markup)
                {
                    $('#search-results').html(markup);
                });
         }, 100);
        }

function searchdown()
{
    clearTimeout(timer);
}
    </script>
@endif
@endsection
