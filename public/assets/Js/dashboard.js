document.addEventListener('DOMContentLoaded', function() {
            // Payments by level chart
            const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');
            const paymentsChart = new Chart(paymentsCtx, {
                type: 'bar',
                data: {
                    labels: ['Débutant', 'Intermédiaire', 'Avancé'],
                    datasets: [{
                        label: 'Total etudiant inscrits',
                        data: [80, 100, 50],
                        backgroundColor: [
                            'rgba(52, 152, 219, 0.7)',
                            'rgba(46, 204, 113, 0.7)',
                            'rgba(155, 89, 182, 0.7)'
                        ],
                        borderColor: [
                            'rgb(52, 152, 219)',
                            'rgb(46, 204, 113)',
                            'rgb(155, 89, 182)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }); 