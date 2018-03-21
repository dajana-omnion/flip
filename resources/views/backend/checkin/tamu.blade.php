@extends('layouts.main')
@section('content')
<div class="box">
		<div class="box-body">
			<table class="table table-striped">
				<thead>
					<tr>
						<th># Room</th>
						<th>Guest</th>
						<th>Date of Check-In</th>
						<th>Date of Check-Out</th>
						<th>Deposit</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transaksi as $tamu)
					<tr>
						<td>{{$tamu->kamar->nomor_kamar}}</td>
						<td>{{$tamu->tamu->nama_lengkap}}</td>
						<td>{{date('Y-m-d',strtotime($tamu->tgl_checkin))}}</td>
						<td>{{date('Y-m-d',strtotime($tamu->tgl_checkout))}}</td>
						<td>{{$tamu->deposit_format}}</td>
						<td><a class="btn btn-xs btn-primary" href="{{route('checkin.show',$tamu->id)}}">Edit</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection