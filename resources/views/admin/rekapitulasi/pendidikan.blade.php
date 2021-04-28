@extends('admin.layout')
@section('konten')

<!-- Styles -->
<style>
#chartdiv {
  width: 90%;
  height: 500px;
}


</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_material);
am4core.useTheme(am4themes_animated);
am4core.addLicense("ch-custom-attribution");
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = [ {
  "country": "SD",
  "visits": {{ $pendidikan1 }}
}, {
  "country": "SLTP",
  "visits": {{ $pendidikan2 }}
}, {
  "country": "SLTP Kejuruan",
  "visits": {{ $pendidikan3 }}
}, {
  "country": "SLTA",
  "visits": {{ $pendidikan4 }}
}, {
  "country": "SLTA Kejuruan",
  "visits": {{ $pendidikan5 }}
}, {
  "country": "SLTA Keguruan",
  "visits": {{ $pendidikan6 }}
}, {
  "country": "Diploma I",
  "visits": {{ $pendidikan7 }}
}, {
  "country": "Diploma II",
  "visits": {{ $pendidikan8 }}
}, {
  "country": "Diploma III / Sarjana Muda",
  "visits": {{ $pendidikan9 }}
}, {
  "country": "Diploma IV",
  "visits": {{ $pendidikan10 }}
}, {
  "country": "S1 / Sarjana",
  "visits": {{ $pendidikan11 }}
}, {
  "country": "S2",
  "visits": {{ $pendidikan12 }}
}, {
  "country": "S3 / Doktor",
  "visits": {{ $pendidikan13 }}
}
];

var label = chart.createChild(am4core.Label);
label.x = am4core.percent(50);
label.text = "Jumlah ASN";
label.fontSize = 16;
label.align = "center";
label.isMeasured = false;
label.x = -20;
label.y = 180;
label.rotation = -90;

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.horizontalCenter = "middle";
categoryAxis.renderer.labels.template.verticalCenter = "top";
categoryAxis.renderer.labels.template.rotation = 0;
categoryAxis.tooltip.disabled = true;

var label = categoryAxis.renderer.labels.template;
label.wrap = true;
label.maxWidth = 100;
// categoryAxis.renderer.minHeight = 110;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.renderer.minWidth = 50;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.sequencedInterpolation = true;
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
series.columns.template.strokeWidth = 0;

series.tooltip.pointerOrientation = "vertical";

series.columns.template.column.cornerRadiusTopLeft = 10;
series.columns.template.column.cornerRadiusTopRight = 10;
series.columns.template.column.fillOpacity = 0.8;
// series.columns.template.width = am4core.percent(50);

var labelBullet = series.bullets.push(new am4charts.LabelBullet());
labelBullet.label.verticalCenter = "bottom";
labelBullet.label.dy = -10;
labelBullet.label.text = "{values.valueY.workingValue.formatNumber('#.')}";


// on hover, make corner radiuses bigger
var hoverState = series.columns.template.column.states.create("hover");
hoverState.properties.cornerRadiusTopLeft = 0;
hoverState.properties.cornerRadiusTopRight = 0;
hoverState.properties.fillOpacity = 1;

series.columns.template.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
});

// Cursor
chart.cursor = new am4charts.XYCursor();

}); // end am4core.ready()
</script>

<div class="content-wrapper">
	<section class="content-header">
	<h1 class="fontPoppins">{{ __('JUMLAH PEGAWAI BERDASARKAN PENDIDIKAN') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('JUMLAH PEGAWAI BERDASARKAN PENDIDIKAN') }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
	<center><div id="chartdiv"></div></center>
			<div class="table-responsive box-body">

				@if ($message = Session::get('status'))
					<div class="alert alert-info alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i>Berhasil !</h4>
						{{ $message }}
					</div>
				@endif

				<table class="table table-bordered">
					<tr style="background-color: gray;color:white">
						<th><center>Pendidikan</th>
						<th><center>Jumlah ASN</th>
					</tr>
					<tr>
						<th>SD</th>
						<td><center>{{ $pendidikan1 }}</td>
					</tr>
					<tr>
						<th>SLTP</th>
						<td><center>{{ $pendidikan2 }}</td>
					</tr>
					<tr>
						<th>SLTP Kejuruan</th>
						<td><center>{{ $pendidikan3 }}</td>
					</tr>
					<tr>
						<th>SLTA</th>
						<td><center>{{ $pendidikan4 }}</td>
					</tr>
					<tr>
						<th>SLTA Kejuruan</th>
						<td><center>{{ $pendidikan5 }}</td>
					</tr>
					<tr>
						<th>SLTA Keguruan</th>
						<td><center>{{ $pendidikan6 }}</td>
					</tr>
					<tr>
						<th>Diploma I</th>
						<td><center>{{ $pendidikan7 }}</td>
					</tr>
					<tr>
						<th>Diploma II</th>
						<td><center>{{ $pendidikan8 }}</td>
					</tr>
					<tr>
						<th>Diploma III / Sarjana Muda</th>
						<td><center>{{ $pendidikan9 }}</td>
					</tr>
					<tr>
						<th>Diploma IV</th>
						<td><center>{{ $pendidikan10 }}</td>
					</tr>
					<tr>
						<th>S1 / Sarjana</th>
						<td><center>{{ $pendidikan11 }}</td>
					</tr>
					<tr>
						<th>S2</th>
						<td><center>{{ $pendidikan12 }}</td>
					</tr>
					<tr>
						<th>S3 / Doktor</th>
						<td><center>{{ $pendidikan13 }}</td>
					</tr>
					<tr style="background-color: #00bcd4;color:white">
						<th>Jumlah</th>
						<td><center>{{ $jumlah }}</td>
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