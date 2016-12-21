<?php
	//INPUT:船次的資料夾路徑
	//PROCSEE:搜尋資料夾所有的檔案 由主檔名建立資料庫的Table,在寫入檔案格式至資料庫
	//OUTPUT:無

	header("Content-Type:text/html; charset=UTF-8");
	
	require_once("DB_config.php");
    require_once("DB_class.php");
	
	//設定PHP執行時間限制
	set_time_limit(0);
	
	//取得檔案路徑
	$path = "G:\\海洋工作\\資料庫\\DATA\\航次\\CruiseDB\\nav\\OR3\*.nav";
	$path =  iconv('UTF-8','Big5', $path);
	$filepathList = glob($path);
	
	//連線資料庫
	$db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	
	//for loop所有sub file
	$len = count($filepathList); 
	echo $len;
	for($i=0 ; $i<$len ; $i=$i+1){
		//去除完整路徑
		$filepath = basename($filepathList[$i]);
		$tname = substr($filepath,0,-4);//去除副檔名	
		$tname = str_replace("-","_",$tname);//取代減號
		echo $tname;

		//建立資料表
		//$sqlstr="use $dbname";
		//$db->query($sqlstr);
		$sqlstr="create table IF NOT EXISTS $tname(ID int NOT NULL AUTO_INCREMENT PRIMARY KEY, Longitude float, Latitude float, Date int, Time int, Voyage char(12))";
		$db->query($sqlstr);
		echo "資料表建立成功";
		
		//Insert Data
		$path =  $filepathList[$i];
		//echo $path;
		$db->query("SET NAMES utf8");
		$sqlStr="insert into $tname(Longitude,Latitude,Date,Time,Voyage) values";
        
		$file = fopen($path, "r");
		$count = 0;
		// Read the file line by line until the end
		while (($data = fgetcsv($file, 1000, " ")) !== FALSE){
				$Longitude = $data[0];
				$Latitude = $data[1];
				$Date = $data[2];
				$Time = $data[3];
				$Voyage = $data[4];
				//echo $Longitude . "<br />" . $Voyage . "<br />\n" ;

				//insert to DB
				$sqlStr.=" ($Longitude,$Latitude ,$Date,$Time,'$Voyage'),";
				$count = $count + 1;
				//if ($count >1000)
				//   break;
		}
		$sqlStr = substr($sqlStr,0,-1);  //delete last char
		//echo $sqlStr;
		$db->query($sqlStr);
		echo " insertDB Successfully!<br>  ";
		
		fclose($file);
	}
	echo "OVER!!!<br>  ";

?>