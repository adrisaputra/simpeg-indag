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
			
			<div class="table-responsive box-body">

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th style="text-align:center">NIP</th>
						<th style="text-align:center">Nama Pegawai</th>
						<th style="text-align:center">KGB Terakhir</th>
						<th style="text-align:center">KGB Selanjutnya</th>
					</tr>
					<tr>
						<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
						<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>

						@if(@$gaji[0]->tmt)
							<td style="text-align:center;font-weight:bold">{{ date('d-m-Y', strtotime($gaji[0]->tmt)) }}</td>
						@else
							<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</span></td>
						@endif

						@if(@$kgb[0]->kgb_berikutnya)
							<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ date('d-m-Y', strtotime($kgb[0]->kgb_berikutnya)) }}</span></td>
						@else
							<td style="text-align:center;font-weight:bold"><span class="label label-danger">Belum Mengisi Riwayat Gaji</spam></td>
						@endif
					</tr>
				</table>

			</div>
		<div class="box-footer">
			<!-- PAGINATION -->
		</div>
	</div>
	</section>
</div>
@endsection