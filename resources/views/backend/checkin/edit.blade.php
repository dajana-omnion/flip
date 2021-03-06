@extends('layouts.main')
@push('css')
<link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
@endpush
@section('content')
<div class="box" id="checkin">
	<div class="box-header">
		<h3 class="box-title">Room number: <b>{{$kamar->nomor_kamar}}</b></h3>
	</div>
	<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="tambahCheckin">
		<div class="box-body">
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label># INVOICE</label>
						<input class="form-control" name="invoice_id" value="{{$nomor_invoice}}" v-model="dataInput.invoice_id" readonly>
					</div>
					<div class="alert alert-info">
						<h4>Standard</h4>
						<ul class="list-unstyled">
							<li>Price / night : <b>{{$kamar->typekamar->harga_malam_format}}</b></li>
							<li>Maximum number of adults : <b>{{$kamar->max_dewasa}} adults</b></li>
							<li>Maximum number of children : <b>{{$kamar->max_anak}} children</b></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Guest name</label>
						<select class="form-control nama_tamu" name="tamu_id" v-model="dataInput.tamu_id">
							<option selected="selected" value="0">--Choose--</option>
							@foreach($tamu as $key => $guest)
							<option value="{{$key}}">{{$guest}}</option>
							@endforeach
						</select>
						<span v-if="errorForm['tamu_id']" class="error text-danger">@{{ errorForm['tamu_id'] }}</span>
					</div>
					<div class="well">
						<a href="{{route('tamu.index')}}"><b>Click here</b></a> if the guest name is not found to be added to the guestbook list.
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label>Number of guests</label>
						<div class="row">
							<div class="col-sm-6">
								<select class="form-control" name="jumlah_dewasa" v-model="dataInput.jumlah_dewasa">
									<option value="0">- Adults -</option>
									@for($i= 1;$i <= $kamar->max_dewasa;$i++)
									<option value="{{$i}}">{{$i}} people</option>
									@endfor
								</select>
								<span v-if="errorForm['jumlah_dewasa']" class="error text-danger">@{{ errorForm['jumlah_dewasa'] }}</span>
							</div>
							<div class="col-sm-6">
								<select class="form-control" name="jumlah_anak" v-model="dataInput.jumlah_anak">
									<option value="0">- Children -</option>
									@for($i= 1;$i <= $kamar->max_anak;$i++)
									<option value="{{$i}}">{{$i}} children</option>
									@endfor
								</select>
								<span v-if="errorForm['jumlah_anak']" class="error text-danger">@{{ errorForm['jumlah_anak'] }}</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Date / Time of check-In</label>
						<div class="row">
							<div class="col-sm-6">
								<input class="form-control" name="tgl_checkin" value="{{date('Y-m-d')}}" readonly="" v-model="dataInput.tgl_checkin">
							</div>
							<div class="col-sm-6">
								<input class="form-control" name="waktu_checkin" value="{{date('h:i')}}" readonly="" v-model="dataInput.waktu_checkin">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Date / Time of check-out</label>
						<div class="row">
							<div class="col-sm-6">
								<input id="checkout" class="form-control" name="tgl_checkout" data-date-format="yyyy-mm-dd" v-model="dataInput.tgl_checkout" readonly>
							</div>
							<div class="col-sm-6">
								<input class="form-control" name="waktu_checkout" value="12:00" readonly v-model="dataInput.waktu_checkout">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Deposit amount (EUR)</label>
						<input type="number" class="form-control" name="deposit" v-model="dataInput.deposit">
						<span v-if="errorForm['deposit']" class="error text-danger">@{{ errorForm['deposit'] }}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="box-footer">
			<input type="hidden" name="kamar_id" v-model="dataInput.kamar_id">
			<button class="btn btn-success" type="submit" name="checkin">Check In</button>
			<a class="btn btn-warning" href="{{route('checkin.index')}}">Cancel</a>
		</div>
	</form>
</div>
@endsection
@push('script')
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script>
    var transaksi = new Vue({
    	el : '#checkin',
    	data : {
    		dataInput : {
    			'invoice_id' : '{{$nomor_invoice}}',
    			'tamu_id' : 0,
    			'kamar_id' : '{{$kamar->id}}',
    			'jumlah_dewasa' : 0,
    			'jumlah_anak' : 0,
    			'tgl_checkin' : '{{date("Y-m-d")}}',
    			'waktu_checkin' : '{{date("H:i")}}',
    			'tgl_checkout' : '{{date("Y-m-d",strtotime("+1 day"))}}',
    			'waktu_checkout' : '12:00',
    			'deposit' : 0
    		},
    		errorForm:{},
    	},

    	methods: {
    		tambahCheckin:function(){
		      var input = this.dataInput;
		      axios.post(base_url+'/admin/checkin',input).then(response=>{
		      	if(response.data)
		      		window.location.href = '{{route("checkin.index")}}';
		      }).catch(errors=>{
		        if(errors.response){
		          if(errors.response.status = 422){
		            this.errorForm = errors.response.data;
		          }
		        } else {
		          console.error(errors);
		        }
		      })
		    },
    	}
    });
   	$('#checkout').datepicker({
      autoclose: true,
      startDate: '{{date("Y-m-d",strtotime("+1 day"))}}',
      enableOnReadonly: true,
    }).on('hide',function(e){
    	transaksi.$data.dataInput.tgl_checkout = $("#checkout").val();
    });
</script>
@endpush