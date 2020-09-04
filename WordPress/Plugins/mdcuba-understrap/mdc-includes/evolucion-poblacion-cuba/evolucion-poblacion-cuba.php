    
	<div id="chart_div" style="width: 100%;"></div>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart', 'scatter'], 'language': 'es'});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var button = document.getElementById('change-chart');
        var chartDiv = document.getElementById('chart_div');

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Año');
        data.addColumn('number', 'Poblacion');
        data.addColumn('number', '% mayores de 65');

        data.addRows([
[1970,8712541,5.849],
[1971,8868083,6.061],
[1972,9025345,6.234],
[1973,9178804,6.385],
[1974,9320945,6.547],
[1975,9446442,6.735],
[1976,9554188,6.925],
[1977,9646142,7.143],
[1978,9724044,7.378],
[1979,9790851,7.602],
[1980,9849459,7.801],
[1981,9898889,8.024],
[1982,9940317,8.204],
[1983,9981304,8.354],
[1984,10031649,8.5],
[1985,10097911,8.652],
[1986,10183899,8.713],
[1987,10286643,8.779],
[1988,10397511,8.849],
[1989,10503972,8.917],
[1990,10596987,8.988],
[1991,10673542,9.054],
[1992,10736387,9.137],
[1993,10789306,9.225],
[1994,10838462,9.303],
[1995,10888252,9.367],
[1996,10939293,9.482],
[1997,10989732,9.565],
[1998,11038692,9.636],
[1999,11084670,9.726],
[2000,11126430,9.85],
[2001,11164667,9.999],
[2002,11199651,10.18],
[2003,11229183,10.39],
[2004,11250365,10.62],
[2005,11261582,10.86],
[2006,11261248,11.18],
[2007,11251122,11.51],
[2008,11236971,11.85],
[2009,11226709,12.19],
[2010,11225832,12.54],
[2011,11236670,12.83],
[2012,11257101,13.12],
[2013,11282720,13.4],
[2014,11306902,13.7],
[2015,11324781,14.04],
[2016,11335109,14.38],
[2017,11339259,14.77],
[2018,11338138,15.18]
        ]);

        var materialOptions = {
          chart: {
            title: 'Población y % mayores de 65 años',
            //subtitle: 'Datos hasta 2018'
          },
          height: 400,
		  hAxis: {format: "#"},
		  legend: { position: 'none' },
		  
          series: {
            0: {axis: 'Población'},
            1: {axis: '% mayores 65'}
          },
		  
          axes: {
            y: {
              'Poblacion': {label: 'Población (Millones de habitantes)'},
              '% mayores 65': {label: 'Mayores de 65 años (%)'}
            }
          }
        };

        function drawMaterialChart() {
          var materialChart = new google.charts.Scatter(chartDiv);
          materialChart.draw(data, google.charts.Scatter.convertOptions(materialOptions));
        }

        drawMaterialChart();
    };
    </script>