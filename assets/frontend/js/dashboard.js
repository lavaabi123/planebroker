$(function () {
    'use strict'

    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')

    var donutData = {
        labels: [],
        datasets: []
    }

    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true,
            position: 'bottom',
            onClick: null
        }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: {
            labels: ['data'],
            datasets: [{
                data: [1],
                backgroundColor: ['#f56954', '#00a65a', '#f39c12'],borderDash: []
            }]
        },
        options: donutOptions
    })



    var ctx_live = document.getElementById("visitors-chart");
	var ctx = document.getElementById("appears-chart");

    const option = {
        responsive: true,
        maintainAspectRatio: false,
        tooltips: {
            mode: 'index',
            intersect: true,
            callbacks: {
                title: function (tooltipItems, data) {
                    return '';
                }
            }

        },
        hover: {
            mode: 'index',
            intersect: true
        },

        legend: {
            display: true,
            position: 'bottom',onClick: null
        },
        scales: {
            yAxes: [{
                gridLines: {
                    display: true,
                },
                ticks:{
                    beginAtZero: true,  stepSize: 1,  suggestedMax:10, 
                }
            }],
            xAxes: [{
                display: true,
                gridLines: {
                    display: true,
                },
                ticks: {
					beginAtZero: true,  stepSize: 1,  suggestedMax:10,  
                }
            }]
        }
    }

    var myChart = new Chart(ctx_live, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{borderDash: []}]
        },
        options: option
    });
	
	var myBarChart = new Chart(ctx, {
		type: 'bar',
		data: {
		},
		options: {
			scales: {
				xAxes: [{
                    stepSize: 1,
					gridLines: {
						display: false,
						tickMarkLength: 10
					},
					ticks:{						
						beginAtZero: true,  stepSize: 1,  suggestedMax:10,   
					},barThickness: 20
				}],
				yAxes: [{
					grace: '5%',
                    stepSize: 1,
					ticks:{						
						beginAtZero: true, 
						  suggestedMax:10
					}
				}]
			},
    legend: {
        position: 'bottom',
        onClick: null // Disable clicking on legend to toggle datasets
    }
		}
	});

    function makeBarChart(source) {
        // create initial empty chart
        //myBarChart.data.labels.splice(0, myBarChart.data.labels.length);
        //myBarChart.data.datasets = [];
        //myBarChart.update();
        var cData = JSON.parse(source);
        for (var i = 0; i < cData.impression.day.length; i++) {
            myBarChart.data.labels.push(cData.impression.day[i]);
        }		
        const sessionsData1 = {
            type: 'bar',
            label: 'Impressions',
            data: cData.impression.user,
			barThickness: 40,
			maxBarThickness: 40,
			backgroundColor:'#04bccd',
			barPercentage: 0.9,
			categoryPercentage: 1,borderDash: []
        };
        myBarChart.data.datasets.push(sessionsData1);
        myBarChart.update();

    }
    function makeDrawChart(source) {
        // create initial empty chart
        myChart.data.labels.splice(0, myChart.data.labels.length);
        myChart.data.datasets = [];
        myChart.update();

        var cData = JSON.parse(source);
        const users = cData.latest.user;
        let userSessions = 0;

        for (var i = 0; i < cData.latest.day.length; i++) {
            userSessions += users[i];
            myChart.data.labels.push(cData.latest.day[i]);
        }

        let totalUsers = typeof(cData.latest.user != 'undefined') ? cData.latest.user : [];
        var totalRegistrations = totalUsers.reduce(function (accumulator, currentValue) {
          return accumulator + currentValue;
        }, 0);
        $('#total_registrations').html(totalRegistrations);

        let totalAmountPaid = typeof(cData.totalAmountPaid != 'undefined') ? '$ ' + cData.totalAmountPaid : '&nbsp';
        $('#totalAmountPaid').html(totalAmountPaid);
		
		let totalStandard = typeof(cData.totalStandard != 'undefined') ? cData.totalStandard : '&nbsp';
        $('#totalStandard').html(totalStandard);
		
		let totalPremium = typeof(cData.totalPremium != 'undefined') ? cData.totalPremium : '&nbsp';
        $('#totalPremium').html(totalPremium);

        $('#dataforperiod').html(cData.dataforperiod)

        const sessionsData = {
            type: 'line',
            label: 'Views',
            data: cData.latest.user,
            backgroundColor: 'transparent',
            borderColor: '#a512e5',
            pointBorderColor: '#a512e5',
            pointBackgroundColor: '#a512e5',
            fill: false,borderDash: []
        };



        myChart.data.datasets.push(sessionsData);

        myChart.update();
        $("#ga-visitors").text(userSessions);

    }

    function makeDonutChart(source) {

        donutChart.data.labels.splice(0, donutChart.data.labels.length);
        donutChart.data.datasets = [];
        donutChart.update();

        // create initial empty chart
        var cData = JSON.parse(source);
        const type = cData.user_type.type;
        let num = 0;

        for (var i = 0; i < cData.user_type.type.length; i++) {
            num += type[i];
            donutChart.data.labels.push(cData.user_type.type[i]);
        }

        const newData = {
            data: cData.user_type.user,
            backgroundColor: ['#845adf', '#26bf94', '#f5b849', '#23b7e5','#f55f49'],borderDash: []
        };

        donutChart.data.datasets.push(newData);
        donutChart.update();
    }

    $('.daterange').daterangepicker({
        ranges: {
            Today: [moment(), moment()],
            Yesterday: [moment().subtract(1, 'days'), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 28 Days': [moment().subtract(28, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate: moment().subtract(29, 'days')
    }, function (start, end) {


        var data = {
            'startDate': start.format('MMMM D, YYYY'),
            'endDate': end.format('MMMM D, YYYY'),
        };

        data[csrfName] = $.cookie(csrfCookie);

        $.ajax({
            url: $('.daterange').attr('data-input-url'),
            type: 'post',
            data: data,
            beforeSend: function () {
                $("#loading-data").show();
            },
            complete: function () {
                $("#loading-data").hide();

            },
            success: function (response) {
                makeDrawChart(response);
                makeDonutChart(response)
            }
        });
    })
	
	var sdate = $('#created_at_start').val();
	var edate = $('#created_at_end').val();
	var id = $('#user_id_admin').val();
	console.log(id);
    $.get(baseUrl + "/common/getProfileViews?"+id+"start="+sdate+"&end="+edate+"", function (data, status) {
        makeDrawChart(data)
		makeBarChart(data)
        makeDonutChart(data)
    }).done(function () {
        $("#loading-data").hide();
    });

});