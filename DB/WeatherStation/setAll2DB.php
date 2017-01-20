<?php
	//INPUT:船次的資料夾路徑
	//PROCSEE:搜尋資料夾所有的檔案 由資料夾檔名(哪艘船)建立資料庫的Table,在寫入檔案格式至資料庫
	//OUTPUT:無

	header("Content-Type:text/html; charset=UTF-8");
	
	require_once("DB_config.php");
    require_once("DB_class.php");
	
	//設定PHP執行時間限制
	set_time_limit(0);
	
	//設定table name
	$posname = "DATN";
	
	//取得檔案路徑
	$path = "G:\\海洋工作\\資料庫\\DATA\\\TOROS_Weather\\\Level0\\$posname\\2016\\$posname"."_ptu_*.*";
	$path =  iconv('UTF-8','Big5', $path);
echo $path;
	$filepathList = glob($path);
	
	
	//連線資料庫
	$db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	
	//用船的代號建立資料表
	//$sqlstr="create table IF NOT EXISTS $tname(ID int NOT NULL AUTO_INCREMENT PRIMARY KEY, UTCTime datetime, LOCTime datetime, TEMPERATURE float, HUMIDITY float,PRESSURE float)";
	//$db->query($sqlstr);
	//echo "資料表建立成功";	
	
	//for loop所有sub file
	$len = count($filepathList); 
	echo $len;
	for($i=0 ;$i<$len;$i=$i+1){
		
		//Insert Data	
		$filepath = basename($filepathList[$i]);
		$tname = substr($filepath,0,-4);//去除副檔名	

		//建立資料表
		//$sqlstr="use $dbname";
		//$db->query($sqlstr);
		$sqlstr="create table IF NOT EXISTS $tname(UTCTime char(26), LOCTime char(26), TEMPERATURE float, HUMIDITY float,PRESSURE float)";
		$db->query($sqlstr);
		echo "資料表建立成功";
		
		//echo $path;
		$db->query("SET NAMES utf8");
		$sqlStr="insert into $tname(UTCTime,LOCTime,TEMPERATURE,HUMIDITY,PRESSURE) values";
        
		$file = fopen($filepathList[$i], "r");
		$count = 0;
		// Read the file line by line until the end
		while (($data = fgetcsv($file, 1000, ",")) !== FALSE){		
			//判斷是否為數字  $pressue需要扣掉最後一個字元  
			if ( (is_numeric($data[2])) && (is_numeric($data[3])) && is_numeric(substr($data[4],0,-1)))
			{	
				$time1 = $data[0];
				$time2 = $data[1];
							
				$temperature = $data[2];
				$humidity = $data[3];
				$pressue = $data[4];
				//echo $Longitude . "<br />" . $Voyage . "<br />\n" ;
echo "$time1";	
				//insert to DB
				$sqlStr.=" ('$time1','$time2',$temperature,$humidity,$pressue),";
				$count = $count + 1;
				//if ($count >1000)
				//   break;
			}
		}
		$sqlStr = substr($sqlStr,0,-1);  //delete last char
		//echo $sqlStr;
		$db->query($sqlStr);
		echo " insertDB Successfully!<br>  ";
		
		fclose($file);
		
	}
	echo "OVER!!!<br>  ";

?>