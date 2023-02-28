@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __($title) }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __($title) }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
		<div class="box-header with-border">
			<div class="box-tools pull-left">
				<div style="padding-top:10px">
					@if(Auth::user()->group==1)
						<a href="{{ url('/notulen/create') }}" class="btn btn-success btn-flat" title="Tambah Data">Tambah</a>
					@endif
					<a href="{{ url('/notulen') }}" class="btn btn-warning btn-flat" title="Refresh halaman">Refresh</a>    
				</div>
			</div>
			<div class="box-tools pull-right">
				<div class="form-inline">
					<form action="{{ url('/notulen/search') }}" method="GET">
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
			
			<div class="table-responsive box-body">

				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="width: 60px">No</th>
						<th>Agenda Rapat</th>
						<th>Pimpinan Rapat</th>
						<th>Anggota Rapat</th>
						<th>Tanggal Rapat</th>
						<th>File</th>
						@if(Auth::user()->group==1)
							<th style="width: 20%">#aksi</th>
						@endif
					</tr>
					@foreach($notulen as $v)
					<tr>
						<td>{{ ($notulen ->currentpage()-1) * $notulen ->perpage() + $loop->index + 1 }}</td>
						<td>{{ $v->agenda }}</td>
						<td>{{ $v->pimpinan }}</td>
						<td>{{ $v->anggota }}</td>
						<td>{{ date('d-m-Y', strtotime($v->tanggal)) }}</td>
						<td>
							@if($v->file_notulen)
								<a href="{{ asset('upload/file_notulen/'.$v->file_notulen) }}" class="btn btn-sm btn-primary" target="blank">Download File</a>
							@endif
						</td>
						@if(Auth::user()->group==1)
							<td>
								<a href="{{ url('/notulen/edit/'.$v->id ) }}" class="btn btn-xs btn-flat btn-warning">Edit</a>
								<a href="{{ url('/notulen/hapus/'.$v->id ) }}" class="btn btn-xs btn-flat btn-danger" onclick="return confirm('Anda Yakin ?');">Hapus</a>
							</td>
						@endif
					</tr>
					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $notulen->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection