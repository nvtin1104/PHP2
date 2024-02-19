'use strict';

/* Chart.js docs: https://www.chartjs.org/ */

window.chartColors = {
	green: '#75c181',
	gray: '#a9b5c9',
	text: '#252930',
	border: '#e7e9ed'
};

/* Random number generator for demo purpose */
var randomDataPoint = function () { return Math.round(Math.random() * 10000) };


//Chart.js Line Chart Example 



// Chart.js Bar Chart Example 



$(document).ready(async function () {
	let route = $('#root-route').data('route');

	const fetchData = async () => {
		try {
			const response = await fetch(route + '/admin/dashboard/chart');
			if (!response.ok) {
				throw new Error('Network response was not ok');
			}
			return await response.json();
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	};
	const dataResponse = await fetchData();
	let barchatData = dataResponse.dataBarchart;
	let linechartData = dataResponse.dataLinechart;
	console.log(linechartData);
	var barChartConfig = {
		type: 'bar',

		data: {
			labels: barchatData.week,
			datasets: [{
				label: 'Đơn hàng',
				backgroundColor: window.chartColors.green,
				borderColor: window.chartColors.green,
				borderWidth: 1,
				maxBarThickness: 16,
				data: barchatData.orderInWeek
			}]
		},
		options: {
			responsive: true,
			aspectRatio: 1.5,
			legend: {
				position: 'bottom',
				align: 'end',
			},
			title: {
				display: true,
				text: 'Thống kê đơn hàng 7 ngày'
			},
			tooltips: {
				mode: 'index',
				intersect: false,
				titleMarginBottom: 10,
				bodySpacing: 10,
				xPadding: 16,
				yPadding: 16,
				borderColor: window.chartColors.border,
				borderWidth: 1,
				backgroundColor: '#fff',
				bodyFontColor: window.chartColors.text,
				titleFontColor: window.chartColors.text,

			},
			scales: {
				xAxes: [{
					display: true,
					gridLines: {
						drawBorder: false,
						color: window.chartColors.border,
					},

				}],
				yAxes: [{
					display: true,
					gridLines: {
						drawBorder: false,
						color: window.chartColors.borders,
					},


				}]
			}

		}
	}
	var lineChartConfig = {
		type: 'line',
	
		data: {
			labels: linechartData.week,
	
			datasets: [{
				label: 'Doanh thu thật',
				fill: false,
				backgroundColor: window.chartColors.green,
				borderColor: window.chartColors.green,
				data: linechartData.revenueRealInWeek,
			}, {
				label: 'Doanh thu ước lượng',
				borderDash: [3, 5],
				backgroundColor: window.chartColors.gray,
				borderColor: window.chartColors.gray,
	
				data: linechartData.revenueInWeek,
				fill: false,
			}]
		},
		options: {
			responsive: true,
			aspectRatio: 1.5,
	
			legend: {
				display: true,
				position: 'bottom',
				align: 'end',
			},
	
			title: {
				display: true,
				text: 'Thống kê doanh thu 7 ngày',
	
			},
			tooltips: {
				mode: 'index',
				intersect: false,
				titleMarginBottom: 10,
				bodySpacing: 10,
				xPadding: 16,
				yPadding: 16,
				borderColor: window.chartColors.border,
				borderWidth: 1,
				backgroundColor: '#fff',
				bodyFontColor: window.chartColors.text,
				titleFontColor: window.chartColors.text,
	
				callbacks: {
					//Ref: https://stackoverflow.com/questions/38800226/chart-js-add-commas-to-tooltip-and-y-axis
					label: function (tooltipItem, data) {
						if (parseInt(tooltipItem.value) >= 1000) {
							return "VND " + tooltipItem.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						} else {
							return 'VND ' + tooltipItem.value;
						}
					}
				},
	
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					gridLines: {
						drawBorder: false,
						color: window.chartColors.border,
					},
					scaleLabel: {
						display: false,
	
					}
				}],
				yAxes: [{
					display: true,
					gridLines: {
						drawBorder: false,
						color: window.chartColors.border,
					},
					scaleLabel: {
						display: false,
					},
					ticks: {
						beginAtZero: true,
						userCallback: function (value, index, values) {
							return 'VND ' + value.toLocaleString();   //Ref: https://stackoverflow.com/questions/38800226/chart-js-add-commas-to-tooltip-and-y-axis
						}
					},
				}]
			}
		}
	};
	
	
	var barChart = document.getElementById('canvas-barchart').getContext('2d');
		window.myBar = new Chart(barChart, barChartConfig);
	// Generate charts on load
	var lineChart = document.getElementById('canvas-linechart').getContext('2d');
		window.myLine = new Chart(lineChart, lineChartConfig);

});


