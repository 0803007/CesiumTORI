<?php
    //INPUT:NO
	//PROCSEE:Query med_site_info 所有的資料
	//OUTPUT:JSON格式的所有資料
	require_once("DB_config.php");
    require_once("DB_class.php");
	
	$tname = "med_site_info";

	// Use fopen function to open a file
	// connect SQL
	//連線資料庫
	$db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);

	//Query
	$sqlstr = "SELECT * FROM $tname";
    $db->query($sqlstr);

	//$data_array = $db-＞fetchAll();
	while ($row = $db->fetch_row()){
		//print_r($row);
		//將陣列內容轉存在PHP的array
		$data_array[] = array (
						"siteID" => $row[0],
						"siteName" => $row[1],
						"siteEName" => $row[2],
						"type" => $row[3],
						"lon" => $row[4],
						"lat" => $row[5],
						"altitude" => $row[6],
						"status" => $row[7],
						"startDate" => $row[8],
						"endDate" => $row[9],
						"description" => $row[10],
						"edescription" => $row[11],
						"location" => $row[12],
						"remark" => $row[13],
						"updateDate" => $row[14]);
	}
	//print_r($data_array);
	echo json_encode($data_array);
	
?>