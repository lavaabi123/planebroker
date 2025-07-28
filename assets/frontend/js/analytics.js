$(function () {
    'use strict';

    var ctx_live = document.getElementById("visitors-chart");
    var ctx = document.getElementById("appears-chart");
    var ctx_form = document.getElementById("form-chart");
	var ctxpeople = document.getElementById("called-chart");
    // Shared base options for both charts
    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: { left: 20, right: 20, top: 10, bottom: 10 }
        },
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
                onClick: null,
                labels: {
                    boxWidth: 12,
                    padding: 15
                }
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    title: function () {
                        return '';
                    }
                }
            }
        },
        hover: {
            mode: 'index',
            intersect: true
        },
        scales: {
            x: {
                grid: {
                    display: true,
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    beginAtZero: true,
                    font: { size: 12 },
                    color: '#666'
                }
            },
            y: {
                beginAtZero: true,
                suggestedMax: 10,
                grid: {
                    display: true,
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    stepSize: 5,
                    font: { size: 12 },
                    color: '#666',
                    padding: 5
                }
            }
        }
    };

    // Initialize line chart (Profile Viewed)
    var myChart = new Chart(ctx_live, {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: baseOptions
    });
    var myChartform = new Chart(ctx_form, {
        type: 'line',
        data: {
            labels: [],
            datasets: []
        },
        options: baseOptions
    });

    // Initialize bar chart (Favorites)
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
        },
        options: Chart.helpers.merge(baseOptions, {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 2,
                    ticks: {
                        stepSize: 1,
                        padding: 5
                    }
                },
                x: {
                    ticks: {
                        padding: 5
                    }
                }
            }
        })
    });

    // Initialize bar chart (Favorites)
    var myBarChartpeople = new Chart(ctxpeople, {
        type: 'bar',
        data: {
            labels: [],
            datasets: []
        },
        options: Chart.helpers.merge(baseOptions, {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 2,
                    ticks: {
                        stepSize: 1,
                        padding: 5
                    }
                },
                x: {
                    ticks: {
                        padding: 5
                    }
                }
            }
        })
    });
    function makeBarChart(source) {
        myBarChart.data.labels = [];
        myBarChart.data.datasets = [];

        var cData = JSON.parse(source);
        for (var i = 0; i < cData.impression.day.length; i++) {
            myBarChart.data.labels.push(cData.impression.day[i]);
        }

        const sessionsData1 = {
            type: 'bar',
            label: 'Favorites',
            data: cData.impression.user,
            backgroundColor: 'rgba(0, 123, 255, 0.6)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1,
            barPercentage: 0.9,
            categoryPercentage: 0.8,
			barThickness: 20, // ✅ THIS controls the width
            maxBarThickness: 20
        };

        myBarChart.data.datasets.push(sessionsData1);
        myBarChart.update();
    }

    function makeBarChartpeople(source) {
        myBarChartpeople.data.labels = [];
        myBarChartpeople.data.datasets = [];

        var cData = JSON.parse(source);
        for (var i = 0; i < cData.called.day.length; i++) {
            myBarChartpeople.data.labels.push(cData.called.day[i]);
        }

        const sessionsData1 = {
            type: 'bar',
            label: 'People Called',
            data: cData.called.user,
            backgroundColor: 'rgba(0, 123, 255, 0.6)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1,
            barPercentage: 0.9,
            categoryPercentage: 0.8,
			barThickness: 20, // ✅ THIS controls the width
            maxBarThickness: 20
        };

        myBarChartpeople.data.datasets.push(sessionsData1);
        myBarChartpeople.update();
    }
    function makeDrawChart(source) {
        myChart.data.labels = [];
        myChart.data.datasets = [];

        var cData = JSON.parse(source);
        const users = cData.latest.user;
        let userSessions = 0;

        for (var i = 0; i < cData.latest.day.length; i++) {
            userSessions += users[i];
            myChart.data.labels.push(cData.latest.day[i]);
        }

        let totalUsers = typeof (cData.latest.user) != 'undefined' ? cData.latest.user : [];
        var totalRegistrations = totalUsers.reduce(function (acc, val) {
            return acc + val;
        }, 0);
        $('#total_registrations').html(totalRegistrations);

        $('#totalAmountPaid').html(cData.totalAmountPaid ? '$ ' + cData.totalAmountPaid : '&nbsp;');
        $('#totalStandard').html(cData.totalStandard || '&nbsp;');
        $('#totalPremium').html(cData.totalPremium || '&nbsp;');
        $('#dataforperiod').html(cData.dataforperiod);

        const sessionsData = {
            type: 'line',
            label: 'Views',
            data: cData.latest.user,
            backgroundColor: 'rgba(248, 159, 29, 0.2)',
            borderColor: '#f89f1d',
            pointBorderColor: '#f89f1d',
            pointBackgroundColor: '#f89f1d',
            fill: true,
            tension: 0.4
        };

        myChart.data.datasets.push(sessionsData);
        myChart.update();

        $("#ga-visitors").text(userSessions);
    }

    function makeDrawChartform(source) {
        myChartform.data.labels = [];
        myChartform.data.datasets = [];

        var cData = JSON.parse(source);
        const users = cData.form_submission.user;
        let userSessions = 0;

        for (var i = 0; i < cData.form_submission.day.length; i++) {
            userSessions += users[i];
            myChartform.data.labels.push(cData.form_submission.day[i]);
        }

        let totalUsers = typeof (cData.form_submission.user) != 'undefined' ? cData.form_submission.user : [];
        var totalRegistrations = totalUsers.reduce(function (acc, val) {
            return acc + val;
        }, 0);
        $('#total_registrations').html(totalRegistrations);

        $('#totalAmountPaid').html(cData.totalAmountPaid ? '$ ' + cData.totalAmountPaid : '&nbsp;');
        $('#totalStandard').html(cData.totalStandard || '&nbsp;');
        $('#totalPremium').html(cData.totalPremium || '&nbsp;');
        $('#dataforperiod').html(cData.dataforperiod);

        const sessionsData = {
            type: 'line',
            label: 'Form Submissions',
            data: cData.form_submission.user,
            backgroundColor: 'rgba(248, 159, 29, 0.2)',
            borderColor: '#f89f1d',
            pointBorderColor: '#f89f1d',
            pointBackgroundColor: '#f89f1d',
            fill: true,
            tension: 0.4
        };

        myChartform.data.datasets.push(sessionsData);
        myChartform.update();

        //$("#ga-visitors").text(userSessions);
    }
    // Fetch data via AJAX
    var sdate = $('#created_at_start').val();
    var edate = $('#created_at_end').val();
    var id = $('#user_id_admin').val();
    var product_id = $('#product_id').val();

    $.get(`${baseUrl}/common/getProfileViews?${id}start=${sdate}&end=${edate}&product_id=${product_id}`, function (data) {
        makeDrawChart(data);
        makeBarChart(data);
		makeDrawChartform(data);
        makeBarChartpeople(data);
    }).done(function () {
        $("#loading-data").hide();
    });

});
