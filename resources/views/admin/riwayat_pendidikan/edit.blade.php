@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA PENDIDIKAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA PENDIDIKAN') }}</a></li>
	</ol>
	</section>

	<section class="content">
	
	<div class="box">
		<div class="box-body">
			<div class="col-lg-6">
				<div class="form-group">
					<label >NIP</label>
					<input type="text" class="form-control" placeholder="NIP" value="{{ $pegawai[0]->nip }}" disabled>
				</div>

			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label >Nama Pegawai</label>
					<input type="text" class="form-control" placeholder="Nama Pegawai" value="{{ $pegawai[0]->nama_pegawai }}" disabled>
				</div>
			</div>
		</div>
	</div>

	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Edit Data Pendidikan</h3>
		</div>
		
		<form action="{{ url('/riwayat_pendidikan/edit/'.$pegawai[0]->id.'/'.$riwayat_pendidikan->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA PENDIDIKAN</p></center>

					
					<div class="form-group @if ($errors->has('pendidikan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Pendidikan') }} <span class="required">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('pendidikan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pendidikan') }}</label>@endif
							<select class="form-control" name="pendidikan">
                                        <option value=""> -Pilih Pendidikan-</option>
                                        <option value="SD" @if($riwayat_pendidikan->pendidikan=="SD") selected @endif> SD</option>
                                        <option value="SLTP" @if($riwayat_pendidikan->pendidikan=="SLTP") selected @endif> SLTP</option>
                                        <option value="SLTP Kejuruan" @if($riwayat_pendidikan->pendidikan=="SLTP Kejuruan") selected @endif> SLTP Kejuruan</option>
                                        <option value="SLTA" @if($riwayat_pendidikan->pendidikan=="SLTA") selected @endif> SLTA</option>
                                        <option value="SLTA Kejuruan" @if($riwayat_pendidikan->pendidikan=="SLTA Kejuruan") selected @endif> SLTA Kejuruan</option>
                                        <option value="SLTA Keguruan" @if($riwayat_pendidikan->pendidikan=="SLTA Keguruan") selected @endif> SLTA Keguruan</option>
                                        <option value="Diploma I" @if($riwayat_pendidikan->pendidikan=="Diploma I") selected @endif> Diploma I</option>
                                        <option value="Diploma II" @if($riwayat_pendidikan->pendidikan=="Diploma II") selected @endif> Diploma II</option>
                                        <option value="Diploma III / Sarjana Muda" @if($riwayat_pendidikan->pendidikan=="Diploma III / Sarjana Muda") selected @endif> Diploma III / Sarjana Muda</option>
                                        <option value="Diploma IV" @if($riwayat_pendidikan->pendidikan=="Diploma IV") selected @endif> Diploma IV</option>
                                        <option value="S1 / Sarjana" @if($riwayat_pendidikan->pendidikan=="S1 / Sarjana") selected @endif> S1 / Sarjana</option>
                                        <option value="S2" @if($riwayat_pendidikan->pendidikan=="S2") selected @endif> S2</option>
                                        <option value="S3 / Doktor" @if($riwayat_pendidikan->pendidikan=="S3 / Doktor") selected @endif> S3 / Doktor</option>
                                       
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('nama_sekolah')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Nama Sekolah / Institusi') }} <span class="required">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('nama_sekolah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_sekolah') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Sekolah / Institusi" name="nama_sekolah" value="{{ $riwayat_pendidikan->nama_sekolah }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jurusan')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Nama Jurusan / Program Studi') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('jurusan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jurusan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Jurusan / Program Studi" name="jurusan" value="{{ $riwayat_pendidikan->jurusan }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_ijazah')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('No. Ijazah') }}</label>
						<div class="col-sm-9">
							@if ($errors->has('no_ijazah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_ijazah') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. Ijazah" name="no_ijazah" value="{{ $riwayat_pendidikan->no_ijazah }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tahun_ijazah')) has-error @endif">
						<label class="col-sm-3 control-label">{{ __('Tahun Ijazah') }} <span class="required">*</span></label>
						<div class="col-sm-9">
							@if ($errors->has('tahun_ijazah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tahun_ijazah') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tahun Ijazah" name="tahun_ijazah" value="{{ $riwayat_pendidikan->tahun_ijazah }}" >
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_pendidikan/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
	</div>
	</section>
</div>

@endsection