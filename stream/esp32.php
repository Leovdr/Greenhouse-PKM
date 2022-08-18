<?php
    // Atur tanggal ke default Jakarta(Indonesia WIB +7)
    date_default_timezone_set("Asia/Jakarta");

    // Koneksi ke Database
    $conn = mysqli_connect("localhost", "root", "", "pkm_greenhouse");
    if(!$conn) {
        die("Conn fail: " . mysqli_connect_error());
    }

    // Dapat Dari ESP ~
    $temp     = $_GET['temp'];
    $hum      = $_GET['hum'];
    $ph       = $_GET['ph'];    

    $result = array();
    $query = "INSERT INTO `tbl_dashboard` (`id_dashboard`, `suhu`, `kelembapan`, `ph_tanah`, `tanggal`) VALUES (NULL, '".$temp."', '".$hum."', '".$ph."', '".date('d-m-Y')."');"; // query dari database
        
    if(mysqli_query($conn, $query)) {
        // echo $query;
        echo "[Server] Data berhasil dimasukkan";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        die();
    } 

?>