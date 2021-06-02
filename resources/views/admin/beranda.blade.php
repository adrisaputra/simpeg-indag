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
			@elseif(Auth::user()->group==3)
				<div class="col-lg-12 col-xs-12">
				<!-- small box -->
					@if($status_kehadiran[0]->kehadiran=='H')
						<div class="small-box bg-green">
							<div class="inner">
							<h3>Hadir</h3>
							<p>Absen Pagi : {{ $status_kehadiran[0]->jam_datang }}<br>
							Absen Sore : {{ $status_kehadiran[0]->jam_pulang }}</p>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@elseif($status_kehadiran[0]->kehadiran=='S')
						<div class="small-box bg-yellow">
							<div class="inner">
							<h3>Sakit</h3>
							<p>Keterangan : {{ $status_kehadiran[0]->keterangan }}</p>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@elseif($status_kehadiran[0]->kehadiran=='I')
						<div class="small-box bg-aqua">
							<div class="inner">
							<h3>Izin</h3>
							<p>Keterangan : {{ $status_kehadiran[0]->keterangan }}</p>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@elseif($status_kehadiran[0]->kehadiran=='A')
						<div class="small-box bg-red">
							<div class="inner">
							<h3>Tanpa Keterangan</h3><br><br>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@else
						<div class="small-box bg-blue">
							<div class="inner">
							<h3>Belum Absen</h3><br><br>
							</div>
							<div class="icon">
							<i class="fa fa-user-clock"></i>
							</div>
						</div>
					@endif
				</div>
			@endif
			</div>
			<!-- /.row -->
	</section>
</div>
@endsection