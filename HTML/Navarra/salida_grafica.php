<?php 

function grafico ($preg, $numresp) { ?>
<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		<?php
		$cant = count($preg);
		$i = 1;
		while ($i < $cant) {
		echo "[".$preg[$i]."', ".$numresp[$i]."],"; 
		$i++; }
		$i = $cant;
		echo echo "[".$preg[$i]."', ".$numresp[$i]."]"; ?>
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart_3d" style="width: 900px; height: 500px;"></div>
  </body>
</html>

<?php } 
SELECT AVG(  `anual` ) as percm_anual , p2012.cultivo
FROM  `perc2`
INNER JOIN p2012 ON perc2.idp = p2012.idp
WHERE p2012.riego =  'Gravedad' 
GROUP BY p2012.cultivo
ORDER BY AVG(  `anual` ) DESC 
HAVING count(distinct p2012.cultivo) > 300

$year = 2012;
$dn = new mysqli("localhost", "root", "", "navarra_general");
$dny = new mysqli("localhost", "root", "", "navarra_".strval($year));
$py = 'perc'.substr(strval($year),-2);

$dperc = $dny->query("SELECT * FROM  `perc2` INNER JOIN p2012 ON perc.idp = p2012.idp GROUP BY p2012.cultivo ");
?>