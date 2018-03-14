    // Load the Visualization API and the piechart package.
    google.charts.load('current', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: gccv.fd,
          dataType: "json",
          }).done(function(jsonData) {
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById(gccv.dmv));
      chart.draw(data, { bar: {groupWidth: '25'},
          vAxis: {
          title: gccv.mtitle,
        },
        hAxis: {
          title: gccv.xtitle
        }});
		  })
    }