<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Omset hari Ini</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp <?= number_format($totalOmsetHariIni, 0, ',', '.') ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Omset Bulan Ini</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp <?= number_format($totalOmsetBulanan, 0, ',', '.') ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
               <!-- Pending Requests Card Example -->
               <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Omset Tahun Ini</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">
                        Rp <?= number_format($totalOmsetTahunan, 0, ',', '.') ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">User</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                        <?= number_format($totalUser, 0, ',', '.') ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         
            <!-- Bar Chart -->
            <div class="col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Penjualan Chart</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="getChartPetugas"></canvas>
                  </div>
                  <hr>
                </div>
              </div>
            </div>


            <!--  top product penjualan -->
            <div class="col-xl-5 col-lg-7 mb-4">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Top Product </h6>
                </div>
                <div class="card-body">
                  <div class="chart-pie pt-4">
                    <canvas id="getTopProduct"></canvas>
                  </div>
                  <hr>
                    Persentase product terlaris bulan ini
                </div>
              </div>
            </div>
           
          </div>

          <!-- Modal min stock -->
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Stock Barang Hampir Habis</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama Product</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                        <tbody>
                          <?php 
                          $no = 1;
                          foreach($minStock as $product ) : ?>
                          <tr>
                              <td><?= $product['name'] ?></td>
                              <td><?= $product['stock'] ?></td>
                          </tr>
                          <?php endforeach; ?>
                          
                          </tbody>
                      </table>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Oke</button>
                </div>
              </div>
            </div>
          </div>

      <script>
        $(document).ready(function () {
              var modalShown = localStorage.getItem('modalShown'); 
              <?php if (!empty($minStock)): ?>
                  if (!modalShown) {
                      $('#exampleModal').modal('show');
                      localStorage.setItem('modalShown', 'true');
                  }
              <?php endif; ?>
          });



        fetch('<?= base_url('/chart-penjualan-petugas') ?>')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById("getChartPetugas");
                const getChartPetugas = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels, 
                        datasets: [{
                            label: "Omset Penjualan",
                            backgroundColor: "#4e73df",
                            hoverBackgroundColor: "#2e59d9",
                            borderColor: "#4e73df",
                            data: data.omset, 
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'user'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 6
                                },
                                maxBarThickness: 25,
                            }],
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    padding: 10,
                                    callback: function(value) {
                                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ': Rp ' + new Intl.NumberFormat('id-ID').format(tooltipItem.yLabel);
                                }
                            }
                        },
                    }
                });
            })
            .catch(error => console.error('Error fetching sales data:', error));


            function loadChartData() {
            fetch("<?= site_url('/get-top-product') ?>")
                .then(response => response.json())
                .then(data => {
                    const totalSales = data.productSales.reduce((sum, current) => sum + current, 0);
                    const percentageSales = data.productSales.map(sales => ((sales / totalSales) * 100).toFixed(2));
                    var ctx = document.getElementById("getTopProduct").getContext('2d');

                    var getTopProduct = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.productNames, 
                            datasets: [{
                                data: percentageSales, 
                                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#d23535'],
                                hoverBorderColor: "rgba(234, 236, 244, 1)",
                            }],
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        const dataset = data.datasets[tooltipItem.datasetIndex];
                                        const value = dataset.data[tooltipItem.index];
                                        const label = data.labels[tooltipItem.index];
                                        return `${label}: ${value}%`;
                                    }
                                },
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                            },
                            legend: {
                                display: true 
                            },
                            cutoutPercentage: 60, 
                        },
                    });
                })
                .catch(error => console.log('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadChartData();
        });

      </script>


<?= $this->endSection() ?>
