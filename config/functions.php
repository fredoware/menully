<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$error = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '';
$success = (isset($_GET['success']) && $_GET['success'] != '') ? $_GET['success'] : '';
function get_query_string($keyword, $default){
	return (isset($_GET[$keyword]) && $_GET[$keyword] != '') ? $_GET[$keyword] : $default;
}
function get_session($keyword, $default){
	return (isset($_SESSION[$keyword]) && $_SESSION[$keyword] != '') ? $_SESSION[$keyword] : $default;
}

function format_money($value){
	return "₱" . number_format($value, 2, '.', ',');
}
function format_date($originalDate){
 	return date("M d,Y", strtotime($originalDate));
}

function format_time($time){
 	return date('h:i a', strtotime($time));
}

function days_hours_left($dateTime){
	//Convert to date
	// $dateTime="2011-09-23 19:10:18";//Your date
	$date=strtotime($dateTime);//Converted to a PHP date (a second count)

	//Calculate difference
	$diff=$date-time();//time returns current time in seconds
	$days=floor($diff/(60*60*24));//seconds/minute*minutes/hour*hours/day)
	$hours=round(($diff-$days*60*60*24)/(60*60));

	//Report
	if ($days>0) {
		$result = "Expiring $days days $hours hours left";
	}
	else if ($days==0){
		$result = "Expiring $hours hours left";
	}
	else{
		$result = "Expired";
	}
	return $result;
}

function char_limit($x, $length){
	$result = $x;
  if(strlen($x)<=$length)
  {
    $result = $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    $result = $y;
  }

	return $result;
}

function rand_string($length)
{
   $string = "";
   $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   $size = strlen($chars);
   for ($i = 0; $i < $length; $i++) {
       $string .= $chars[rand(0, $size - 1)];
   }
   return $string;
}


function total_order_amount($orderNumber, $storeId){
    $result = 0;

    foreach (orderItem()->list("orderNumber='$orderNumber' and storeId=$storeId") as $row) {
		
		$checkVar = variation()->count("Id=$row->varId");
		$varPrice = 0;
		if ($checkVar) {
			$var = variation()->get("Id=$row->varId");
			$varPrice = $var->price;
		}
      $result += $varPrice*$row->quantity;
    }

    return $result;
  }

function deviceFingerPrint()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $acceptLanguage = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $ipAddress = $_SERVER['REMOTE_ADDR'];

    $fingerprint = $userAgent . $acceptLanguage . $ipAddress;

    return md5($fingerprint);
}


function general_link($link){
	$url = "";
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
		$url = "http://localhost/menully/";
      }
      
      // Local production
      if ($_SERVER['HTTP_HOST'] == 'www.menully.com' || $_SERVER['HTTP_HOST'] == 'menully.com' || $_SERVER['HTTP_HOST'] == 'admin.menully.com') {
		$url = "https://menully.com/";
      }


	return $url . $link;
}


function get_ratings($star){
	include "widgets/ratings.widget.php";
  }

/* =====================================Functions===================================== */
function send_message($number,$message){
		$ch = curl_init();
		$itexmo = array('1' => $number, '2' => $message, '3' => 'TR-FREDG563327_4I6RV', 'passwd' => '$]najkmlh!');
		curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($itexmo));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		return curl_exec ($ch);
		curl_close ($ch);
}

function uploadImage($uploadedImage, $dir){
	$maxDim = 300;
	$tempName = $uploadedImage['tmp_name'];
	$target_path = "../../media/" . $dir . "/";

	$newfilename = round(microtime(true)) . ".png";
	if(move_uploaded_file($tempName, $target_path . $newfilename)) {
			return $dir ."/". $newfilename;
		}
		else{
			return 0;
		}
}

function uploadCsv($uploadedImage, $dir){
	$maxDim = 300;
	$tempName = $uploadedImage['tmp_name'];
	$target_path = "../../media/" . $dir . "/";

	$newfilename = round(microtime(true)) . ".csv";
	if(move_uploaded_file($tempName, $target_path . $newfilename)) {
			return $dir ."/". $newfilename;
		}
		else{
			return 0;
		}
}

function uploadFile($uploadedImage, $dir){
	$maxDim = 300;
	$tempName = $uploadedImage['tmp_name'];
	$target_path = "../media/" . $dir . "/";

	// // Start Resizing
	// list($width, $height, $type, $attr) = getimagesize( $tempName );
	// if ( $width > $maxDim || $height > $maxDim ) {
	// 		$target_filename = $tempName;
	// 		$ratio = $width/$height;
	// 		if( $ratio < 1) {
	// 				$new_width = $maxDim;
	// 				$new_height = $maxDim/$ratio;
	// 		} else {
	// 				$new_width = $maxDim*$ratio;
	// 				$new_height = $maxDim;
	// 		}
	// 		$src = imagecreatefromstring( file_get_contents( $tempName ) );
	// 		$dst = imagecreatetruecolor( $new_width, $new_height );
	// 		imagecopyresampled( $dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
	// 		imagedestroy( $src );
	// 		imagepng( $dst, $target_filename ); // adjust format as needed
	// 		imagedestroy( $dst );
	// // End Resizing
	// }

	$newfilename = round(microtime(true)) . ".png";
	if(move_uploaded_file($tempName, $target_path . $newfilename)) {
			return $dir ."/". $newfilename;
		}
		else{
			return 0;
		}
}
/* =====================================Functions===================================== */
/* Retrieve one record */
// function uploadFile($uploadedFile, $dir){
// 	// Where the file is going to be placed
// 	$target_path = "../media/" . $dir . "/";
// 	/* Add the original filename to our target path.
// 	Result is "uploads/filename.extension" */
// 	// $target_path = $target_path . basename( $uploadedFile['name']);
// 	$temp = explode(".", $uploadedFile["name"]);
// 	$newfilename = round(microtime(true)) . $uploadedFile["name"];
// 	if(move_uploaded_file($uploadedFile['tmp_name'], $target_path . $newfilename)) {
// 			return $dir ."/". $newfilename;
// 		}
// 		else{
// 			return 0;
// 		}
// }

// function uploadFile($uploadedFile){
// 	// Where the file is going to be placed
// 	$target_path = "../media/";
// 	/* Add the original filename to our target path.
// 	Result is "uploads/filename.extension" */
// 	// $target_path = $target_path . basename( $uploadedFile['name']);
// 	$temp = explode(".", $uploadedFile["name"]);
// 	$newfilename = round(microtime(true)) . $uploadedFile["name"];
// 	if(move_uploaded_file($uploadedFile['tmp_name'], $target_path . $newfilename)) {
// 			return $newfilename;
// 		}
// 		else{
// 			return 0;
// 		}
// }
/* Retrieve one record */
function uploadMultipleFile($uploadedFile){
	$filenameList = array();
	$countfiles = count($uploadedFile['name']);
	if ($countfiles>0){
		for($i=0;$i<$countfiles;$i++){
			// File name
		   	$filename = $uploadedFile['name'][$i];
		   	// Get extension
	  		 $ext = explode(".", $filename);
			 	 $newfilename = round(microtime(true)*($i+1)) . '.' . end($ext);
			   if(move_uploaded_file($uploadedFile['tmp_name'][$i],'../../media/'.$newfilename)){
			   		$filenameList[] = $newfilename;
				}
				else{
			   		$filenameList['error'] = true;
				}
		}
			return $filenameList;
	}
	else{
			return false;
	}
}
?>