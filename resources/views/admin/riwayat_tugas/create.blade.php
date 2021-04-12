@extends('admin.layout')
@section('konten')
<div class="content-wrapper">
<section class="content-header">
	<h1 class="fontPoppins">{{ __('DATA TUGAS') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('DATA TUGAS') }}</a></li>
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
			<h3 class="box-title">Tambah Data Tugas</h3>
		</div>
		
		<form action="{{ url('/riwayat_tugas/'.$pegawai[0]->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		{{ csrf_field() }}
			<div class="box-body">
				<div class="col-lg-12">

				<center><p style="font-size:20px">DATA TUGAS</p></center>

					<div class="form-group @if ($errors->has('keterangan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Keterangan') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('keterangan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('keterangan') }}</label>@endif
							<select class="form-control" name="keterangan">
                                        <option value=""> -Pilih Keterangan-</option>
                                        <option value="Keterangan Fungsional" @if(old('keterangan')=="Keterangan Fungsional") selected @endif> Keterangan Fungsional</option>
                                        <option value="Keterangan Struktural" @if(old('keterangan')=="Keterangan Struktural") selected @endif> Keterangan Struktural</option>
                                        <option value="Keterangan Teknis" @if(old('keterangan')=="Keterangan Teknis") selected @endif> Keterangan Teknis</option>
                                        <option value="Keterangan Praketerangan" @if(old('keterangan')=="Keterangan Praketerangan") selected @endif> Keterangan Praketerangan</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('tingkat')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Tingkat ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('tingkat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tingkat') }}</label>@endif
							<select class="form-control" name="tingkat">
                                        <option value=""> -Pilih Tingkat -</option>
                                        <option value="Tingkat  Fungsional" @if(old('tingkat')=="Tingkat  Fungsional") selected @endif> Tingkat  Fungsional</option>
                                        <option value="Tingkat  Struktural" @if(old('tingkat')=="Tingkat  Struktural") selected @endif> Tingkat  Struktural</option>
                                        <option value="Tingkat  Teknis" @if(old('tingkat')=="Tingkat  Teknis") selected @endif> Tingkat  Teknis</option>
                                        <option value="Tingkat  Pratingkat" @if(old('tingkat')=="Tingkat  Pratingkat") selected @endif> Tingkat  Pratingkat</option>
                                    </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('negara')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Negara ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('negara'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('negara') }}</label>@endif
							<select class="form-control" name="negara">
                                        <option value=""> -Pilih Negara -</option>
                                        <option value="Negara  Fungsional" @if(old('negara')=="Negara  Fungsional") selected @endif> Negara  Fungsional</option>
                                        <option value="Negara  Struktural" @if(old('negara')=="Negara  Struktural") selected @endif> Negara  Struktural</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('provinsi')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Provinsi ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('provinsi'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('provinsi') }}</label>@endif
							<select class="form-control" name="provinsi">
                                        <option value=""> -Pilih Provinsi -</option>
                                        <option value="Provinsi  Fungsional" @if(old('provinsi')=="Provinsi  Fungsional") selected @endif> Provinsi  Fungsional</option>
                                        <option value="Provinsi  Struktural" @if(old('provinsi')=="Provinsi  Struktural") selected @endif> Provinsi  Struktural</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('fakultas')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Fakultas ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('fakultas'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('fakultas') }}</label>@endif
							<select class="form-control" name="fakultas">
                                        <option value=""> -Pilih Fakultas -</option>
                                        <option value="Fakultas  Fungsional" @if(old('fakultas')=="Fakultas  Fungsional") selected @endif> Fakultas  Fungsional</option>
                                        <option value="Fakultas  Struktural" @if(old('fakultas')=="Fakultas  Struktural") selected @endif> Fakultas  Struktural</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('jurusan')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Jurusan ') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('jurusan'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('jurusan') }}</label>@endif
							<select class="form-control" name="jurusan">
                                        <option value=""> -Pilih Jurusan -</option>
                                        <option value="Jurusan  Fungsional" @if(old('jurusan')=="Jurusan  Fungsional") selected @endif> Jurusan  Fungsional</option>
                                        <option value="Jurusan  Struktural" @if(old('jurusan')=="Jurusan  Struktural") selected @endif> Jurusan  Struktural</option>
                                   </select>
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('tmt_mulai') || $errors->has('tmt_selesai')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('TMT') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('tmt_mulai') && $errors->has('tmt_selesai')) @elseif ($errors->has('tmt_selesai')) style="padding-top:27px" @endif>
							@if ($errors->has('tmt_mulai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_mulai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('tmt_mulai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('tmt_mulai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Mulai" name="tmt_mulai" value="{{ old('tmt_mulai') }}" @if(old('tmt_mulai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
						<div class="col-sm-3" @if($errors->has('tmt_mulai') && $errors->has('tmt_selesai')) @elseif ($errors->has('tmt_mulai')) style="padding-top:27px" @endif>
							@if ($errors->has('tmt_selesai'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tmt_selesai') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('tmt_selesai')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('tmt_selesai')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="TMT Selesai" name="tmt_selesai" value="{{ old('tmt_selesai') }}" @if(old('tmt_selesai')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div>
					
					<div class="form-group  @if ($errors->has('no_surat') || $errors->has('tanggal_izin')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('No. Surat / Tanggal Izin') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-3" @if($errors->has('no_surat') && $errors->has('tanggal_izin')) @elseif ($errors->has('tanggal_izin')) style="padding-top:27px" @endif>
							@if ($errors->has('no_surat'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('no_surat') }}</label>@endif
							<input type="text" class="form-control" placeholder="No. SK" name="no_surat" value="{{ old('no_surat') }}" @if(old('no_surat')) style="border-color: #d3d7df;" @endif>
						</div>
						<div class="col-sm-3" @if($errors->has('no_surat') && $errors->has('tanggal_izin')) @elseif ($errors->has('no_surat')) style="padding-top:27px" @endif>
							@if ($errors->has('tanggal_izin'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('tanggal_izin') }}</label>@endif
							<div class="input-group date">
                                    <div class="input-group-addon" @if(old('tanggal_izin')) style="border-color: #d3d7df;" @endif>
                                        <i class="fa fa-calendar" @if(old('tanggal_izin')) style="color: #555555;" @endif></i>
                                    </div>
                                        <input type="text" class="form-control datepicker" placeholder="Tanggal Izin" name="tanggal_izin" value="{{ old('tanggal_izin') }}" @if(old('tanggal_izin')) style="border-color: #d3d7df;" @endif>
                                    </div>
						</div>
					</div>
					
					<div class="form-group @if ($errors->has('arsip_tugas')) has-error @endif">
						<label class="col-sm-2 control-label">{{ __('Arsip Tugas') }} <span class="required" style="color: #dd4b39;">*</span></label>
						<div class="col-sm-10">
							@if ($errors->has('arsip_tugas'))<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('arsip_tugas') }}</label>@endif
							<input type="file" class="form-control" placeholder="Arsip Tugas" name="arsip_tugas" value="{{ old('arsip_tugas') }}" >
							<span style="font-size:11px"><i>Ukuran File Tidak Boleh Lebih Dari 500 Kb (jpg,jpeg,png,pdf)</i></span>
							
							<div style="padding-top:10px">
								<button type="submit" class="btn btn-primary btn-flat btn-sm" title="Tambah Data"> Simpan</button>
								<button type="reset" class="btn btn-danger btn-flat btn-sm" title="Reset Data"> Reset</button>
								<a href="{{ url('/riwayat_tugas/'.$pegawai[0]->id ) }}" class="btn btn-warning btn-flat btn-sm" title="Kembali">Kembali</a>
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