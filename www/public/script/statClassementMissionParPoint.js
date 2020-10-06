$(function()
{
    $('.checkBoxLivre').change(function() {ctx = document.getElementById('statMissionClassementCanvas').getContext('2d');

        // label = ["toto", "titi"];
        for (var i = 0; i < labelStatClassementMissionParPoint.length; i++)
        {
            var element = labelStatClassementMissionParPoint[i].indexOf(this.id)
            if(this.checked)
            {
                if (element !== -1) {
                    // mission[m].options[i].hidden = false;
                }
            }
            else {
                if (this.checked === false) {
                    if (element !== -1) {
                        delete labelStatClassementMissionParPoint[i];
                        delete dataStatClassementMissionParPoint[i];
                    }
                }
            }
        }
        console.log(dataStatClassementMissionParPoint);
        getGraph(ctxStatClassementMissionParPoint,labelStatClassementMissionParPoint,dataStatClassementMissionParPoint);
    });
});

// function getGraph(ctx,label,data) {
//     var statClassementMission = new Chart(ctx, {
//         type: 'horizontalBar',
//         data: {
//             labels: label,
//             datasets: [{
//                 label: 'Nombre de points rapportés par la mission',
//                 backgroundColor:
//                     'rgba(10,169,232,0.2)',
//
//                 borderColor:
//                     'rgba(10,169,232,1)',
//
//                 borderWidth: 0.5,
//
//                 data: data,
//             }]
//         },
//         options: {
//             legend: {
//                 display:false
//             },
//
//             title: {
//                 text: "Classement des missions par nombre de points rapportés",
//                 fontColor: "white"
//             },
//             scales:
//                 {
//                     yAxes: [{
//                         ticks:{
//                             fontColor:"#D3D3D3"
//                         }
//                     }],
//                     xAxes: [{
//                         ticks:{
//                             gridLines:{
//                                 minBarLength:0
//                             },
//                             fontColor:"#D3D3D3"
//                         }
//                     }]
//                 }
//         }
//     })
// }
var ctxStatClassementMissionParPoint = document.getElementById('statClassementMissionParPointCanvas').getContext('2d');
var statClassementMissionParPoint = JSON.parse( document.getElementById('statMissionClassementParPoint').value);
var labelStatClassementMissionParPoint = statClassementMissionParPoint["label"]
var dataStatClassementMissionParPoint = statClassementMissionParPoint["data"]
getGraph(ctxStatClassementMissionParPoint,labelStatClassementMissionParPoint,dataStatClassementMissionParPoint,"Classement des missions par nombre de points rapportés","Nombre de points rapportés par la mission");

