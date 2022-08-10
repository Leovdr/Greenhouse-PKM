<?php
include "stream/koneksi.php";

    // Dapat Dari ESP ~
    $temp     = $_GET['temp'];
    $hum      = $_GET['hum'];

    $result = array();
    $query = "INSERT INTO `tbl_raw` (`id`, `ser_esp`, `roll`, `yaw`, `pitch`, `timestamp`) VALUES (NULL, '".$id."', '".$roll."', '".$yaw."', '".$pitch."', current_timestamp());";
        
    if(mysqli_query($conn, $query)) {
        // echo $query;
        echo "[Server] Data berhasil dimasukkan";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        die();
    }

    // while (true) {
    //     array_push($result, array('roll_ser_1'=> $row[0],  'pitch_ser_1'=> $row[1], 'yaw_ser_1'=> $row[2], 'timestamp'=> $row[3]));
    // }

    array_push($result, array('roll_ser_1'=> $row[0],  'pitch_ser_1'=> $row[1], 'yaw_ser_1'=> $row[2], 'timestamp'=> $row[3]));
    json_encode(array("result_1" => $result));
?>