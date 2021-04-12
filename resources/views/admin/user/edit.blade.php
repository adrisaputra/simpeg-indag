@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('USER') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('USER') }}</a></li>
	</ol>
	</section>

	<section class="content">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Edit User</h3>
		</div>
		
		<form action="{{ url('/user/edit/'.$user->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">
					
					<div class="form-group @if ($errors->has('name')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama User') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('name'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('name') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama User" name="name" value="{{ $user->name }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('email')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Email') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('email'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label>@endif
							<input type="email" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('password')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Password') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('password'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}</label>@endif
							<input type="password" class="form-control" placeholder="Password" name="password" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('password_confirmation')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Konfirmasi Password') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('password_confirmation'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password_confirmation') }}</label>@endif
							<input type="password" class="form-control" placeholder="Konfirmasi Password" name="password_confirmation" >
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('group')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Group') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('group'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('group') }}</label>@endif
							<select class="form-control" name="group" onchange=" if (this.selectedIndex=='7'){ 
 												document.getElementById('seksi').style.display = 'inline'; 
 											} else {
 												document.getElementById('seksi').style.display = 'none'; 
 											} ;">
								<option value="">- Pilih Group-</option>
								<option value="1" @if($user->group =="1") selected @endif>Administrator</option>
								<option value="5" @if($user->group=="5") selected @endif>Admin Kepegawaian</option>
								<option value="6" @if($user->group=="6") selected @endif>Admin Umum</option>
								<option value="7" @if($user->group=="7") selected @endif>Admin Keuangan</option>
								<option value="2" @if($user->group=="2") selected @endif>Verifikator</option>
								<option value="3" @if($user->group=="3") selected @endif>Pegawai</option>
								<option value="4" @if($user->group=="4") selected @endif>Seksi</option>
							</select>

						</div>
					</div>

					@if($user->group =="4")
                              <span id='seksi' style='display:inline;'>
                         @else
                              <span id='seksi' style='display:none;'>
                         @endif

					<div class="form-group @if ($errors->has('seksi')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Seksi') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('seksi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('seksi') }}</label>@endif
							<select class="form-control" name="seksi">
								<option value="">- Pilih Seksi-</option>
								@foreach($seksi as $v)
									<option value="{{ $v->id }}" @if($user->seksi==$v->id) selected @endif>{{ $v->nama_seksi }}</option>
								@endforeach
							</select>
						</div>
					</div>
					</span>
					
					<div class="form-group @if ($errors->has('group')) has-error @endif">
						<label class="col-sm-2 control-label"></label>
						<div class="col-sm-10">
							<div>
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/user') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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