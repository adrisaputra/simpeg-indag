@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('PEGAWAI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('PEGAWAI') }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
		@if(Auth::user()->group==1)
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					<a href="{{ url('/pegawai/create') }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a>
					<a href="{{ url('/pegawai') }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/pegawai/search') }}" method="GET">
						<div class="input-group margin">
							<input type="text" class="form-control" name="search" placeholder="Masukkan kata kunci pencarian">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-danger btn-flat">cari</button>
							</span>
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif
			
			<div class="table-responsive box-body">

				<table class="table table-bordered">
					<tr>
						<td colspan=2>
							<center>
								@if($pegawai[0]->foto)
									<img src="{{ asset('storage/upload/foto_pegawai/thumbnail/'.$pegawai[0]->foto) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
								@else
									<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
								@endif
								<br><br>
								<p style="font-size:20px">{{ $pegawai[0]->nama_pegawai }}</p>
								<p style="font-size:16px">{{ $pegawai[0]->nip }}</p>
							</center>
						</td>
					</tr>
					<tr>
						<th style="width: 200px">Status Kepegawaian</th>
						<td>: {{ $pegawai[0]->status }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Jabatan</th>
						<td>: {{ $pegawai[0]->jabatan }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Pangkat</th>
						<td>: {{ $pegawai[0]->golongan }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Tempat Tanggal Lahir</th>
						<td>: {{ $pegawai[0]->tempat_lahir }}, {{ date('d-m-Y', strtotime($pegawai[0]->tanggal_lahir)) }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Nomor Telepon</th>
						<td>: {{ $pegawai[0]->no_telepon }} </td>
					</tr>
					<tr>
						<th style="width: 200px">Bank</th>
						<td>: {{ $pegawai[0]->bank }} ( {{ $pegawai[0]->no_rekening }} )</td>
					</tr>
					<tr>
						<th style="width: 200px">Nomor NPWP</th>
						<td>: {{ $pegawai[0]->no_npwp }} </td>
					</tr>
					<tr>
						<th style="width: 200px">Alamat</th>
						<td>: {{ $pegawai[0]->alamat}}</td>
					</tr>
					<tr>
						<th style="width: 200px">Gaji</th>
						<td>: {{ number_format($pegawai[0]->gaji,0,",",".") }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Nama Penghargaan</th>
						<td>: {{ $pegawai[0]->nama_penghargaan }}</td>
					</tr>
					<tr>
						<th style="width: 200px">Foto Penghargaan</th>
						<td>@if($pegawai[0]->foto_penghargaan)
								<img src="{{ asset('storage/upload/foto_penghargaan/thumbnail/'.$pegawai[0]->foto_penghargaan) }}" width="130px" height="150px">
							@endif</td>
					</tr>
				</table>
				
			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
		</div>
	</div>
	</section>
</div>
@endsection