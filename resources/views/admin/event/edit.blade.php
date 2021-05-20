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
			<h3 class="box-title">{{ __($title) }}</h3>
		</div>
		
		<form action="{{ url('/agenda/edit/'.$agenda->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<div class="form-group @if ($errors->has('title')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Kegiatan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('title'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('title') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Kegiatan" name="title" value="{{ $agenda->title }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('start')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Mulai') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('start'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('start') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Mulai" name="start" value="{{ $agenda->start }}">
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('end2')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Selesai') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('end2'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('end2') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Selesai" name="end2" value="{{ $agenda->end2 }}">
                                    </div>

							 	 
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Ubah Data</button>
								<a href="{{ url('/agenda/hapus/'.$agenda->id ) }}" class="btn btn-danger btn-flat btn-sm" onclick="return confirm('Anda Yakin ?');">Hapus Data</a>
								<a href="{{ url('/agenda') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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