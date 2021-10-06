const labelsP = ['Enero', 'Febrero', 'Marzo'];
const dataP = {
    labels:  labelsP,
    datasets: [{
      type: 'bar',
      label: 'Low',
      data: [10, 20, 30],
      borderColor: 'rgb(255, 99, 132)',
      backgroundColor: 'rgba(239, 112, 0, 0.4)'
    }, {
      type: 'bar',
      label: 'Normal',
      data: [5, 10, 15],
      fill: false,
      borderColor: 'rgb(54, 162, 235)',
      backgroundColor: 'rgba(0, 157, 212, 0.4)'
    }, {
        type: 'bar',
        label: 'LHigh',
        data: [5, 8, 2],
        fill: false,
        borderColor: 'rgb(54, 16, 235)',
        backgroundColor: 'rgba(108, 16, 189, 0.4)'
      }]
  };

  const configP = {
    type: 'scatter',
    data: dataP,
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  };

  let priorityObj = document.getElementById('priority-chart');

  let priorityChart = new Chart(priorityObj, configP);