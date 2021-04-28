@extends('admin.layout')
@section('konten')

<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end



var chart = am4core.create('chartdiv', am4charts.XYChart)
chart.colors.step = 2;

chart.legend = new am4charts.Legend()
chart.legend.position = 'top'
chart.legend.paddingBottom = 20
chart.legend.labels.template.maxWidth = 95

var xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
xAxis.dataFields.category = 'category'
xAxis.renderer.cellStartLocation = 0.1
xAxis.renderer.cellEndLocation = 0.9
xAxis.renderer.grid.template.location = 0;

var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
yAxis.min = 0;

function createSeries(value, name) {
    var series = chart.series.push(new am4charts.ColumnSeries())
    series.dataFields.valueY = value
    series.dataFields.categoryX = 'category'
    series.name = name

    series.events.on("hidden", arrangeColumns);
    series.events.on("shown", arrangeColumns);


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

    return series;
}

// chart.data = [
//     {
//         category: 'Place #1',
//         first: 40,
//         second: 55,
//     },
//     {
//         category: 'Place #2',
//         first: 30,
//         second: 78,
//         third: 69
//     },
//     {
//         category: 'Place #3',
//         first: 27,
//         second: 40,
//     },
//     {
//         category: 'Place #4',
//         first: 50,
//         second: 33,
//     }
// ]

// Add data
chart.data = [ 
@foreach($jabatan as $v)
	{
        category: '{{ $v->nama_jabatan }}',
        Pria: {{ $pria[$loop->index + 1] }},
        Wanita: {{ $wanita[$loop->index + 1] }},
    },
@endforeach
];


createSeries('Pria', 'Pria');
createSeries('Wanita', 'Wanita');

function arrangeColumns() {

    var series = chart.series.getIndex(0);

    var w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
    if (series.dataItems.length > 1) {
        var x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
        var x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
        var delta = ((x1 - x0) / chart.series.length) * w;
        if (am4core.isNumber(delta)) {
            var middle = chart.series.length / 2;

            var newIndex = 0;
            chart.series.each(function(series) {
                if (!series.isHidden && !series.isHiding) {
                    series.dummyData = newIndex;
                    newIndex++;
                }
                else {
                    series.dummyData = chart.series.indexOf(series);
                }
            })
            var visibleCount = newIndex;
            var newMiddle = visibleCount / 2;

            chart.series.each(function(series) {
                var trueIndex = chart.series.indexOf(series);
                var newIndex = series.dummyData;

                var dx = (newIndex - trueIndex + middle - newMiddle) * delta

                series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
                series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
            })
        }
    }
}


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
	<h1 class="fontPoppins">{{ __('GENDER PER BIDANG') }}
	</h1>
	<ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> DASHBOARD</a></li>
		<li><a href="#"> {{ __('GENDER PER BIDANG') }}</a></li>
	</ol>
	</section>
	
	<section class="content">
	<div class="box">   
	<div id="chartdiv"></div>
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
						<th style="width: 60px"><center>No</th>
						<th><center>Jabatan</th>
						<th><center>Pria</th>
						<th><center>Wanita</th>
						<th><center>Jumlah</th>
					</tr>
					@php 
						$i=0;
						$j=0; 
						$k=0; 
					@endphp
					@foreach($jabatan as $v)
					@php
						$i = $i +  $pria[$loop->index + 1];
						$j = $j +  $wanita[$loop->index + 1];
						$k = $k +  $jumlah[$loop->index + 1];
					@endphp
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>{{ $v->nama_jabatan }}</td>
						<td><center>{{ $pria[$loop->index + 1] }}</center></td>
						<td><center>{{ $wanita[$loop->index + 1] }}</center></td>
						<td><center>{{ $jumlah[$loop->index + 1] }}</center></td>
					</tr>
					@endforeach
					<tr style="background-color: #00bcd4;color:white">
						<th colspan=2>Total Pegawai</th>
						<td><center>{{ $i }}</center></td>
						<td><center>{{ $j }}</center></td>
						<td><center>{{ $k }}</center></td>
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