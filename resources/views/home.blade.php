@extends('layouts.app')
@section('content')
@if (Auth::user()->mecano && Auth::user()->approuved)
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="large-6 columns">
				<label for="filter">Filter by</label>
				<select id="filter" class="form-control">
					<option value="City">City</option>
					<option value="Province">Province</option>
					<option value="Country">Country</option>
				</select><br>
				<meta name="csrf-token" content="{{ csrf_token() }}"></div>
				<div id="search-results">
					@if(count($offres))
					@foreach($offres as $offre)
					@if(!$offre->completed)
					<?php $offerCanBeDeleted = false ?>
					<?php $offerAsBeenAcceptedForHim = false ?>
					<?php $offerAsBeenAcceptedNotForHim = false ?>
					<?php $offerCanBeApply = false ?>
					<div class="panel panel-default">
						<div class="panel-heading">{{ $offre->title }} @if($offre->created_at > \Carbon\Carbon::now()->subDays(1))<i class="fa fa-exclamation pull-right" style="color:red;"></i>@endif</div>

						<div class="panel-body">
							<?php
								// Delimiters may be slash, dot, or hyphen
							$datehour = $offre->wanteddate;
							list($date, $hour) = explode('T', $datehour);
							$hour = substr($hour,0,2).':'.substr($hour,2,2);
							echo "<b>Date : </b>$date <br /> <b>Time : </b>$hour <br />\n";
							?>
							<b>Car : </b>{{ $offre->car }} <br>
							<b>Message : </b>{{ $offre->message }} <br>
							<b>City : </b>{{ $offre->city }} <br>
							<b>Province : </b>{{ $offre->province }} <br>
							<b>Country : </b>{{ $offre->country }}
						</div>
						@if(sizeof($offreapplications) > 0)
						@foreach($offreapplications as $offreapplication)
						@if ($offreapplication->offre_id == $offre->id)
						@if (!$offreapplication->accepted)
						@if($offreapplication->user_id == Auth::user()->id)
						<?php $offerCanBeDeleted = true ?>
						<?php $deletedoffer = $offreapplication ?>
						@endif
						@endif
						@if ($offreapplication->accepted)
						@if($offreapplication->user_id == Auth::user()->id)
						<?php $offerAsBeenAcceptedForHim = true ?>
						<?php $acceptedoffer = $offreapplication ?>
						@endif
						@endif 
						@if ($offreapplication->accepted)
						@if($offreapplication->user_id != Auth::user()->id)
						<?php $offerAsBeenAcceptedNotForHim = true ?>
						@endif
						@endif
						@if(!$offreapplication->accepted)
						@if($offreapplication->user_id != Auth::user()->id)
						<?php $offerCanBeApply = true ?>
						@endif
						@endif
						@endif
						@endforeach
						@if(!$offerAsBeenAcceptedNotForHim)
						@if(!$offerAsBeenAcceptedForHim)
						@if(!$offerCanBeDeleted)
						<form role="form" method="POST" action="{!! url('/applyoffer', ['id'=>$offre->id]) !!}">
							<div class="form-group">
								{{ csrf_field() }}
								<input type="hidden" name="id" value="{{ $offre->id }}">
							</div>
							<div class="panel-body">
								<button type="submit" class="btn btn-success">Apply on this offer</button>
							</div>
						</form>
						@else
						<form role="form" method="delete" action="{{ action('MyoffersController@deleteofferapplication') }}">
							<br>
							<div class="panel-footer">My offer details</div>
							<div class="panel-body">
								<b>Montant : </b>{{ $deletedoffer->montant }} $ <br>
								<b>Move : </b>
								@if($deletedoffer->sedeplace)
								Yes 
								@else
								No 
								@endif <br>
								@if($deletedoffer->address)
								<b>Address to do the work : </b>{{ $deletedoffer->address }}<br>
								@endif
								<b>Fournit parts : </b>@if($deletedoffer->fournitpiece) Yes @else No @endif<br>
								
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<div class="form-group">
									<input type="hidden" name="id" value="{{ $offre->id }}">
								</div>
								<div class="form-group">
									<input type="hidden" name="idapplication" value="{{ $deletedoffer->id }}">
								</div>
								<button type="submit" class="btn btn-danger">Delete my offer</button></div>
							</form>
							@endif
							@else
							<div class="panel-body">
								<button id="seeacceptedoffer" name="seeacceptedoffer" type="button" class="btn btn-success accepted">Your offer as been accepted! See details</button>
							</div>
							<div id="offeracceptedDiv" style="display: none;" class="offeracceptedDiv">
								<br>
								<div class="panel-body">
									<b>Montant : </b>{{ $acceptedoffer->montant }} $ <br>
									<b>Move : </b>
									@if($acceptedoffer->sedeplace)
									Yes 
									@else
									No 
									@endif <br>
									<b>Address to do the work : </b>{{ $acceptedoffer->address }}<br>
									<b>Fournit parts : </b>@if($acceptedoffer->fournitpiece) Yes @else No @endif<br>
									@if(!$acceptedoffer->completed)
									<form role="form" method="POST" action="{{ url('/completedofferapplication') }}">
										<div class="form-group">
											{{ csrf_field() }}
											<input type="hidden" name="id" value="{{ $acceptedoffer->id }}">
										</div>
										<button type="submit" class="btn btn-success">Completed</button>
									</form>
									@else
									<br>
									<div class="alert alert-warning">This offer as been completed but not paid yet. Please make sure that your customer pay is bill.</div>
									@endif
								</div>
							</div>
							@endif
							@else
							<div class="panel-body">
								<h3><span class="label label-danger">This offer as been given to an other mechanic</span></h3>
							</div>
							@endif
							@else
							<div class="panel-body">
								<form role="form" method="POST" action="{{ url('/applyoffer') }}">
									<div class="form-group">
										{{ csrf_field() }}
										<input type="hidden" name="id" value="{{ $offre->id }}">
									</div>
									<button type="submit" class="btn btn-success">Apply on this offer</button>
								</form>
							</div>
							@endif
						</div>
						@endif
						@endforeach
						@else
						There's no offer in your area at the moment please try again later
						@endif
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){

			  $(".accepted").click(function(e){
				e.preventDefault();
				var acceptedIndex = $('.accepted').index(this);
				$('.offeracceptedDiv').each(function(index, elm) {
					if(acceptedIndex == index) {
						if ($(elm).is(':visible'))
							$(elm).fadeOut('slow');
						else 
							$(elm).fadeIn('slow');
					}
				});
			});
		  });
	  </script>
	  <script type="text/javascript">
		$('#filter').on('change', function () {
			searchup(this.value);
		})
		var timer;

		function searchup(keywords) {

			timer = setTimeout(function () {
				var data = {
					'keywords': keywords,
					'_token': $('meta[name="csrf-token"]').attr('content')
				};
				$.post('/executeFilter', data, function (markup) {
					$('#search-results').html(markup);
				});
			}, 100);
		}
   </script>
   <script type="text/javascript">
   $('.btn-danger').click(function (e) {
		var form = this.closest("form");
		e.preventDefault();
		bootbox.confirm({
			backdrop: false,
			title: "Are you sure?",
			message: "Do you want to delete this offer? This cannot be undone.",
			buttons: {
				cancel: {
					label: '<i class="fa fa-times"></i> Cancel'
				},
				confirm: {
					label: '<i class="fa fa-check"></i> Delete',
					className: "btn btn-danger",
				}
			},
			callback: function (result) {
				if (result) {
					bootbox.dialog({ closeButton: false, message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>' })
					$(form).submit();
				}
			}
		});
	});
    
	</script>
   @else
   @if (Auth::user()->mecano && !Auth::user()->approuved)
   <div class="col-md-8 col-md-offset-2">
	<div class="alert alert-warning"><center><b>Please, make sure to set up your bank account infos and a mechanic evidence to get approuved and see the offers</b></center></div>
</div>
@else
<div class="col-md-8 col-md-offset-2">
	<div class="alert alert-warning"><center><b>You have to be a mechanic to see this section.</b></center></div>
</div>

@endif
@endif
@endsection
