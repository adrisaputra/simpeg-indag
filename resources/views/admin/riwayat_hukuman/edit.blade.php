@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA HUKUMAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA HUKUMAN') }}</a></li>
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
			<h3 class="box-title">Edit Data Hukuman</h3>
		</div>
		
		<form action="{{ url('/riwayat_hukuman/edit/'.$pegawai[0]->id.'/'.$riwayat_hukuman->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA HUKUMAN</p></center>

					<div class="form-group @if ($errors->has('nama_hukuman')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Hukuman') }} <span class="required">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_hukuman'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_hukuman') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Hukuman" name="nama_hukuman" value="{{  $riwayat_hukuman->nama_hukuman }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('uraian_hukuman')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Uraian Hukuman') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('uraian_hukuman'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('uraian_hukuman') }}</label>@endif
							<textarea class="form-control" placeholder="Uraian Hukuman" name="uraian_hukuman">{{  $riwayat_hukuman->uraian_hukuman }}</textarea>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_sk')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. SK') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('no_sk'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_sk') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_sk" value="{{  $riwayat_hukuman->no_sk }}" >
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
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal SK" name="tanggal_sk" value="{{  $riwayat_hukuman->tanggal_sk }}">
                                    </div>
						</div>
					</div>

					
					<div class="form-group @if ($errors->has('pejabat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Pejabat') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('pejabat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('pejabat') }}</label>@endif
							<input type="text" class="form-control" placeholder="Pejabat" name="pejabat" value="{{  $riwayat_hukuman->pejabat }}" >
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_hukuman/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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