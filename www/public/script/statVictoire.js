var ctx = document.getElementById('statVictoire').getContext('2d');
var statVictoireData =JSON.parse(document.getElementById('statVictoireData').value);
console.log(statVictoireData);
var statVictoire = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Victoires','Défaites','Égalités','En cours'],
        datasets: [{
            backgroundColor: [
                'rgba(57,239,103,0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(10,169,232,0.2)'

            ],
            borderColor: [
                'rgba(57,239,103,1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(10,169,232,1)'

            ],
            borderWidth: 1,
            data: statVictoireData
        }]
    },
    options: {
        legend: {
            labels: {
                fontColor: "white"
            }
        },
        title: {
            text: "Statut des parties",
            fontColor: "white"
        }
    }
});console.log(ctx);