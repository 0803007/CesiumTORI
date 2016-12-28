<?php
    //INPUT:船種的的關鍵字
	//PROCSEE:從從船種的關鍵字 QUERY出所有的船次 
	//OUTPUT:JSON格式的船次Table Name
	require_once("DB_config.php");
    require_once("DB_class.php");
	
    $month = $_POST['month'];
	$month ="toros_$month";
	$date = $_POST['date'];
	
	//$month="toros_201611";
	//$date='2016-11-05 12:00:00';
 /*
     if($select_op != ""){ 
             if($select_op == "1"){ 
                     echo "你選擇到1的選項"; 
              }else if($select_op == "2"){ 
                     echo "你選擇到2的選項"; 
              }else if($select_op == "3"){ 
                     echo "你選擇到3的選項"; 
              } 
         }else{ 
               echo "請選擇一個選項"; 
         }
*/
	//$tname = "KM0909";
	// Use fopen function to open a file
	// connect SQL
	//連線資料庫
	$db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	//Query
	$sqlstr = "SELECT Longitude,Latitude,Ucomp,Vcomp,Velocity FROM $month WHERE Datetime = '$date'";
    $db->query($sqlstr);

	$rows = array();
	while ($row = $db->fetch_row()){
		//將陣列內容轉存在PHP的array
		$data_array[] = array(
						"Longitude" => $row[0],"Latitude" => $row[1],"Ucomp" => $row[2],"Vcomp" => $row[3],"Velocity" => $row[4]);
	}
	//print_r($data_array);
	  
	echo json_encode($data_array);

	/*
    while($row = mysql_fetch_array($result)){
        echo $row['Longitude'] . ' ' . $row['Latitude'] . ' ';
    }*/
	
	//echo json_encode($rs);  
	/*
	$rows[] = array("result" => 'This is JSON data');
    $json = json_encode($rows);     
    echo $json;*/
	
?>