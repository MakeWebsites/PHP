<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LIFE-N - Fundamentos</title>
<link href="style/style2.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
include ('encabez2.inc.php');
?>

<h2>Fundamentación de la modelización</h2>
<p class="heading">La modelizaci&oacute;n combina simulaciones 1D de la zona no saturada del suelo, empleando el <a href="http://www.swap.alterra.nl/" title="Utilizamos el modelo SWAP" target="_blank">modelo agro-hidrológico SWAP</a>, con simulaciones 3D del movimiento del agua y solutos en la zona saturada, utilizando el modelo hidrológico
  ModFlow. Este procedimiento combinado es de gran actualidad y se ha aplicado con &eacute;xito por el <a href="http://www.nhi.nu/nhi_uk.html" title="En Holanda se emplea este mismo procedimiento" target="_blank">Servicio Hidrológico de Holanda</a>, así como en China y otros lugares. </p>
<p class="heading">La novedad de nuestra aplicaci&oacute;n para el proyecto LIFE NITRATOS consiste en utilizar los datos de cultivos recogidos en el SIGPAC y establecer como unidad de simulaci&oacute;n las parcelas agr&iacute;colas. La aplicaci&oacute;n mostrada en este sitio se refiere a la simulaci&oacute;n 1D con SWAP</p>
<img src="images/procedimiento-LIFE.png" width="1200" height="300" alt="Simulacion combinada de la ZNS y la ZS" title="Simulacion combinada de la ZNS y la ZS" />

<p class="heading">Las par&aacute;metros de Van Genuchten de las propiedades hidr&aacute;ulicas del suelo, necesarias para el modelo SWAP, se obtuvieron por funciones de Pedotransferencia a partir de más de 900 mediciones y pruebas de suelos recopiladas por toda la zona experimental, así como de nuevas mediciones realizadas en los sitios con poca densidad de mediciones.</p>


<img class="imizq" width="800" src="images/procedimiento-suelos.png" alt="Procedimiento para obtener las propiedades hidraulicas del suelo" />

<p class="heading">A cada parcela se le asignan los par&aacute;metros de las propiedades hidráulicas más cercanos, así como las variables meteorol&oacute;gicas diarias medidas en la estación más pr&oacute;xima a la parcela, entre 12 estaciones disponibles.</p>

<!--<img class="imder" width="100" src="images/php-MySQL.jpg" alt="Utilizamos PHP y MySQL" />
-->
<h3><strong>Esta aplicaci&oacute;n ha sido escrita en PHP, utilizando bases de datos MySQL</strong></h3>

<p class="heading"> La aplicaci&oacute;n lee los datos de cultivo en cada parcela y las propiedades hidr&aacute;ulicas y variables meteorol&oacute;gicas asociadas a ella. </p>
<p class="heading">Se considera un manejo de riego y fertilizantes para cada cultivo, la aplicación escribe los ficheros de entrada para el modelo SWAP, corre el modelo y lee los resultados de las simulaciones para cada parcela, lo cual incluye la percolación profunda (por debajo de 140 cm) y otros t&eacute;rminos del balance h&iacute;drico. </p>
<p class="heading">Con las percolaciones simuladas calcula la lixivicación de nitratos, aportada al acu&iacute;cufero por cada parcela, a partir de un balance de nitr&oacute;geno.</p>
</body>
</html>
