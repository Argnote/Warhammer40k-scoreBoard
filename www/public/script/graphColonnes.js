function getGraph(ctx,label,data,title,legend) {
    var statClassementMission = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: label,
            datasets: [{
                label: legend,
                backgroundColor:
                    'rgba(57,239,103,0.2)',

                borderColor:
                    'rgba(57,239,103,1)',

                borderWidth: 0.5,

                data: data,
            }]
        },
        options: {
            legend: {
                display:false
            },

            title: {
                text: title,
                fontColor: "white"
            },
            scales:
                {
                    yAxes: [{
                        ticks:{
                            fontColor:"#D3D3D3"
                        }
                    }],
                    xAxes: [{
                        ticks:{
                            gridLines:{
                                minBarLength:0
                            },
                            fontColor:"#D3D3D3"
                        }
                    }]
                }
        }
    })
}