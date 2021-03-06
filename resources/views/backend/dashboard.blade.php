@extends('layouts.main')
@section('content')
	<div class="row">
		<div class="col-sm-3">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3>{{$kamar_tersedia}}</h3>
					<p>Rooms total</p>
				</div>
				<div class="icon">
					<i class="fa fa-bed"></i>
				</div>
				<a class="small-box-footer" href="{{route('checkin.index')}}">View more</a>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="small-box bg-red">
				<div class="inner">
					<h3>{{$kamar_terpakai}}</h3>
					<p>Rooms occupied</p>
				</div>
				<div class="icon">
					<i class="fa fa-bed"></i>
				</div>
				<a class="small-box-footer" href="{{route('checkin.checkout')}}">View more</a>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="small-box bg-green">
				<div class="inner">
					<h3>{{$rooms_available}}</h3>
					<p>Rooms available</p>
				</div>
				<div class="icon">
					<i class="fa fa-bed"></i>
				</div>
				<a class="small-box-footer" href="{{route('checkin.index')}}">View more</a>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>{{$kamar_kotor}}</h3>
					<p>Dirty rooms</p>
				</div>
				<div class="icon">
					<i class="fa fa-bed"></i>
				</div>
				<a class="small-box-footer" href="{{route('transaksilayanan.create')}}">View more</a>
			</div>
		</div>
	</div>
	<div class="row" id="dashboard">
		<div class="col-md-6">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Guests</h3>
				</div>
				<div class="box-body">
					<table class="table table-sriped">
						<thead>
							<tr>
								<th>Name</th>
								<th># Room</th>
								<th>Date / Time of the Check-In</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tamu as $guest)
							<tr>
								<td>{{$guest->tamu->nama_lengkap}}</td>
								<td>{{$guest->kamar->nomor_kamar}}</td>
								<td>{{$guest->tgl_checkin}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">News / Internal Announcements</h3>
				</div>
				<div class="box-body">
					<ul class="list-unstyled">
						@foreach($berita as $new)
						<li>
							<h4>
								<a href="#" @click.prevent="ambilBerita({{$new->id}})"><b>{{$new->title}}</b></a> <span class="badge {{$new->status == 0 ? 'bg-green' : 'bg-red' }}">{{$new->status_text}}</span><br>
								<span class="small">Oleh : <b>{{$new->user->name}}</b> - {{date('Y-m-d H:i',strtotime($new->created_at))}}</span>
							</h4>
							<hr>
						</li>
						@endforeach
					</ul>
					<a href="{{route('berita.index')}}" class="btn btn-primary btn-sm pull-right">View more </a>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Guests checking out today</h3>
				</div>
				<div class="box-body">
					<table class="table table-sriped">
						<thead>
							<tr>
								<th>Name</th>
								<th># Room</th>
								<th>Date / Time of the Check-Out</th>
							</tr>
						</thead>
						<tbody>
							@foreach($tamu_checkout as $guest)
							<tr>
								<td>{{$guest->tamu->nama_lengkap}}</td>
								<td>{{$guest->kamar->nomor_kamar}}</td>
								<td>{{$guest->tgl_checkout}}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<div class="modal fade" id="edit-data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-name" id="myModalLabel">@{{dataEdit.title}}</h4><br>
                <small>To / By: <b>@{{dataEdit.user.name}}</b> | Dibuat: @{{dataEdit.created_at}}</small>
                      <span class="label label-success" v-if="dataEdit.status == 0">Normal</span>
                      <span class="label label-danger" v-else>Important</span>
              </div>
               <div class="modal-body">
                <p>@{{dataEdit.isi_berita}}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
	</div>
@endsection
@push('script')
<script>
	var dash = new Vue({
		el : '#dashboard',
		data : {
			dataEdit: {'user': []}
		},
		methods : {
			ambilBerita:function(id){
				axios.get(base_url+'/admin/berita/'+id).then(response => {
					this.dataEdit = response.data;
				}).catch(errors => {

				})
				$("#edit-data").modal('show');
			}
		}
	})
</script>
@endpush