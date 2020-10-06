$(function()
{
    $('.checkBoxLivre').change(function() {
        ctx = document.getElementById('statMissionClassementCanvas').getContext('2d');

        // label = ["toto", "titi"];
        for (var i = 0; i < label.length; i++)
        {
            var element = label[i].indexOf(this.id)
            if(this.checked)
            {
                if (element !== -1) {
                    // mission[m].options[i].hidden = false;
                }
            }
            else {
                if (this.checked === false) {
                    if (element !== -1) {
                        delete label[i];
                        delete data[i];
                    }
                }
            }
        }
        console.log(label);
        statClassementMissiontt.data(data)
    });
});

function getGraphe(ctx,label,data) {
    var statClassementMissiontt = new Chart(ctx, {
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
var ctx = document.getElementById('statMissionClassementCanvas').getContext('2d');
var statMissionClassement = JSON.parse( document.getElementById('statMissionClassement').value);

var label = statMissionClassement["label"]
var data = statMissionClassement["data"]
getGraphe(ctx,label,data);
// getGraph(ctx,label,data,"Classement des missions par nombre de sélections","Nombre de fois ou la mission à été selectionnée");
