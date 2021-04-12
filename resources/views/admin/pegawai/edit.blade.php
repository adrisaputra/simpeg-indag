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
			<h3 class="box-title">Edit Pegawai</h3>
		</div>
		
		<form action="{{ url('/pegawai/edit/'.$pegawai->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
		<input type="hidden" name="_method" value="PUT">
		
			<div class="box-body">
				<div class="col-lg-12">

					<center><p style="font-size:20px">DATA PRIBADI</p></center>

					<div class="form-group @if ($errors->has('nip')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('NIP') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nip'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nip') }}</label>@endif
							<input type="text" class="form-control" placeholder="NIP" name="nip" value="{{ $pegawai->nip }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('nama_pegawai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Nama Pegawai') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('nama_pegawai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('nama_pegawai') }}</label>@endif
							<input type="text" class="form-control" placeholder="Nama Pegawai" name="nama_pegawai" value="{{ $pegawai->nama_pegawai }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('tempat_lahir')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tempat Lahir') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tempat_lahir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tempat_lahir') }}</label>@endif
							<input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" value="{{ $pegawai->tempat_lahir }}" >
						</div>
					</div>

					<div class="form-group @if ($errors->has('tanggal_lahir')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tanggal Lahir') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tanggal_lahir'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_lahir') }}</label>@endif
							<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
								<input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="tanggal_lahir" value="{{ $pegawai->tanggal_lahir }}">
							</div>
						</div>
					</div>

					<div class="form-group @if ($errors->has('jenis_kelamin')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jenis Kelamin') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jenis_kelamin'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jenis_kelamin') }}</label>@endif
							<select class="form-control select2" name="jenis_kelamin">
								<option value=""> -Pilih Jenis Kelamin-</option>
								<option value="Pria" @if($pegawai->jenis_kelamin=="Pria") selected @endif> Pria</option>
								<option value="Wanita" @if($pegawai->jenis_kelamin=="Wanita") selected @endif> Wanita</option>
							
							</select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('alamat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Alamat') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('alamat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('alamat') }}</label>@endif
							<textarea class="form-control" placeholder="Alamat" name="alamat">{{ $pegawai->alamat }}</textarea>
						</div>
					</div>

					<div class="form-group @if ($errors->has('agama')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Agama') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('agama'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('agama') }}</label>@endif
							<select class="form-control select2" name="agama">
								<option value=""> -Pilih Agama-</option>
								<option value="Islam" @if($pegawai->agama=="Islam") selected @endif> Islam</option>
								<option value="Katolik" @if($pegawai->agama=="Katolik") selected @endif> Katolik</option>
								<option value="Hindu" @if($pegawai->agama=="Hindu") selected @endif> Hindu</option>
								<option value="Budha" @if($pegawai->agama=="Budha") selected @endif> Budha</option>
								<option value="Sinto" @if($pegawai->agama=="Sinto") selected @endif> Sinto</option>
								<option value="Konghucu" @if($pegawai->agama=="Konghucu") selected @endif> Konghucu</option>
								<option value="Protestan" @if($pegawai->agama=="Protestan") selected @endif> Protestan</option>
							</select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('gol_darah')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Gol. Darah') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('gol_darah'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('gol_darah') }}</label>@endif
							<select class="form-control select2" name="gol_darah">
								<option value=""> -Pilih Gol. Darah-</option>
								<option value="A" @if($pegawai->gol_darah=="A") selected @endif> A</option>
								<option value="B" @if($pegawai->gol_darah=="B") selected @endif> B</option>
								<option value="AB" @if($pegawai->gol_darah=="AB") selected @endif> AB</option>
								<option value="O" @if($pegawai->gol_darah=="O") selected @endif> O</option>
							
							</select>
						</div>
					</div>

					<div class="form-group @if ($errors->has('email')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Email') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('email'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('email') }}</label>@endif
							<input type="email" class="form-control" placeholder="Email" name="email" value="{{ $pegawai->email }}" >
						</div>
					</div>


					<div class="form-group @if ($errors->has('no_ktp')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('KTP') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3">
							@if ($errors->has('no_ktp'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_ktp') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. KTP" name="no_ktp" value="{{ $pegawai->no_ktp }}" >
						</div>
						<div class="col-sm-4" @if($errors->has('no_ktp')) style="padding-top:27px" @endif>
							@if ($errors->has('ktp'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('ktp') }}</label>@endif
							<input type="file" class="form-control" placeholder="KTP" name="ktp" value="{{ $pegawai->ktp }}" style="border-color: #d3d7df;" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2"  @if($errors->has('no_ktp')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($pegawai->ktp)
								<a href="{{ asset('storage/upload/ktp/'.$pegawai->ktp) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>

					<div class="form-group @if ($errors->has('no_bpjs')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('BPJS') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3">
							@if ($errors->has('no_bpjs'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_bpjs') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. BPJS" name="no_bpjs" value="{{  $pegawai->no_bpjs }}" >
						</div>
						<div class="col-sm-4" @if($errors->has('no_bpjs')) style="padding-top:27px" @endif>
							@if ($errors->has('bpjs'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('bpjs') }}</label>@endif
							<input type="file" class="form-control" placeholder="BPJS" name="bpjs" value="{{  $pegawai->bpjs }}" style="border-color: #d3d7df;" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2" @if($errors->has('no_bpjs')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($pegawai->bpjs)
								<a href="{{ asset('storage/upload/bpjs/'.$pegawai->bpjs) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_npwp')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('NPWP') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3">
							@if ($errors->has('no_npwp'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_npwp') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. NPWP" name="no_npwp" value="{{ $pegawai->no_npwp  }}" >
						</div>
						<div class="col-sm-4" @if($errors->has('no_npwp')) style="padding-top:27px" @endif>
							@if ($errors->has('npwp'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('npwp') }}</label>@endif
							<input type="file" class="form-control" placeholder="NPWP" name="npwp" value="{{ $pegawai->npwp }}" style="border-color: #d3d7df;">
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2" @if($errors->has('no_npwp')) style="padding-top:27px" @else style="padding-top:2px" @endif >
						@if($pegawai->npwp)
								<a href="{{ asset('storage/upload/npwp/'.$pegawai->npwp) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('no_karpeg')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Karpeg') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3">
							@if ($errors->has('no_karpeg'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_karpeg') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. Karpeg" name="no_karpeg" value="{{ $pegawai->no_karpeg }}" >
						</div>
						<div class="col-sm-4" @if($errors->has('no_karpeg')) style="padding-top:27px" @endif>
							@if ($errors->has('karpeg'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('karpeg') }}</label>@endif
							<input type="file" class="form-control" placeholder="Karpeg" name="karpeg" value="{{ $pegawai->karpeg }}" style="border-color: #d3d7df;">
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2" @if($errors->has('no_karpeg')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($pegawai->karpeg)
								<a href="{{ asset('storage/upload/karpeg/'.$pegawai->karpeg) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>

					<div class="form-group @if ($errors->has('no_karsu')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Karsu/Karis') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3">
							@if ($errors->has('no_karsu'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_karsu') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. Karsu/Karis" name="no_karsu" value="{{ $pegawai->no_karsu }}" >
						</div>
						<div class="col-sm-4" @if($errors->has('no_karsu')) style="padding-top:27px" @endif>
							@if ($errors->has('karsu'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('karsu') }}</label>@endif
							<input type="file" class="form-control" placeholder="Karsu/Karis" name="karsu" value="{{ $pegawai->karsu }}" style="border-color: #d3d7df;">
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
						</div>
						<div class="col-sm-2" @if($errors->has('no_karsu')) style="padding-top:27px" @else style="padding-top:2px" @endif >
							@if($pegawai->karsu)
								<a href="{{ asset('storage/upload/karsu/'.$pegawai->karsu) }}" target="_blank" class="btn btn-sm btn-primary" >Lihat File</a>
							@endif
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('foto_formal')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Foto Formal') }}</label>
						<div class="col-sm-4">
							@if ($errors->has('foto_formal'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('foto_formal') }}</label>@endif
							<input type="file" class="form-control" placeholder="Foto" name="foto_formal" value="{{ $pegawai->foto_formal }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							@if($pegawai->foto_formal)
								<img src="{{ asset('storage/upload/foto_formal_pegawai/thumbnail/'.$pegawai->foto_formal) }}" width="150px" height="150px">
							@endif
						</div>
					</div>

					<div class="form-group @if ($errors->has('foto_kedinasan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Foto Kedinasan') }}</label>
						<div class="col-sm-4">
							@if ($errors->has('foto_kedinasan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('foto_formal') }}</label>@endif
							<input type="file" class="form-control" placeholder="Foto" name="foto_kedinasan" value="{{ $pegawai->foto_kedinasan }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png)</i></span>
							@if($pegawai->foto_kedinasan)
								<img src="{{ asset('storage/upload/foto_kedinasan_pegawai/thumbnail/'.$pegawai->foto_kedinasan) }}" width="150px" height="150px">
							@endif
						</div>
					</div>

					<hr style="border-top: 1px solid #eee;">

					<center><p style="font-size:20px">DATA KEPEGAWAIAN</p></center>

					<div class="form-group @if ($errors->has('jabatan_id')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jabatan') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('jabatan_id'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jabatan_id') }}</label>@endif
							<select class="form-control" name="jabatan_id" onchange=" if (this.selectedIndex=='1'){ 
												document.getElementById('bidang').style.display = 'none'; 
												document.getElementById('seksi').style.display = 'none'; 
											} else if (this.selectedIndex=='2'){
												document.getElementById('bidang').style.display = 'none'; 
												document.getElementById('seksi').style.display = 'none';
											} else if (this.selectedIndex=='3'){
												document.getElementById('bidang').style.display = 'inline'; 
												document.getElementById('seksi').style.display = 'none';
											} else if (this.selectedIndex=='4'){
												document.getElementById('bidang').style.display = 'none'; 
												document.getElementById('seksi').style.display = 'inline';
											} else if (this.selectedIndex=='5'){
												document.getElementById('bidang').style.display = 'inline'; 
												document.getElementById('seksi').style.display = 'none';
											} else if (this.selectedIndex=='6'){
												document.getElementById('bidang').style.display = 'none'; 
												document.getElementById('seksi').style.display = 'none';
											} else if (this.selectedIndex=='7'){
												document.getElementById('bidang').style.display = 'inline'; 
												document.getElementById('seksi').style.display = 'inline';
											} else {
												document.getElementById('bagian').style.display = 'none'; 
												document.getElementById('seksi').style.display = 'none';
											} ;">
								<option value=""> -Pilih Jabatan-</option>
								@foreach($jabatan as $v)
								<option value="{{ $v->id }}" @if($pegawai->jabatan_id==$v->id) selected @endif>{{ $v->nama_jabatan}}</option>
								@endforeach
							</select>
						</div>
					</div>

					@if($pegawai->jabatan_id==3 
								|| $pegawai->jabatan_id==5
								|| $pegawai->jabatan_id==7)
						<span id='bidang' style='display:inline;'>
					@else
						<span id='bidang' style='display:none;'>
					@endif
					<div class="form-group @if ($errors->has('bidang_id')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Bidang') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('bidang_id'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('bidang_id') }}</label>@endif
							<select class="form-control" name="bidang_id">
								<option value=""> -Pilih Bidang-</option>
								@foreach($bidang as $v)
								<option value="{{ $v->id }}" @if($pegawai->bidang_id==$v->id) selected @endif>{{ $v->nama_bidang}}</option>
								@endforeach
							</select>
						</div>
					</div>
					</span>

					@if($pegawai->jabatan_id==4
								|| $pegawai->jabatan_id==7)
						<span id='seksi' style='display:inline;'>
					@else
						<span id='seksi' style='display:none;'>
					@endif
					<div class="form-group @if ($errors->has('seksi_id')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Seksi/Bagian') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('seksi_id'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('seksi_id') }}</label>@endif
							<select class="form-control" name="seksi_id">
								<option value=""> -Pilih Seksi/Bagian-</option>
								@foreach($seksi as $v)
								<option value="{{ $v->id }}" @if($pegawai->seksi_id==$v->id) selected @endif>{{ $v->nama_seksi}}</option>
								@endforeach
							</select>
						</div>
					</div>
					</span>

					<div class="form-group @if ($errors->has('status')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Status Kepegawaian') }}</label>
						<div class="col-sm-10">
							@if ($errors->has('status'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('status') }}</label>@endif
							<select class="form-control select2" name="status">
								<option value=""> -Pilih Status Kepegawaian-</option>
								<option value="PNS" @if($pegawai->status=="PNS") selected @endif> PNS</option>
								<option value="CPNS" @if($pegawai->status=="CPNS") selected @endif> CPNS</option>
							</select>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/pegawai') }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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