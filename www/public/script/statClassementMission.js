function getGraph(ctx,label,data) {
    var statClassementMission = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: label,
            datasets: [{
                label: 'Nombre de fois ou la mission à été selectionnée',
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
                text: "Classement des missions par nombre de sélections",
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
var ctx = document.getElementById('statClassementMission').getContext('2d');
var statMissionClassementLabel = JSON.parse( document.getElementById('statMissionClassementLabel').value);
var statMissionClassementData = JSON.parse(document.getElementById('statMissionClassementData').value);
getGraph(ctx,statMissionClassementLabel,statMissionClassementData);

