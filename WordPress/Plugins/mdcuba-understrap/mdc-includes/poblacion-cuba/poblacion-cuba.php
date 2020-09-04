    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<div id="poblacion_cuba" style="width: 95%;"></div>
    <script type="text/javascript">
      google.charts.load('current', {
        'packages':['geochart'],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        'mapsApiKey': 'AIzaSyDy13oWyZmCnOU4AOO_vX0npHjPM5RIJUI',
		'language': 'es'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {

  var data = google.visualization.arrayToDataTable([
    ['Provincia', 'Población'],
    ['Pinar del Río', 586483],
	['CU-X01', 508491],
    ['CU-X02', 382459],
    ['Ciudad de La Habana', 2129553],
    ['Matanzas', 712418],
    ['Villa Clara', 784244],
    ['Cienfuegos', 407244],
    ['Sancti Spíritus', 465931],
    ['Ciego de Ávila', 435170],
    ['Camagüey', 769863],
	['Las Tunas', 536094],
	['Holguín', 1030024],
	['Granma', 826911],
	['Santiago de Cuba', 1051069],
	['Guantánamo', 511093],
	['Isla de la Juventud', 84013],
	
  ]);

  var options = {
    datalessRegionColor: '#FFFFFF',
    region: 'CU',
    resolution: 'provinces',
    defaultColor: '#ffffff',
    keepAspectRatio: true,
	colorAxis: {colors: ['#FFFFFF', '#00008B'], minValue: 0, maxValue: 2150000}
  };

  var chart = new google.visualization.GeoChart(document.getElementById('poblacion_cuba'));

  chart.draw(data, options);
}
    </script>