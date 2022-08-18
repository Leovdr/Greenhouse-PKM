<?php 
    // Koneksi ke Database
    $conn = mysqli_connect("localhost", "root", "", "pkm_greenhouse");
    if(!$conn) {
        die("Conn fail: " . mysqli_connect_error());
    }

    // Membuat Jangkauan Grafik 10 hari ke belakang
    // Kalibrasi Tanggal
    date_default_timezone_set("Asia/Jakarta");
    $date      = date('d-m-Y');

    // Mempersiapkan Array
    $tgl_ready = array();
    $suhu_arr  = array();
    $hum_arr   = array();
    $ph_arr    = array();

    // Variabel hari (Setting $j sesuai dengan kebutuhan)
    $j = 10;
    for ($i=0; $i < 10; $i++) { 
        $date2 = date('Y-m-d', strtotime("-".$j." days", strtotime($date)));
        // Mengatur X-Axis pada tabel grafik
        $tgl_ready[$i] = $date2;

        // Kalkulasi banyaknya data tiap parameter sesuai tanggal
        $sql = mysqli_query($conn, "SELECT COUNT(suhu) FROM tbl_dashboard WHERE `tanggal` = '".$date2."';");
        if ($row = mysqli_fetch_array($sql)) {
            $data_suhu  = $row[0];
        }

        $sql = mysqli_query($conn, "SELECT COUNT(kelembapan) FROM tbl_dashboard WHERE `tanggal` = '".$date2."';");
        if ($row = mysqli_fetch_array($sql)) {
            $data_kelembapan  = $row[0];
        }

        $sql = mysqli_query($conn, "SELECT COUNT(ph_tanah) FROM tbl_dashboard WHERE `tanggal` = '".$date2."';");
        if ($row = mysqli_fetch_array($sql)) {
            $data_ph_tanah  = $row[0];
        }

        // Mengambil nilai rata-rata setiap parameter sesuai tanggal 
        $sql_2 = mysqli_query($conn, "SELECT SUM(suhu) FROM tbl_dashboard WHERE `tanggal` = '".$date2."';");
        if ($row = mysqli_fetch_array($sql_2)) {
            $total_suhu  = $row[0];
        }

        $sql_2 = mysqli_query($conn, "SELECT SUM(kelembapan) FROM tbl_dashboard WHERE `tanggal` = '".$date2."';");
        if ($row = mysqli_fetch_array($sql_2)) {
            $total_kelembapan  = $row[0];
        }

        $sql_2 = mysqli_query($conn, "SELECT SUM(ph_tanah) FROM tbl_dashboard WHERE `tanggal` = '".$date2."';");
        if ($row = mysqli_fetch_array($sql_2)) {
            $total_ph_tanah  = $row[0];
        }

        // menghitung mean setiap parameter sesuai tanggal
        $mean_suhu       = round($total_suhu / $data_suhu,1);
        $mean_kelembapan = round($total_kelembapan / $data_kelembapan,1);
        $mean_ph_tanah   = round($total_ph_tanah / $data_ph_tanah,2);  

        // Memasukkan mean ke dalam array
        $suhu_arr[$i] = $mean_suhu;
        $hum_arr[$i]  = $mean_kelembapan;
        $ph_arr[$i]   = $mean_ph_tanah;


        // Mengurangi variabel agar tanggal menurun
        $j--;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>PKM KC - Greenhouse POLIJE 2022</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/fontawesome-free 6/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <!-- <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                </nav> -->
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Monitoring Greenhouse</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Suhu</div>
                                            <div id="suhu" class="h5 mb-0 font-weight-bold text-gray-800">Loading Data...</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-temperature-quarter fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Kelembapan</div>
                                            <div id="kelembapan" class="h5 mb-0 font-weight-bold text-gray-800">Loading Data...</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-droplet fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">pH Tanah
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div id="ph_tanah" class="h5 mb-0 mr-3 font-weight-bold text-gray-800">Loading Data...</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-seedling fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Status Penyiraman</div>
                                            <div id="status" class="h5 mb-0 font-weight-bold text-gray-800">Loading Data...</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="chartNilai">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-6 mb-4">

                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header px-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Suhu</h6>
                                </div>
                                <div class="card-body">
                                    <p>Suhu menunjukkan derajat panas di dalam Greenhouse. Mudahnya, semakin tinggi suhu di dalam Greenhouse, semakin panas ruangan tersebut. 
                                        Suhu di greenhouse ini digunakan sebagai parameter agar penyiraman dapat dilakukan secara otomatis, 
                                        jika suhu ada diatas 31° maka penyiraman akan aktif secara otomatis,sedangkan jika telah mencapai suhu dibawah 31° akan otomatis berhenti.</p>
                                </div>
                        </div>
                        </div>

                        <div class="col-lg-6 mb4">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Kelembapan</h6>
                                </div>
                                <div class="card-body">
                                    <p>Kelembaban adalah konsentrasi kandungan dari uap air yang ada di udara. 
                                        Uap air yang terdapat dalam atmosfer bisa berubah wujud menjadi cair atau padat. 
                                        Kelembaban disini sangat berpengaruh terhadap tanaman,jika tanaman kekurangan kadar air maka tanaman akan layu/mati.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb4">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">pH Tanah</h6>
                                </div>
                                <div class="card-body">
                                    <p>pH tanah adalah tingkat keasaman atau kebasaan suatu tanaman yang diukur dengan skala pH antara 0 hingga 14. 
                                        pH Tanah sangat berpengaruh bagi tanaman. pH yang baik bagi tanaman berada di angka 7.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb4">
                            <!-- Approach -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Status Penyiraman</h6>
                                </div>
                                <div class="card-body">
                                    <p>Status penyiraman pada web ini bertujuan agar pemilik greenhouse dapat mengetahui apakah penyiraman sedang aktif atau sudah nonaktif. 
                                        Jika aktif maka status penyiraman akan menampilkan tulisan aktif. 
                                        Jika nonaktif maka status penyiraman akan menampilkan tulisan nonaktif.</p>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy;</span> <span style="color: purple; font-weight: 900;"> PKM KC - Greenhouse POLIJE 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>


    <!-- Replace Me-->
    <!-- <script src="js/replaceme.min.js"></script><script>
        var replace = new ReplaceMe(document.querySelector('.replace-me'));
    </script> -->

    <!-- Additional JS -->
    <script>
        $(document).ready(function() {
            selesai();
        })

        function selesai() {
            setInterval(function() {
                update();
            }, 1000);
        }
        
        function update() {
            $.getJSON('stream/stream.php', function(data) {
                $.each(data.result_1, function() {
                    let suhu;
                    suhu = this['suhu'];

                    console.log("masuk");

                    if (suhu >=31) {
                        $("#status").replaceWith(`<div id="status" class="h5 mb-0 font-weight-bold text-gray-800">Aktif</div>`);
                    } else{
                        $("#status").replaceWith(`<div id="status" class="h5 mb-0 font-weight-bold text-gray-800">Nonaktif</div>`);
                    }

                    $("#suhu").replaceWith(`<div id="suhu" class="h5 mb-0 font-weight-bold text-gray-800">`+suhu+`</div>`);
                    $("#kelembapan").replaceWith(`<div id="kelembapan" class="h5 mb-0 font-weight-bold text-gray-800">`+this['kelembapan']+`</div>`);
                    $("#ph_tanah").replaceWith(`<div id="ph_tanah" class="h5 mb-0 mr-3 font-weight-bold text-gray-800">`+this['ph_tanah']+`</div>`);
                    
                })
            });
        }

    </script>


    <!-- Highlight Graphics -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        Highcharts.chart('chartNilai', {

        title: {
            text: 'Grafik Data Greenhouse'
        },

        subtitle: {
            text: '10 Hari Terakhir'
        },

        yAxis: {
            title: {
                text: ''
            }
        },

        xAxis: {
            categories: <?php echo json_encode($tgl_ready); ?>
        },

        rangeSelector: {
            enabled: false
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }

            // series: {
            //     label: {
            //         connectorAllowed: true
            //     },
            //     // pointStart: 1
            // }
        },

        series: [{
            name: 'Suhu',
            data: <?php echo json_encode($suhu_arr); ?>
        }, {
            name: 'Kelembapan',
            data: <?php echo json_encode($hum_arr); ?>
        }, {
            name: 'pH Tanah',
            data: <?php echo json_encode($ph_arr); ?>
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

        });
    </script>
</body>

</html>