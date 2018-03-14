    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: gcmv.fd,
          dataType: "json",
          }).done(function(jsonData) {
          
             
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      
      //Eliminate separator for years
      var formatter = new google.visualization.NumberFormat({
        groupingSymbol: '',
        pattern: '#',
        });
        formatter.format(data, 0);
        
       var formatter2 = new google.visualization.NumberFormat({
        pattern: '#.#'
        });
        formatter2.format(data, 1);
           
      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ScatterChart(document.getElementById(gcmv.dmv));
      chart.draw(data, {pointSize: 3,
          pointShape: 'circle', legend:'none', 
          vAxis: {
          title: gcmv.mtitle, 
          viewWindowMode: "pretty",
                 }, 
          hAxis: {
              gridlines : {
                count : 12
                },
                 format: "#",
                 viewWindowMode: "pretty",
                 //minValue:1900,
                 //maxValue:2020,
                title: gcmv.xtitle},
            trendlines: { 0: {} },
            }
                );
		  })
    }
    
    
