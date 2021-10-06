
const labels = ['Nuevos', 'Pendientes'];

const data = {
    labels: labels,
    datasets: [{
        label: 'Desgloce de Casos',
        barThickness: 70,
        data: [11000, 3000],
        backgroundColor: [
            'rgba(255, 159, 64, 0.2)',
            'rgba(54, 162, 235, 0.2)',
        ],
        borderColor: [
            'rgb(255, 159, 64)',
            'rgb(54, 162, 235)',
        ],
        borderWidth: 1
    }] 
}

const config = {
    type: 'bar',
    data: data,
    options: {
      scales: {
        y: {
                beginAtZero: true
            }
        }
    },
};

let obj = document.getElementById('breakdown-chart');
let breakdown = new Chart(obj, config);
