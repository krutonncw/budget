var chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    info: '#41B1F9',
    blue: '#3245D1',
    purple: 'rgb(153, 102, 255)',
    grey: '#EBEFF6'
};

var randomScalingFactor = function() {
    return (Math.random() > 0.5 ? 1.0 : 1.0) * Math.round(Math.random() * 100);
};

// draws a rectangle with a rounded top
Chart.helpers.drawRoundedTopRectangle = function(ctx, x, y, width, height, radius) {
    ctx.beginPath();
    ctx.moveTo(x + radius, y);
    // top right corner
    ctx.lineTo(x + width - radius, y);
    ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
    // bottom right	corner
    ctx.lineTo(x + width, y + height);
    // bottom left corner
    ctx.lineTo(x, y + height);
    // top left	
    ctx.lineTo(x, y + radius);
    ctx.quadraticCurveTo(x, y, x + radius, y);
    ctx.closePath();
};

Chart.elements.RoundedTopRectangle = Chart.elements.Rectangle.extend({
    draw: function() {
        var ctx = this._chart.ctx;
        var vm = this._view;
        var left, right, top, bottom, signX, signY, borderSkipped;
        var borderWidth = vm.borderWidth;

        if (!vm.horizontal) {
            // bar
            left = vm.x - vm.width / 2;
            right = vm.x + vm.width / 2;
            top = vm.y;
            bottom = vm.base;
            signX = 1;
            signY = bottom > top ? 1 : -1;
            borderSkipped = vm.borderSkipped || 'bottom';
        } else {
            // horizontal bar
            left = vm.base;
            right = vm.x;
            top = vm.y - vm.height / 2;
            bottom = vm.y + vm.height / 2;
            signX = right > left ? 1 : -1;
            signY = 1;
            borderSkipped = vm.borderSkipped || 'left';
        }

        // Canvas doesn't allow us to stroke inside the width so we can
        // adjust the sizes to fit if we're setting a stroke on the line
        if (borderWidth) {
            // borderWidth shold be less than bar width and bar height.
            var barSize = Math.min(Math.abs(left - right), Math.abs(top - bottom));
            borderWidth = borderWidth > barSize ? barSize : borderWidth;
            var halfStroke = borderWidth / 2;
            // Adjust borderWidth when bar top position is near vm.base(zero).
            var borderLeft = left + (borderSkipped !== 'left' ? halfStroke * signX : 0);
            var borderRight = right + (borderSkipped !== 'right' ? -halfStroke * signX : 0);
            var borderTop = top + (borderSkipped !== 'top' ? halfStroke * signY : 0);
            var borderBottom = bottom + (borderSkipped !== 'bottom' ? -halfStroke * signY : 0);
            // not become a vertical line?
            if (borderLeft !== borderRight) {
                top = borderTop;
                bottom = borderBottom;
            }
            // not become a horizontal line?
            if (borderTop !== borderBottom) {
                left = borderLeft;
                right = borderRight;
            }
        }

        // calculate the bar width and roundess
        var barWidth = Math.abs(left - right);
        var roundness = this._chart.config.options.barRoundness || 0.5;
        var radius = barWidth * roundness * 0.5;

        // keep track of the original top of the bar
        var prevTop = top;

        // move the top down so there is room to draw the rounded top
        top = prevTop + radius;
        var barRadius = top - prevTop;

        ctx.beginPath();
        ctx.fillStyle = vm.backgroundColor;
        ctx.strokeStyle = vm.borderColor;
        ctx.lineWidth = borderWidth;

        // draw the rounded top rectangle
        Chart.helpers.drawRoundedTopRectangle(ctx, left, (top - barRadius + 1), barWidth, bottom - prevTop, barRadius);

        ctx.fill();
        if (borderWidth) {
            ctx.stroke();
        }

        // restore the original top value so tooltips and scales still work
        top = prevTop;
    },
});

Chart.defaults.roundedBar = Chart.helpers.clone(Chart.defaults.bar);

Chart.controllers.roundedBar = Chart.controllers.bar.extend({
    dataElementType: Chart.elements.RoundedTopRectangle
});

