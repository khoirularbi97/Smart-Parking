<div>
    <canvas id="transaksiChart"></canvas>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('transaksiChart').getContext('2d');

            var transaksiChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [
                        {
                            label: 'Kredit',
                            data: @json($data['kredit']),
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 255, 0, 0.2)',
                            fill: true
                        },
                        {
                            label: 'Debit',
                            data: @json($data['debit']),
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 0, 0, 0.2)',
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            Livewire.on('updateChart', function(data) {
                transaksiChart.data.labels = data.labels;
                transaksiChart.data.datasets[0].data = data.kredit;
                transaksiChart.data.datasets[1].data = data.debit;
                transaksiChart.update();
            });
        });
    </script>
</div>
