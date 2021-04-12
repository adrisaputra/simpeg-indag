@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA DIKLAT') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA DIKLAT') }}</a></li>
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
			<h3 class="box-title">Tambah Data Diklat</h3>
		</div>
		
		<form action="{{ url('/riwayat_diklat/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA DIKLAT</p></center>

					<div class="form-group @if ($errors->has('diklat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Diklat') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('diklat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('diklat') }}</label>@endif
							<select class="form-control" name="diklat">
                                        <option value=""> -Pilih Diklat-</option>
                                        <option value="Diklat Fungsional" @if(old('diklat')=="Diklat Fungsional") selected @endif> Diklat Fungsional</option>
                                        <option value="Diklat Struktural" @if(old('diklat')=="Diklat Struktural") selected @endif> Diklat Struktural</option>
                                        <option value="Diklat Teknis" @if(old('diklat')=="Diklat Teknis") selected @endif> Diklat Teknis</option>
                                        <option value="Diklat Pradiklat" @if(old('diklat')=="Diklat Pradiklat") selected @endif> Diklat Pradiklat</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('nama_diklat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Diklat') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_diklat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_diklat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Diklat" name="nama_diklat" value="{{ old('nama_diklat') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tempat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tempat Diklat') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tempat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tempat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tempat Diklat" name="tempat" value="{{ old('tempat') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('penyelenggara')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Penyelenggara') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('penyelenggara'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('penyelenggara') }}</label>@endif
							<input type="text" class="form-control" placeholder="Penyelenggara" name="penyelenggara" value="{{ old('penyelenggara') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_sertifikat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. Sertifikat') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('no_sertifikat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sertifikat') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. Sertifikat" name="no_sertifikat" value="{{ old('no_sertifikat') }}" >
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
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Sertifikat" name="tanggal_sertifikat" value="{{ old('tanggal_sertifikat') }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_mulai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Mulai') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Selesai') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jam')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jam') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('jam'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jam') }}</label>@endif
							<input type="text" class="form-control" placeholder="Jam" name="jam" value="{{ old('jam') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('angkatan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Angkatan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('angkatan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('angkatan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Angkatan" name="angkatan" value="{{ old('angkatan') }}" >

							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_diklat/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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