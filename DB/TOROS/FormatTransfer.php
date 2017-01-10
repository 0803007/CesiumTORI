<?php
   //將TOROS格式轉換為Wind格式
   //input *.tuv
   //process Format Tranfers
   //output wind-data.js
   	header("Content-Type:text/html; charset=UTF-8");
	
   	//設定PHP執行時間限制	
	set_time_limit(0);
	
   	//取得檔案路徑
	$path = "G:\\海洋工作\\資料庫\\DATA\\TOROS\\201611\\TOTL_TORO_2016_11_01_0000.tuv";
	$path =  iconv('UTF-8','Big5', $path);
	$file = fopen($path, "r");
	
	$x0 = 118.86863;
	$y0 = 21.24821;
	$x1 = 123.19411;
	$y1 =  25.95134;
	$gridWidth = 501.0;
	$gridHeight = 237.0;
	$wInterval = 0.005;
	$hInterval = 0.007;
	$fieldX = [];
	$fieldY = [];
	
	$Longitude = [];
	$Latitude = [];
	$Ucomp = [];
	$Vcomp = [];
	$Velocity = [];
	$Diff = 1;
	$indexDiff = 0;
	//scan line
	$count = 0;
	
	while (($data = fgets($file)) !== false){

		if (substr($data , 0, 1) == "%"){
			continue;
		}
		//前處理
		$data = trim($data);    //delete first space  &end space
		$data = preg_replace("/\s(?=\s)/","\\1",$data);  //// 移除非空白的間距變成一般的空白
		$dataArray = explode(" ", $data);

		//Get Source Array
		array_push($Longitude,$dataArray[0]);
		array_push($Latitude,$dataArray[1]);
		array_push($Ucomp,$dataArray[2]);
		array_push($Vcomp,$dataArray[3]);
		array_push($Velocity,$dataArray[12]);
		$count = $count + 1;
	
	}
	$temp = 0;
	$temp2 = 0;
	$temp3 = 0;
	$indexDiff = 0;
	for ($i=$x0;$i<$x1;$i=$i+$wInterval){
		for ($j=$y0;$j<$y1;$j=$j+$hInterval){
			
			for ($len=0;$len<$count;$len=$len+1 ){
				
				$temp = pow(($Longitude[$len]-$i),2);
				
				$temp2 = pow($Latitude[$len]-$j,2);
				$temp3 = pow($temp-$temp2,-2);
				
				if ($temp3 < $Diff){
					$indexDiff = $len;
					$Diff = $temp3;
				}
			}
			
			if ($Diff<1 ){
				array_push($fieldX,$Longitude[$indexDiff]);
				array_push($fieldY,$Latitude[$indexDiff]);
			}
			
		}
	}
	echo $fieldX;
	//echo $fieldY;
?>

