// Wait for the DOM to load before running the script
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('salesChart').getContext('2d');

    // Fetch sales data from the API
    fetch('/api/sales-data')
        .then(response => response.json())
        .then(salesData => {
            // Prepare labels and data for the chart
            const labels = Object.keys(salesData);
            const data = Object.values(salesData);

            // Initialize the chart
            var salesChart = new Chart(ctx, {
                type: 'line', // Specify the chart type (line chart)
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Sales',
                        data: data, // Use dynamic sales data
                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Background color under the line
                        borderColor: 'rgba(54, 162, 235, 1)', // Line color
                        borderWidth: 2, // Line width
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)', // Point color
                        pointRadius: 5, // Size of points on the chart
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true, // Start the Y-axis at 0
                            title: {
                                display: true,
                                text: 'Sales Value'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month'
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return 'Sales: ' + tooltipItem.raw + ' units'; // Tooltip format
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching sales data:', error));
});
