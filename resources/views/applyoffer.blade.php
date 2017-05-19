@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			@if (session('warning'))
			<div class="alert alert-warning">
				{{ session('warning') }}
			</div>
			@endif
			<div class="panel panel-default">
				<div class="panel-heading">{{$offre->title}}</div>
				<div class="panel-body">
					<form id="form" class="form-horizontal" role="form" method="POST" action="{{ action('MyoffersController@applyonoffer') }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label for="montant" class="col-md-1 control-label">Amount</label>
							<div class="col-md-6">
								<input id="montant" type="number" min="5.00" max="1500.00" step="0.01" class="form-control amount" name="montant" required>
							</div>
						</div>
						<div class="form-group">
							<label for="transactionfees" class="col-md-1 control-label">Fees</label>
							<div class="col-md-6">
								<label id="transactionfees" type="label" class="form-control" name="transactionfees" data-html="true" data-placement="top" data-toggle="tooltip" title="<ul id='fees'>
									<li>Stripe Fees : </li>
									<li>RoadMecs Fees : </li>
									</ul>"> </label>
								<input id="transactionfeesbox" type="hidden" class="form-control" name="transactionfeesbox">
							</div>
						</div>
						<div class="form-group">
							<label for="total" class="col-md-1 control-label">Total</label>
							<div class="col-md-6">
								<label id="total" type="label" class="form-control" name="total" required> </label>
								<input id="totalbox" type="hidden" class="form-control" name="totalbox">
							</div>
						</div>
						<div class="checkbox">
							<label>
							<input type="hidden" name="sedeplace" value="0">
							<input id="sedeplace" type="checkbox" value="1" name="sedeplace"> I move
							</label>
						</div>
						<div class="checkbox">
							<label>
							<input type="hidden" name="fournitpiece" value="0">
							<input type="checkbox" value="1" name="fournitpiece"> I fournit part
							</label>
						</div>
						<br>
						<div id="addressDiv" class="form-group">
							<label for="address" class="col-md-1 control-label">Address</label>
							<div class="col-md-6">
								<input id="pac-input" type="text" class="form-control test" name="address" required><br>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<input id="name" type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6">
								<input id="offre_id" type="hidden" class="form-control" name="offre_id" value="{{$offre->id}}">
							</div>
						</div>
						<button type="submit" class="btn btn-success">Apply</button>
					</form>
				</div>
				<div class="panel-footer"> Details
				</div>
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
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});
	});
	$(document).ready(function () {
		$('#sedeplace').change(function () {
			if (this.checked) {
				$('#addressDiv').fadeOut('slow');
				$('.test').val("");
				$('#pac-input').removeAttr('required');
			}
			else {
				$('#addressDiv').fadeIn('slow');
				$('#pac-input').attr('required', true);
			}
			
		});
	});
	$(document).ready(function () {
		$('#montant').change(function () {
			if(($(this).val()) > 500) {
				$('#transactionfeesbox').val( (0.30 + ($(this).val() * 0.029) + 50).toFixed(2) );
				$('#transactionfees').html ( $('#transactionfeesbox').val() );
			} else {
				$('#transactionfeesbox').val( (0.30 + ($(this).val() * 0.129) ).toFixed(2) );
				$('#transactionfees').html ( $('#transactionfeesbox').val() );
			}
	
			$('#totalbox').val( (Number($(this).val()) - Number($('#transactionfeesbox').val())).toFixed(2) );
			$('#total').html ( $('#totalbox').val() );
		});
	});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	$('#transactionfees').on('shown.bs.tooltip', function () {
		if(($('#montant').val()) > 500) {
			$('#fees').html('<li>Stripe Fees : ' + (0.30 + ($('#montant').val() * 0.029)).toFixed(2) + '$' + '</li>' + '<li>RoadMecs Fees : ' + (50).toFixed(2) + '$' + '</li>');
		} else {
			$('#fees').html('<li>Stripe Fees : ' + (0.30 + ($('#montant').val() * 0.029)).toFixed(2) + '$' + '</li>' + '<li>RoadMecs Fees : ' +  ($('#montant').val() * 0.1).toFixed(2) + '$' + '</li>');
		}
	});
</script>
@endsection