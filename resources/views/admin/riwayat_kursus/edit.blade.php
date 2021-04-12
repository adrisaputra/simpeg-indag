@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA KURSUS') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA KURSUS') }}</a></li>
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
			<h3 class="box-title">Edit Data Kursus</h3>
		</div>
		
		<form action="{{ url('/riwayat_kursus/edit/'.$pegawai[0]->id.'/'.$riwayat_kursus->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA KURSUS</p></center>

					<div class="form-group @if ($errors->has('nama_kursus')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Kursus') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_kursus'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_kursus') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Kursus" name="nama_kursus" value="{{ $riwayat_kursus->nama_kursus }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tempat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tempat Kursus') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tempat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tempat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tempat Kursus" name="tempat" value="{{ $riwayat_kursus->tempat  }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('penyelenggara')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Penyelenggara') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('penyelenggara'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('penyelenggara') }}</label>@endif
							<input type="text" class="form-control" placeholder="Penyelenggara" name="penyelenggara" value="{{ $riwayat_kursus->penyelenggara }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_sertifikat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. Sertifikat') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_sertifikat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sertifikat') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. Sertifikat" name="no_sertifikat" value="{{ $riwayat_kursus->no_sertifikat }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_sertifikat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Sertifikat') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_sertifikat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sertifikat') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Sertifikat" name="tanggal_sertifikat" value="{{ $riwayat_kursus->tanggal_sertifikat }}">
                                    </div>
							 
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_kursus/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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