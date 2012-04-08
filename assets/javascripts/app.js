$(document).ready(function () {
  var lastUpdate = null;
  if ($('#chart').length === 0) {
    return;
  }
  var chart = new Highcharts.Chart({
    chart: {
      renderTo: 'chart',
      type: 'areaspline',
      backgroundColor: '#222',
      shadow: true
    },
    title: {
      text: 'Power consumption',
      style: {
        color: '#999',
        fontSize: '14px'
      }
    },
    xAxis: {
      type: 'datetime',
      lineColor: '#101010'
    },
    yAxis: {
      title: {
        text: 'Power / W'
      },
      gridLineColor: '#101010'
    },
    colors: ['#00B4F8'],
    credits: {
      enabled: false
    },
    labels: {
      style: {
        color: '#AAA'
      }
    },
    tooltip: {
      formatter: function () {
        return Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
               Highcharts.numberFormat(this.y, 0) + ' kWh';
      },
      borderWidth: 0,
      backgroundColor: '#101010',
      style: {
        color: '#aaa'
      }
    },
    plotOptions: {
      areaspline: {
        fillOpacity: 0.5,
        fillColor: {
          linearGradient: [0, 0, 0, 300],
          stops: [
            [0, 'rgba(0,180,248,0.6)'],
            [1, 'rgba(0,180,248,0.2)']
          ]
        },
        lineWidth: 4,
        states: {
          hover: {
            lineWidth: 5
          }
        },
        marker: {
          enabled: false,
          states: {
            hover: {
              enabled: true,
              symbol: 'circle',
              radius: 5,
              lineWidth: 1
            }
          }
        },
        pointInterval: 3600000, // one hour
        pointStart: Date.UTC(2009, 9, 6, 0, 0, 0)
      }
    },
    legend: {
      enabled: false
    },
    series: [{
      name: 'Consumption',
      data: []
    }]
  });

  var addPoints = function (r) {
    if (!(r instanceof Array)) {
      return;
    }
    var data = [];
    var isEmpty = chart.series[0].data.length === 0;
    for (var i = 0, len = r.length; i < len; i++) {
      var item = r[i];
      var point = [(new Date(item.created_at)).getTime(), +item.consumption];
      isEmpty ? data.push(point) : chart.series[0].addPoint(point, false);
    }
    isEmpty ? chart.series[0].setData(data) : chart.redraw();
  };

  var handleUpdate = function (r) {
    addPoints(r.response);
    if ((r.response instanceof Array) && r.response.length > 0) {
      lastUpdate = (new Date()).getTime();
    }
    setTimeout(fetch, 5000);
  };

  var fetch = function () {
    var params = {
      key: window.userKey
    };
    if (lastUpdate !== null) {
      params.from = lastUpdate;
    }
    // Fetch data
    $.ajax({
      type: 'GET',
      url: 'api/observations',
      data: params,
      success: handleUpdate
    });
  };

  fetch();
});