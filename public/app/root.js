anychart.onDocumentReady(function() {
    // The data used in this sample can be obtained from the CDN
    // https://cdn.anychart.com/csv-data/csco-daily.csv
    $.ajax({
        url:site_url+"/chart-data/getChartData",
        type:"GET",
        data:{
            test:"Hallo"
        },
        dataType:"json",
        success:function(response){
            anychart.data.loadJsonFile('http://localhost:8000/files/tradingData.json', function(data) {
            // create data table on loaded data
            var dataTable = anychart.data.table();
            dataTable.addData(data);

            // map loaded data for the ohlc series
            var mapping = dataTable.mapAs({
                'open': 1,
                'high': 2,
                'low': 3,
                'close': 4
            });

            // map loaded data for the scroller
            var scrollerMapping = dataTable.mapAs();
            scrollerMapping.addField('value', 5);

            // create stock chart
            var chart = anychart.stock();

            // create first plot on the chart
            var plot = chart.plot(0);
            // set grid settings
            plot.yGrid(true)
                .xGrid(true)
                .yMinorGrid(true)
                .xMinorGrid(true);

            // create EMA indicators with period 50
            plot.ema(dataTable.mapAs({
                'value': 4
            })).series().stroke('1.5 #455a64');

            var series = plot.candlestick(mapping);
            series.name('EURAUD');
            series.legendItem().iconType('rising-falling');

            // create scroller series with mapped data
            chart.scroller().candlestick(mapping);

            // set chart selected date/time range
            chart.selectRange('2018-08-01 00:00', '2018-08-17 16:58:00');

            // set container id for the chart
            chart.container('candlestickchart');
            // initiate chart drawing
            chart.draw();

            // load all saved annotations
            var annotations = function(){
                $.ajax({
                    url:site_url+"/chart-data/getTrendLines",
                    type:"GET",
                    async:false,
                    data:{
                        test:"Hallo"
                    },
                    dataType:"json",
                    success:function(response){
                        //console.log(data);
                        chart.plot().annotations().fromJson(response);
                        //disable interactivity for the Ellipse annotation
                        var count = plot.annotations().getAnnotationsCount();
                        for(let i = 0; i < count; i++){
                            plot.annotations().getAnnotationAt(i).allowEdit(false);
                        }
                    }
                });
            };

            annotations();

            // create range picker
            var rangePicker = anychart.ui.rangePicker();
            // init range picker
            rangePicker.render(chart);

            // create range selector
            var rangeSelector = anychart.ui.rangeSelector();
            // init range selector
            rangeSelector.render(chart);

            });
        }
    });
  });

