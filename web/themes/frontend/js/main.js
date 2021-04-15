/*minus header height js*/

// $(document).ready(function(){
//   var wHeight = $(window).height();
//   $('.signup-page').css('height', (wHeight - $(".header").innerHeight()) + 'px');
//   });


 $(window).scroll(function(){
    if ($(this).scrollTop() > 50) {
       $('#dynamic').addClass('newClass');
    } else {
       $('#dynamic').removeClass('newClass');
    }
});



	

		var bar_ctx = document.getElementById('totalIncomeChart').getContext('2d');

		var blue_gradiant = bar_ctx.createLinearGradient(0, 0, 0, 600);
		blue_gradiant.addColorStop(0, '#40DBF3');
		blue_gradiant.addColorStop(1, '#1C7EE1');

		var mytotalIncomeChart = new Chart(bar_ctx, {
			type: 'bar',
			data: {
				labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Aug", "Sep", "Oct", "Nov" , "Dec"],
				datasets: [{
					label: '# of Votes',
					data: [18, 22, 24, 14, 16, 18, 9, 15, 11, 7, 16, 13],
								backgroundColor: blue_gradiant,
								hoverBackgroundColor: blue_gradiant,
								hoverBorderWidth: 0,
								hoverBorderColor: ''
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				legend: {
					display: false,
				},
				scales: {
					yAxes: [{
						ticks: {
							display: true //this will remove only the label
						},
						gridLines : {
							drawBorder: true,
							display : true
						}
					}],
					xAxes : [ {
						gridLines : {
							drawBorder: false,
							display : false
						}
					}]
				},
			}
		});

	

// yii.confirm = function (message, okCallback, cancelCallback) {
//    swal({
//        title: message,
//        type: 'warning',
//        showCancelButton: true,
//        closeOnConfirm: true,
//        allowOutsideClick: true
//    }, okCallback);
// };

