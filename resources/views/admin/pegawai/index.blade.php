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
						<th>NIP</th>
						<th>Nama Pegawai</th>
						<th>Golongan</th>
						<th>Foto</th>
						<th style="width: 20%">#aksi</th>
					</tr>
					@foreach($pegawai as $v)
					<tr>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ ($pegawai ->currentpage()-1) * $pegawai ->perpage() + $loop->index + 1 }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ $v->nip }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ $v->nama_pegawai }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}">{{ $v->golongan }}</td>
						<td data-toggle="modal" data-target="#modalDetail{{$v->id}}"><center>
						@if($v->foto_formal)
									<img src="{{ asset('storage/upload/foto_formal_pegawai/thumbnail/'.$v->foto_formal) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
								@else
									<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
								@endif
						</td>
						<td>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 1</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_jabatan/'.$v->id) }}">Jabatan</a></li>
									<li><a href="{{ url('riwayat_angka_kredit/'.$v->id) }}">Angka Kredit</a></li>
									<li><a href="{{ url('riwayat_kepangkatan/'.$v->id) }}">Pangkat</a></li>
									<li><a href="{{ url('riwayat_lhkpn/'.$v->id) }}">LHKPN</a></li>
									<li><a href="{{ url('riwayat_kompetensi/'.$v->id) }}">Kompetensi</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 2</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_pendidikan/'.$v->id) }}">Pendidikan</a></li>
									<li><a href="{{ url('riwayat_seminar/'.$v->id) }}">Seminar</a></li>
									<li><a href="{{ url('riwayat_diklat/'.$v->id) }}">Diklat/Sertifikasi</a></li>
									<li><a href="{{ url('riwayat_tugas/'.$v->id) }}">Tugas/Izin Belajar</a></li>
									<li><a href="{{ url('riwayat_karya_iliah/'.$v->id) }}">Karya Ilmiah</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 3</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_penghargaan/'.$v->id) }}">Penghargaan</a></li>
									<li><a href="{{ url('riwayat_cuti/'.$v->id) }}">Cuti</a></li>
									<li><a href="{{ url('riwayat_hukuman/'.$v->id) }}">Hukuman Disiplin</a></li>
									<li><a href="{{ url('riwayat_kursus/'.$v->id) }}">Kursus</a></li>
									<li><a href="{{ url('riwayat_gaji/'.$v->id) }}">Gaji</a></li>
									<li><a href="{{ url('riwayat_tugas_luar_negeri/'.$v->id) }}">Riwayat Tugas Luar Negeri</a></li>
								</ul>
							</div><br>
							<div class="btn-group" style="display: block;padding-bottom:7px">
								<button type="button" class="btn btn-xs btn-primary btn-block dropdown-toggle" data-toggle="dropdown">Riwayat 4</button>
								<ul class="dropdown-menu">
									<li><a href="{{ url('riwayat_pajak/'.$v->id) }}">Laporan Pajak</a></li>
								</ul>
							</div><br>
							<a href="{{ url('/pegawai/edit/'.$v->id ) }}" class="btn btn-xs btn-warning btn-block">Edit</a>
							<a href="{{ url('/pegawai/hapus/'.$v->id ) }}" class="btn btn-xs btn-danger btn-block" onclick="return confirm('Anda Yakin ?');">Hapus</a>
						</td>
					</tr>

					<!-- Modal Update-->
					<div class="modal modal-default fade" id="modalDetail{{$v->id}}">
						<div class="modal-dialog" role="document">
							<div class="modal-content" style="border-radius: 20px;">
								<div class="modal-body" style="border-radius: 20px;">
								<center>
									@if($v->foto_formal)
										<img src="{{ asset('storage/upload/foto_formal_pegawai/thumbnail/'.$v->foto_formal) }}" class="img-circle" alt="User Image"  width="150px" height="150px">
									@else
										<img src="{{ asset('upload/user/15.jpg') }}" class="img-circle" alt="User Image" width="150px" height="150px">
									@endif
									<br><br>
									<p style="font-size:20px">{{ $v->nama_pegawai }}</p>
									<p style="font-size:16px">{{ $v->nip }}</p>
								</center><br>
								<div class="row">
									<div class="col-md-3"><b>Tempat Lahir</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->tempat_lahir }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Tanggal Lahir</b></div>
									<div class="col-md-4 ml-auto">: {{ date('d-m-Y', strtotime($v->tanggal_lahir)) }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Jenis kelamin</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->jenis_kelamin }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Alamat</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->alamat }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Agama</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->agama }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Gol. Darah</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->gol_darah }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Email</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->email }}</div>
								</div>
								<div class="row">
									<div class="col-md-3"><b>Jabatan</b></div>
									<div class="col-md-4 ml-auto">: {{ $v->jabatan->nama_jabatan }}</div>
								</div><br>
								<div class="row">
									<div class="col-md-6">
										@if($v->ktp)
											<img src="{{ asset('storage/upload/ktp/thumbnail/'.$v->ktp) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
									<div class="col-md-6">
										@if($v->bpjs)
											<img src="{{ asset('storage/upload/bpjs/thumbnail/'.$v->bpjs) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-6">
										@if($v->npwp)
											<img src="{{ asset('storage/upload/npwp/thumbnail/'.$v->npwp) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
									<div class="col-md-6">
										@if($v->karpeg)
											<img src="{{ asset('storage/upload/karpeg/thumbnail/'.$v->karpeg) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-3"></div>
									<div class="col-md-6">
										@if($v->karsu)
											<img src="{{ asset('storage/upload/karsu/thumbnail/'.$v->karsu) }}" width="260px" height="150px">
										@else
											<img src="{{ asset('upload/no-image.jpg') }}" width="260px" height="150px">
										@endif
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>

					@endforeach
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
			<div class="float-right">{{ $pegawai->appends(Request::only('search'))->links() }}</div>
		</div>
	</div>
	</section>
</div>
@endsection