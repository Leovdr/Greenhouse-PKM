<?php
    $temp     = $_GET['temp'];
    $hum      = $_GET['hum'];
    $ph       = $_GET['ph']; 

    $result = array();

    array_push($result, array('suhu'=> $temp,  'kelembapan'=> $hum, 'ph_tanah'=> $ph));
    echo json_encode(array("result" => $result));
?>