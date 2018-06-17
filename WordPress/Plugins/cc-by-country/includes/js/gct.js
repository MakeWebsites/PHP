var $j = jQuery;
 
// Load the Visualization API and the chart package.
google.load("visualization", "1", {packages:["corechart"]});
 
// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawgc);
//google.setOnLoadCallback(drawprec);


 
/*Create our Chart through an Ajax request by passing the build_graph action which will be parsed with the build_gaph function in functions.php*/
 
function drawgc() {
 var c3v = gct.c3; //Passing the c3 variable
 $j.ajax({
 url: gct.ajax_url,
 data: {
 c3: c3v,
 action: "gt" //run build_graph function in functions.php
 },
 dataType: "json",
 beforeSend:function() { 
     },
 complete:function() {
     $j( "#bgc" ).html(""); 
     $j('#cf').html(gct.fc);
 },
 success: function(jsonData) {
    var jdat = JSON.parse(jsonData);
    
    // Create data table out of JSON data loaded from server.
    if (gct.ctemp != false) var ctas = new google.visualization.DataTable(jdat['tas']);
    if (gct.cprec != false)  var cpr = new google.visualization.DataTable(jdat['pr']);
      

      //Chart format and options
      var formatter = new google.visualization.NumberFormat({groupingSymbol: '', pattern: '#', });
      var formatter2 = new google.visualization.NumberFormat({pattern: '#.#'});
      var options = {pointSize: 3, pointShape: 'circle', legend:'none',  
          hAxis: {gridlines : {count : 7}, format: "#", viewWindowMode: "pretty", title: jdat['tity']}, trendlines: { 0: {} }, }
        
        formatter.format(ctas, 0);
        formatter2.format(ctas, 1);
        formatter.format(cpr, 0);
        formatter2.format(cpr, 1);
           
      // Instantiate and draw our chart, passing in some options.
      options.title = jdat['tast'];
      options.vAxis = {title: ' \xB0C', viewWindowMode: "pretty"};
      if (gct.ctemp != 'false' || gct.cprec === 'false') { // Default chart 
      var chart = new google.visualization.ScatterChart(document.getElementById('gctas'));
      chart.draw(ctas, options); }
      options.title = jdat['prt'];
      options.vAxis = {title: 'mm', viewWindowMode: "pretty"};
      if (gct.cprec != 'false') {
      var chart = new google.visualization.ScatterChart(document.getElementById('gcpr'));
      chart.draw(cpr, options); } } } )
    }