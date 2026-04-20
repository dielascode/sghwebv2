<div class="container-fluid p-4 p-lg-5">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-0">Dashboard</h1>
            <p class="text-muted mb-0">Selamat Datang (Nama User)!</p>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
            <div class="text-end">
                <div id="current-date" class="fw-semibold"></div>
                <small id="current-time" class="text-muted"></small>
            </div>
        </div>
    </div>

    <!-- Stats Cards with Alpine.js -->
    <div class="row g-3 g-lg-4 mb-4">
        <div class="col-sm-6 col-xl-3" x-data="statsCounter(12426, 5)">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Total Users</h6>
                            <h3 class="mb-0" x-text="value.toLocaleString()" data-stat-value>12,426</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +12.5%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success bg-opacity-10 text-success">
                                <i class="bi bi-graph-up"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Revenue</h6>
                            <h3 class="mb-0">$54,320</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +8.2%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                                <i class="bi bi-bag-check"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Orders</h6>
                            <h3 class="mb-0">1,852</h3>
                            <small class="text-danger">
                                <i class="bi bi-arrow-down"></i> -2.1%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info bg-opacity-10 text-info">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0 text-muted">Avg. Response</h6>
                            <h3 class="mb-0">2.3s</h3>
                            <small class="text-success">
                                <i class="bi bi-arrow-up"></i> +5.4%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row g-4 mb-4">
        <div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pemesanan (Seminggu Terakhir)</h5>
                </div>
                <div class="card-body">

                    <div class="card-body">
                        <canvas id="PemesananSeminggu" height="100"></canvas>

                        <script>
                            document.addEventListener("DOMContentLoaded", async function() {
                                const ctx = document.getElementById('PemesananSeminggu').getContext('2d');

                                let labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                let data = [5, 8, 12, 15, 10, 18, 22];

                                const chart = new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'New Users',
                                            data: data,
                                            borderColor: '#21543C', // garis utama
                                            backgroundColor: 'rgba(33,84,60,0.15)', // area bawah (transparan)
                                            pointBackgroundColor: '#21543C', // titik
                                            pointBorderColor: '#21543C',
                                            borderWidth: 2,
                                            tension: 0.4,
                                            fill: true
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                display: true
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
            <!--  -->
        </div>


    </div>

    <!-- New Widgets Row -->
    <div class="row g-4 mb-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="recent-orders-table">
                                <!-- Orders will be injected here by dashboard.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Storage Status -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Revenue Overview</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="250"></canvas>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                const canvas = document.getElementById('revenueChart');
                                if (!canvas) return;

                                const chartInstance = Chart.getChart(canvas);
                                if (chartInstance) {
                                    chartInstance.data.datasets[0].borderColor = '#21543C';
                                    chartInstance.data.datasets[0].pointBackgroundColor = '#21543C';
                                    chartInstance.data.datasets[0].backgroundColor = 'rgba(33, 84, 60, 0.1)';
                                    chartInstance.update();
                                }
                            }, 1000);
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
function updateDateTime() {
    const now = new Date();

    // format tanggal (Indonesia)
    const dateOptions = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };

    const date = now.toLocaleDateString('id-ID', dateOptions);

    // format jam
    const time = now.toLocaleTimeString('id-ID');

    document.getElementById('current-date').textContent = date;
    document.getElementById('current-time').textContent = time;
}

// update pertama kali
updateDateTime();

// update tiap detik
setInterval(updateDateTime, 1000);
</script>