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
			@if(Auth::user()->group==1 || Auth::user()->group==2)
				<div class="col-lg-4 col-xs-6">
				<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
						<h3>{{ $pegawai }}</h3>

						<p>Total ASN</p>
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
						<h3>{{ $pns }}</h3>

						<p>Total PNS</p>
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
					<div class="small-box bg-yellow">
						<div class="inner">
						<h3>{{ $cpns }}</h3>

						<p>Total CPNS</p>
						</div>
						<div class="icon">
						<i class="fa fa-users"></i>
						</div>
						<a href="{{ url('pegawai') }}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
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
			@endif
			</div>
			<!-- /.row -->
	</section>
</div>
@endsection