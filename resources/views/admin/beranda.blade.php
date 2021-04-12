@extends('admin/layout')
@section('konten')

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">
		
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
	</ol>
	</ol>
	</section>
	
	<section class="content">
	
	<div class="box-body">
			<!-- Small boxes (Stat box) -->
			<div class="row">
			@if(Auth::user()->group==1)
				<div class="col-lg-4 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
						<h3></h3>

						<p>Total Pegawai</p>
						</div>
						<div class="icon">
						<i class="fa fa-users"></i>
						</div>
						<a href="{{ url('pegawai') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
						<h3></h3>

						<p>Total Barang</p>
						</div>
						<div class="icon">
						<i class="fa fa-box"></i>
						</div>
						<a href="{{ url('barang') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-4 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
						<h3></h3>

						<p>Pengambilan</p>
						</div>
						<div class="icon">
						<i class="fa fa-close"></i>
						</div>
						<a href="{{ url('pengambilan') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
			@elseif(Auth::user()->group==5)
				<div class="col-lg-4 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
						<h3>{{ $pegawai }}</h3>

						<p>Total Pegawai</p>
						</div>
						<div class="icon">
						<i class="fa fa-users"></i>
						</div>
						<a href="{{ url('pegawai') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			@elseif(Auth::user()->group==2 || Auth::user()->group==4 || Auth::user()->group==6)
				<div class="col-lg-6 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
						<h3>{{ $pengambilan_belum_di_proses }}</h3>

						<p>Pengambilan Belum Di Proses</p>
						</div>
						<div class="icon">
						<i class="fa"></i>
						</div>
						<a href="{{ url('pengambilan') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-6 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
						<h3>{{ $pengambilan_di_proses }}</h3>

						<p>Pengambilan Di Proses</p>
						</div>
						<div class="icon">
						<i class="fa fa-box"></i>
						</div>
						<a href="{{ url('pengambilan') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
			@endif
			</div>
			<!-- /.row -->
	</section>
</div>
@endsection