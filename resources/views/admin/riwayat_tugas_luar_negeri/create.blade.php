@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA TUGAS LUAR NEGERI') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA TUGAS LUAR NEGERI') }}</a></li>
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
			<h3 class="box-title">Tambah Data Tugas Luar Negeri</h3>
		</div>
		
		<form action="{{ url('/riwayat_tugas_luar_negeri/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA TUGAS LUAR NEGERI</p></center>

					<div class="form-group @if ($errors->has('tujuan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tujuan') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tujuan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tujuan') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tujuan" name="tujuan" value="{{ old('tujuan') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_mulai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Mulai') }} <span class="required">*</span></label>
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
						<label class="col-sm-2 control-label">{{ __('Tanggal Selesai') }} <span class="required">*</span></label>
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
					
					<div class="form-group @if ($errors->has('no_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. SK') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('no_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sk') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_sk" value="{{ old('no_sk') }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tanggal_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal SK') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_sk') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal SK" name="tanggal_sk" value="{{ old('tanggal_sk') }}">
                                    </div>
						</div>
					</div>

					
					<div class="form-group @if ($errors->has('pejabat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pejabat') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('pejabat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pejabat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pejabat" name="pejabat" value="{{ old('pejabat') }}" >
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_tugas_luar_negeri/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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