//functions จัดรูปแบบตัวเลข
function currencyFormat(num) {
    return 'B' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

// ฟังก์ชั่นจัดรูปแบบตัวเลข
function currencyFormat(num) {
    return 'B' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

//อ่านข้อมูลจากฐานข้อมูลมาแสดง
var ctxBar = document.getElementById("bar").getContext("2d");
// GET Request.
// fetch('http://localhost/ncwbudget/views/budget/payPlanJson.php')
fetch('https://ncw.ac.th/ncwbudget/views/budget/payPlanJson.php')
    // Handle success
    .then(response => response.json()) // convert to json
    .then(json => {
        var myBar = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ["ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.", "ม.ค.", "ก.พ.", "มี.ค."],
                datasets: [{
                        label: 'อุดหนุน',
                        backgroundColor: [chartColors.red, chartColors.red, chartColors.red, chartColors.red, chartColors.red, chartColors.red, chartColors.red, chartColors.red, chartColors.render],
                        data: [
                            parseFloat(json.julhead).toFixed(2),
                            parseFloat(json.aughead).toFixed(2),
                            parseFloat(json.sephead).toFixed(2),
                            parseFloat(json.octhead).toFixed(2),
                            parseFloat(json.novhead).toFixed(2),
                            parseFloat(json.dechead).toFixed(2),
                            parseFloat(json.janhead).toFixed(2),
                            parseFloat(json.febhead).toFixed(2),
                            parseFloat(json.marhead).toFixed(2),

                        ]
                    },
                    {
                        label: 'เรียนฟรี15ปี',
                        backgroundColor: [chartColors.green, chartColors.green, chartColors.green, chartColors.green, chartColors.green, chartColors.green, chartColors.green, chartColors.green, chartColors.green],
                        data: [
                            parseFloat(json.julfree).toFixed(2),
                            parseFloat(json.augfree).toFixed(2),
                            parseFloat(json.sepfree).toFixed(2),
                            parseFloat(json.actfree).toFixed(2),
                            parseFloat(json.novfree).toFixed(2),
                            parseFloat(json.decfree).toFixed(2),
                            parseFloat(json.janfree).toFixed(2),
                            parseFloat(json.febfree).toFixed(2),
                            parseFloat(json.marfree).toFixed(2),
                        ]
                    },
                    {
                        label: 'รายได้',
                        backgroundColor: [chartColors.blue, chartColors.blue, chartColors.blue, chartColors.blue, chartColors.blue, chartColors.blue, chartColors.blue, chartColors.blue, chartColors.blue],
                        data: [
                            parseFloat(json.julincome).toFixed(2),
                            parseFloat(json.augincome).toFixed(2),
                            parseFloat(json.sepincome).toFixed(2),
                            parseFloat(json.octincome).toFixed(2),
                            parseFloat(json.novincome).toFixed(2),
                            parseFloat(json.decincome).toFixed(2),
                            parseFloat(json.janincome).toFixed(2),
                            parseFloat(json.febincome).toFixed(2),
                            parseFloat(json.marincome).toFixed(2),
                        ]
                    }
                ]
            },
            options: {
                responsive: true,
                barRoundness: 1,
                title: {
                    display: true,
                    text: "สรุปยอดเบิกจ่ายประจำเดือนแต่ละประเภท"
                },
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 40 + 20,
                            padding: 10,
                        },
                        gridLines: {
                            drawBorder: false,
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }]
                }
            }
        });
        var radialBarshead = {
            // series: [parseFloat(json.typehead).toFixed(2), parseFloat(json.phead).toFixed(2), parseFloat(json.sumhead).toFixed(2)],
            series: [parseFloat(json.typehead), parseFloat(json.phead), parseFloat(json.sumhead)],
            chart: {
                width: 350,
                type: 'pie',
            },
            labels: ['ยอดจัดสรร', 'ยอดเบิก', 'คงเหลือ'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0],
                name: {
                    offsetY: -5,
                    fontSize: "22px",
                },
                value: {
                    fontSize: "2.5rem",
                }
            }

        };
        var radialBarsfree = {
            // series: [parseFloat(json.typehead).toFixed(2), parseFloat(json.phead).toFixed(2), parseFloat(json.sumhead).toFixed(2)],
            series: [parseFloat(json.typefree), parseFloat(json.pfree), parseFloat(json.sumfree)],
            chart: {
                width: 350,
                type: 'pie',
            },
            labels: ['ยอดจัดสรร', 'ยอดเบิก', 'คงเหลือ'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0],
                name: {
                    offsetY: -5,
                    fontSize: "22px",
                },
                value: {
                    fontSize: "2.5rem",
                }
            }

        };
        var radialBarsincome = {
            // series: [parseFloat(json.typehead).toFixed(2), parseFloat(json.phead).toFixed(2), parseFloat(json.sumhead).toFixed(2)],
            series: [parseFloat(json.typeincome), parseFloat(json.pincome), parseFloat(json.sumincome)],
            chart: {
                width: 350,
                type: 'pie',
            },
            labels: ['ยอดจัดสรร', 'ยอดเบิก', 'คงเหลือ'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0],
                name: {
                    offsetY: -5,
                    fontSize: "22px",
                },
                value: {
                    fontSize: "2.5rem",
                }
            }

        };
        var radialBarsheadObj = new ApexCharts(document.querySelector("#radialBarshead"), radialBarshead);
        radialBarsheadObj.render();
        var radialBarsfreeObj = new ApexCharts(document.querySelector("#radialBarsfree"), radialBarsfree);
        radialBarsfreeObj.render();
        var radialBarsincomeObj = new ApexCharts(document.querySelector("#radialBarsincome"), radialBarsincome);
        radialBarsincomeObj.render();
    }) //print data to console
    .catch(err => console.log('Request Failed', err)); // Catch errors