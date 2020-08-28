<?php 

// setting up connection with PDO
$connection = require_once 'pdo.php';


// setting up the loop for dates from previous month till today
$start = $day = date('Y-m-d');
$end = date('Y-m-d' ,strtotime("+1 month", $day));
function xStringToArray( $xmlString ){
    return json_decode(json_encode($xmlString) ,true);
}


date_default_timezone_set('UTC');

// Start date
$date = date('Y-m-d');
// End date
$end_date = $prevmonth = date('Y-m-d', strtotime('-1 months'));


// Starting the loop and seeding currencies in database 

while (strtotime($date) >= strtotime($end_date)) {
        
            $formatedDate = date('d/m/Y' , strtotime($date));
            echo $formatedDate.'<br>';
            $date = date ("Y-m-d", strtotime("-1 day", strtotime($date)));

 // getting data as xml from CBR
 $todays = file_get_contents('http://www.cbr.ru/scripts/XML_daily_eng.asp?date_req='.$formatedDate );
 $todaysNorm = simplexml_load_string($todays); 

foreach($todaysNorm->Valute as $valuteIndex => $valuteVal){
    $todaysCurrencys = [];
    $todaysCurrencys['date'] = xStringToArray($todaysNorm['Date'])[0];
    $todaysCurrencys['currencyID'] = xStringToArray($valuteVal)['@attributes']['ID'];
    $todaysCurrencys['numCode'] = xStringToArray($valuteVal)['NumCode'];
    $todaysCurrencys['сharCode'] = xStringToArray($valuteVal)['CharCode'];
    $todaysCurrencys['name'] = xStringToArray($valuteVal)['Name'];
    $todaysCurrencys['value'] = xStringToArray($valuteVal)['Value'];


    // method is declared in pdo.php 
    $connection->addCurrency($todaysCurrencys);
  }
}
?>