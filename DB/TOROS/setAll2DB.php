<?php
	//INPUT:手動寫入月份
	//PROCSEE:將資料夾內的檔案寫入同一個table
	//OUTPUT:無

	header("Content-Type:text/html; charset=UTF-8");
	
	require_once("DB_config.php");
    require_once("DB_class.php");
	
	//設定PHP執行時間限制
	set_time_limit(0);
	
	//設定table name
	$name = "201508";
	$tname = "toros_$name";
	
	//取得檔案路徑
	$path = "G:\\海洋工作\\資料庫\\DATA\\TOROS\\$name\\*.tuv";
	$path =  iconv('UTF-8','Big5', $path);
	$filepathList = glob($path);
	
	//連線資料庫
	$db = new DB();
    $db->connect_db($_DB['host'], $_DB['username'], $_DB['password'], $_DB['dbname']);
	
	//用船的代號建立資料表
	$sqlstr="create table IF NOT EXISTS $tname(ID int NOT NULL AUTO_INCREMENT PRIMARY KEY, Datetime datetime, Longitude float, Latitude float, Ucomp float, Vcomp float, Velocity float, INDEX (datetime))";
	$db->query($sqlstr);
	echo "資料表建立成功";	
	
	//for loop所有sub file
	$len = count($filepathList); 
	echo $len;
	for($i=0 ; $i<$len ; $i=$i+1){		
		//Insert Data
		$path =  $filepathList[$i];
		echo $path;
		//echo $path;
		$db->query("SET NAMES utf8");
		$sqlStr="insert into $tname(Datetime, Longitude, Latitude, Ucomp, Vcomp , Velocity) values";
        
		$file = fopen($path, "r");
		
		$count = -1;
		$datetime = "2000-10-01 00:00:00";
		// Read the file line by line until the end
		//while (($data = fgets($file, 1000)) !== FALSE){
		while (($data = fgets($file)) !== false){
			$count = $count + 1;
			if ($count==6){
				$data = trim($data);    //delete first space  &end space
				$data = preg_replace("/\s(?=\s)/","\\1",$data);  /// 移除非空白的間距變成一般的空白
				$dataArray = explode(" ", $data);
				
				$datetime = "$dataArray[1]-$dataArray[2]-$dataArray[3] $dataArray[4]:$dataArray[5]:$dataArray[6]";
			}
			if (substr($data , 0, 1) == "%"){
				continue;
			}
			$data = trim($data);    //delete first space  &end space
			$data = preg_replace("/\s(?=\s)/","\\1",$data);  //// 移除非空白的間距變成一般的空白
			$dataArray = explode(" ", $data);
			//echo $dataArray[0];
			$Longitude = $dataArray[0];
			$Latitude = $dataArray[1];
			$Ucomp = $dataArray[2];
			$Vcomp = $dataArray[3];
			$Velocity = $dataArray[12];
			//echo $Longitude . "<br />" . $Voyage . "<br />\n" ;

			//insert to DB
			//$sqlStr.=" ('2016-11-01 00:00:00', $Longitude, $Latitude, $Ucomp, $Vcomp, $Velocity),";
			$sqlStr.=" ('$datetime', $Longitude, $Latitude, $Ucomp, $Vcomp, $Velocity),";
		}
		//判斷檔案是否是空 決定是否寫入SQL
		if ($count > 26) {
			$sqlStr = substr($sqlStr,0,-1);  //delete last char
			//echo $sqlStr;
			$db->query($sqlStr);
			echo "Successfu!<br>";
		}else{
			echo "Empty Eile!<br>";
		}
		// Close the file that no longer in use
		fclose($file);
	}
	echo "OVER!!!<br>  ";

?>