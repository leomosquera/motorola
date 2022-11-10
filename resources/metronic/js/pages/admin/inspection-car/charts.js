'use strict';

// Shared Colors Definition
const primary = '#6993FF';
const success = '#1BC5BD';
const info = '#8950FC';
const warning = '#FFA800';
const danger = '#F64E60';

// Class definition
function generateBubbleData(baseval, count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
      var x = Math.floor(Math.random() * (750 - 1 + 1)) + 1;;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
      var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;

      series.push([x, y, z]);
      baseval += 86400000;
      i++;
    }
    return series;
}

function generateData(count, yrange) {
    var i = 0;
    var series = [];
    while (i < count) {
        var x = 'w' + (i + 1).toString();
        var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

        series.push({
            x: x,
            y: y
        });
        i++;
    }
    return series;
}

var KTApexChartsDemo = function () {
	// Private functions
	var _demo1 = function () {
        var obj = $('#chart_1');

        $.ajax({
            type: 'POST',
            headers: MyHeaderAjax.csrf(),
            url:  obj.attr('data-route'),
            data: {
                info : obj.attr('data-info')
            },
            error: function( msg ){
                //alert( JSON.stringify(msg) );
                requestError = true;
                completeLoad.requestComplete(true);
            },
            success: function( msg ) {
                //alert( JSON.stringify(msg) );
                if( msg.response == 'error' ){
                    //requestError = true;
                }else{
                    var options = {
                        series: [{
                            name: "Inspecciones",
                            data: msg.data.data
                        }],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'straight'
                        },
                        grid: {
                            row: {
                                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                opacity: 0.5
                            },
                        },
                        xaxis: {
                            categories: msg.data.categories,
                        },
                        colors: [primary]
                    };

                    var chart = new ApexCharts(document.querySelector('#'+obj.attr('id')), options);
                    chart.render();
                }
                //completeLoad.requestComplete(true);
            }
        });
	}

	var _demo2 = function () {
        var obj = $('#chart_2');

        $.ajax({
            type: 'POST',
            headers: MyHeaderAjax.csrf(),
            url:  obj.attr('data-route'),
            data: {
                info : obj.attr('data-info')
            },
            error: function( msg ){
                //alert( JSON.stringify(msg) );
                requestError = true;
                completeLoad.requestComplete(true);
            },
            success: function( msg ) {
                //alert( JSON.stringify(msg) );
                if( msg.response == 'error' ){
                    //requestError = true;
                }else{
                    var options = {
                        series: [{
                            name: msg.data.month1,
                            data: msg.data.data1
                        }, {
                            name: msg.data.month2,
                            data: msg.data.data2
                        }],
                        chart: {
                            height: 350,
                            type: 'area'
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            curve: 'smooth'
                        },
                        xaxis: {
                            type: 'days',
                            categories: msg.data.data3
                        },
                        tooltip: {
                            x: {
                                formatter: function (val) {
                                    return 'Días ' + val
                                }
                            },
                        },
                        colors: [primary, success]
                    };

                    var chart = new ApexCharts(document.querySelector('#'+obj.attr('id')), options);
                    chart.render();
                }
                //completeLoad.requestComplete(true);
            }
        });

	}

	var _demo3 = function () {

        var obj = $('#chart_3');

        $.ajax({
            type: 'POST',
            headers: MyHeaderAjax.csrf(),
            url:  obj.attr('data-route'),
            data: {
                info : obj.attr('data-info')
            },
            error: function( msg ){
                //alert( JSON.stringify(msg) );
                requestError = true;
                completeLoad.requestComplete(true);
            },
            success: function( msg ) {
                //alert( JSON.stringify(msg) );
                if( msg.response == 'error' ){
                    //requestError = true;
                }else{
                    var options = {
                        series: [{
                            name: 'Automóviles',
                            data: msg.data.data1
                        }, {
                            name: 'Embarcaciones',
                            data: msg.data.data2
                        }, {
                            name: 'Siniestros',
                            data: msg.data.data3
                        }],
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '55%',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 2,
                            colors: ['transparent']
                        },
                        xaxis: {
                            categories: msg.data.categories,
                        },
                        yaxis: {
                            title: {
                                text: 'Inspecciones por mes'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val + " inspecciones"
                                }
                            }
                        },
                        colors: [primary, success, warning]
                    };

                    var chart = new ApexCharts(document.querySelector('#'+obj.attr('id')), options);
                    chart.render();
                }
                //completeLoad.requestComplete(true);
            }
        });
	}

	return {
		// public functions
		init: function () {
			_demo1();
			_demo2();
			_demo3();
		}
	};
}();

jQuery(document).ready(function () {
	KTApexChartsDemo.init();
});
