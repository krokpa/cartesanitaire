<?php

use App\Http\Controllers\Web\_GuzzleController;
use Illuminate\Support\Facades\Storage;

function crypter($string, $action = 'encrypt', $password='') {
    // you may change these values to your own
        //$secret_key = 'my_simple_secret_key';
        //$secret_iv = 'my_simple_secret_iv';

        $secret_key = 'my_simple_secret_key2018';
        $secret_iv = 'my_simple_secret_iv2018';
        $troncate = $string;
        ///var_dump($troncate);
     
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
     
        if( $action == 'encrypt' ) {
            $output = base64_encode(openssl_encrypt($troncate, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($troncate), $encrypt_method, $key, 0, $iv );
        }
     
        return $output;
}

function saveLog($exception) {

    $logFileName = "public/files/errlog/" . date('y') . date('m')  . date('d') . date('H') . '_errlog.log';
    Storage::append($logFileName, json_encode(['date' => now(), 'desc' => $exception ?? []]));
   
}

function myRandomInts($quantity, $max){
    $numbers = array();
    while(sizeof($numbers) < $quantity) {
      //set.add(Math.floor(Math.random() * max) + 1)
      $numbers[] = floor(random() * $max) + 1;
    }
    shuffle($numbers);
    return ($numbers);
}

function random() {
    return mt_rand() / (mt_getrandmax() + 2);
  }

function extractPropertyFromArray($array, $property)
{
    $newarray = array_map(function($e) use ($property) {
        return is_object($e) ? $e->{'$property'} : $e[$property ?? ""];
    }, $array);

    return $newarray;
}

    function diceCoefficient($str1='', $str2='')
{
    $str1_length = strlen($str1);
    $str2_length = strlen($str2);

    // Length of the string must not be equal to zero
    if ( ($str1_length==0) OR ($str2_length==0) )
        return 0;

    $ar1 = array();
    $ar2 = array();
    $intersection = 0;

    // find the pair of characters
    for ($i=0 ; $i<($str1_length-1) ; $i++)
        $ar1[] = substr($str1, $i, 2);

    for ($i=0 ; $i<($str2_length-1) ; $i++)
        $ar2[] = substr($str2, $i, 2);

    // find the intersection between the two sets
    foreach ($ar1 as $pair1) {
        foreach ($ar2 as $pair2) {
            if ($pair1 == $pair2)
                $intersection++;
        }
    }

    $count_set = count($ar1) + count($ar2);
    $dice = (2 * $intersection) / $count_set;
    return $dice;
}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function performCurlRequest($targetUrl, $postdata, $requestVerb, $authorization = null, $followLocation = 0, $returnTransfer = 1) {

    //header('Content-Type: application/json');
   // echo $postdata; die();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_URL, $targetUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestVerb);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, $returnTransfer);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followLocation);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if(!is_null($authorization)){
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization,'Content-Type: application/json'));
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

    
    if ($followLocation == 0) {
        $outputData = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch); 
        return array('data'=>$outputData,'error'=>$error);
    }else{
        $outputData = curl_exec($ch);
        curl_close($ch);
        //return $outputData;
        //die();
    }

}


function parseCurlJson($data) {

    if($data['error'] == ""){

        return json_decode($data['data']);
        
    }

    return false;
}

function findObjectPropertyByName($propName, $arrayOfObjects)
{
  $array = array_filter($arrayOfObjects, function ($obj) use ($propName) {
    return array_key_exists('NotificationBody', get_object_vars($obj));
  });

  if (!empty($array)) {
    return $array[0];
  }

  return null;
}

/**
 * Function that groups an array of associative arrays by some key.
 * 
 * @param {String} $key Property to sort by.
 * @param {Array} $data Array that stores multiple associative arrays.
 */
function group_by_object($key, $data) {
    $result = array();

    $data = $data?? [];
    foreach($data as $val) {
        if(array_key_exists($key, (array)$val)){
            //dd($val);
            $result[$val->$key][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}

/**
 * Function that groups an array of associative arrays by some key.
 * 
 * @param {String} $key Property to sort by.
 * @param {Array} $data Array that stores multiple associative arrays.
 */
function group_by_array($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}

function callModel($model,$methodName,$data = [],$decodeJson=false,$hasData=true) {

    $guzzleObject = new _GuzzleController();
    if ($decodeJson) {
        if ($hasData) {
            return json_decode($guzzleObject->callApiWeb(get_class($model), $methodName, $data)->content(),$decodeJson)['data'] ?? []; 
        }
        return json_decode($guzzleObject->callApiWeb(get_class($model), $methodName, $data)->content(),$decodeJson) ?? []; 
    }
    if ($hasData) {
        return json_decode($guzzleObject->callApiWeb(get_class($model), $methodName, $data)->content(),$decodeJson)->data ?? []; 
    }
    return json_decode($guzzleObject->callApiWeb(get_class($model), $methodName, $data)->content(),$decodeJson) ?? []; 

}

/** 
 * retourne l'abreviation d'un mois donné
 * 
 * @return Mixed 
 */ 
function getMonthNameAbr($date){
    $montharray = explode('-',$date);
    $month = $montharray[1];

    switch ($month) {
        case 1:
            return "JANV";
            break;
        case 2:
            return "FEV";
            break; 
        case 3:
            return "MARS";
            break; 
        case 4:
            return "AVR";
            break; 
        case 5:
            return "MAI";
            break; 
        case 6:
            return "JUIN";
            break; 
        case 7:
            return "JUIL";
            break; 
        case 8:
            return "AOUT";
            break; 
        case 9:
            return "SEPT";
            break;
        case 10:
            return "OCT";
            break; 
        case 11:
            return "NOV";
            break; 
        case 12:
            return "DEC";
            break;
        
        default:
                return "INCONNU";
            break;
    }
}

/** 
 * retourne l'abreviation d'un mois donné
 * 
 * @return Mixed 
 */ 
function getMonthNameAbr2($date){
    $montharray = explode('-',$date);
    $month = $montharray[0];

    switch ($month) {
        case 1:
            return "JANV";
            break;
        case 2:
            return "FEV";
            break; 
        case 3:
            return "MARS";
            break; 
        case 4:
            return "AVR";
            break; 
        case 5:
            return "MAI";
            break; 
        case 6:
            return "JUIN";
            break; 
        case 7:
            return "JUIL";
            break; 
        case 8:
            return "AOUT";
            break; 
        case 9:
            return "SEPT";
            break;
        case 10:
            return "OCT";
            break; 
        case 11:
            return "NOV";
            break; 
        case 12:
            return "DEC";
            break;
        
        default:
                return "INCONNU";
            break;
    }
}


/** 
 * retourne le mois entier en lettre
 * 
 * @return Mixed 
 */ 
function getFullMonthName($date){
    $montharray = explode('-',$date);
    $month = $montharray[1];

    switch ($month) {
        case 1:
            return "JANVIER";
            break;
        case 2:
            return "FEVIER";
            break; 
        case 3:
            return "MARS";
            break; 
        case 4:
            return "AVRIL";
            break; 
        case 5:
            return "MAI";
            break; 
        case 6:
            return "JUIN";
            break; 
        case 7:
            return "JUILLET";
            break; 
        case 8:
            return "AOUT";
            break; 
        case 9:
            return "SEPTEMBRE";
            break;
        case 10:
            return "OCTOBRE";
            break; 
        case 11:
            return "NOVEMBRE";
            break; 
        case 12:
            return "DECEMBRE";
            break;
        
        default:
                return "INCONNU";
            break;
    }
}

function dateToFrench($date, $format)
	{
	    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
	    $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
	    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
	    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
	}