<?php 
$conn = mysqli_connect("localhost", "root", "", "pkm_greenhouse");
if(!$conn) {
    die("Conn fail: " . mysqli_connect_error());
}

$sql    = mysqli_query($conn, "SELECT `id_dashboard`, `suhu`, `kelembapan`, `ph_tanah` FROM `tbl_dashboard` ORDER BY `tbl_dashboard`.`id_dashboard` ASC");
$result = array();


while ($row = mysqli_fetch_array($sql)) {
    array_push($result, array('suhu'=> $row[1],  'kelembapan'=> $row[2], 'ph_tanah'=> $row[3]));
}

echo json_encode(array("result_1" => $result));
?>