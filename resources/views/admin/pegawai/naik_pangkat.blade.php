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
						<th style="text-align:center">Golongan Saat Ini</th>
						<th style="text-align:center">TMT Golongan Saat Ini</th>
						<th style="text-align:center">Golongan Selanjutnya</th>
						<th style="text-align:center">TMT Kenaikan pangkat Selanjutnya</th>
					</tr>
					<tr>
						@if(@$naikpangkat[0]->tmt)
							<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
							<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>
							<td style="text-align:center">{{ $naikpangkat[0]->golongan }}</td>
							<td style="text-align:center">{{ date('d-m-Y', strtotime($naikpangkat[0]->tmt)) }}</td>
							<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ $golongan_selanjutnya }}</span></td>
							<td style="text-align:center;font-weight:bold"><span class="label label-success">{{ date('d-m-Y', strtotime($naikpangkat[0]->naikpangkat_berikutnya)) }}</span></td>
						@else
							<td style="text-align:center">{{ $pegawai[0]->nip }}</td>
							<td style="text-align:center">{{ $pegawai[0]->nama_pegawai }}</td>
							<td style="text-align:center"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
							<td style="text-align:center"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
							<td style="text-align:center;font-weight:bold"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
							<td style="text-align:center;font-weight:bold"><span class="label label-danger">Riwayat Pangkat Belum Diisi</span></td>
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