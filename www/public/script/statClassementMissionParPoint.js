function getGraph(ctx,label,data) {
    var statClassementMission = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: label,
            datasets: [{
                label: 'Nombre de points rapportés par la mission',
                backgroundColor:
                    'rgba(10,169,232,0.2)',

                borderColor:
                    'rgba(10,169,232,1)',

                borderWidth: 0.5,

                data: data,
            }]
        },
        options: {
            legend: {
                display:false
            },

            title: {
                text: "Classement des missions par nombre de points rapportés",
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
var ctx = document.getElementById('statClassementMissionParPoint').getContext('2d');
var statMissionClassementLabel = JSON.parse( document.getElementById('statMissionClassementParPointLabel').value);
var statMissionClassementData = JSON.parse(document.getElementById('statMissionClassementParPointData').value);
getGraph(ctx,statMissionClassementLabel,statMissionClassementData);

