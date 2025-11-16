document.addEventListener('DOMContentLoaded', function() {
    // Payments by level chart - VERSION DYNAMIQUE
    const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');
    const paymentsChart = new Chart(paymentsCtx, {
        type: 'bar',
        data: {
            labels: window.niveauxLabels || [],
            datasets: [{
                label: "Nombre d'étudiants inscrits",
                data: window.niveauxCounts || [],
                backgroundColor: [
                    'rgba(52, 152, 219, 0.7)',
                    'rgba(46, 204, 113, 0.7)',
                    'rgba(155, 89, 182, 0.7)',
                    'rgba(241, 196, 15, 0.7)',
                    'rgba(230, 126, 34, 0.7)',
                    'rgba(231, 76, 60, 0.7)'
                ],
                borderColor: [
                    'rgb(52, 152, 219)',
                    'rgb(46, 204, 113)',
                    'rgb(155, 89, 182)',
                    'rgb(241, 196, 15)',
                    'rgb(230, 126, 34)',
                    'rgb(231, 76, 60)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});