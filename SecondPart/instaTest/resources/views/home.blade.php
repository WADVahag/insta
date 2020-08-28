@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    
                        <br>
                        <br>
                        <br>
                   
                   <form action="#"  method ='post'>
                    {{ csrf_field() }}
                   
                        <h2> dateFrom </h2> 
                        <input name='dateFrom' class='form-control' required type="date">
                    
                   
                       <h2> dateTo </h2> 
                        <input name='dateTo' class='form-control' required  type="date" >

                        <h2>Currency </h2>
                         <select name="currency_Id" class='form-control'>

                    
                 
<?php  $currencyIds = [
    'R01010' => 'Australian Dollar',
    'R01020A' => 'Azerbaijan Manat',
    'R01035' => 'British Pound Sterling',
    'R01060'=>'Armenia Dram',
    'R01090B' => 'Belarussian Ruble',
    'R01100' => 'Bulgarian lev',
    'R01115' => 'Brazil Real',
    'R01135' => 'Hungarian Forint',
    'R01200' => 'Hong Kong Dollar',
    'R01215' => 'Danish Krone',
    'R01235' => 'US Dollar',
    'R01239' => 'Euro',
    'R01270' => 'Indian Rupee',
    'R01335' => 'Kazakhstan Tenge',
    'R01350' => 'Canadian Dollar',
    'R01370' => 'Kyrgyzstan Som',
    'R01375' => 'China Yuan',
    'R01500' => 'Moldova Lei',
    'R01535' => 'Norwegian Krone',
    'R01565' => 'Polish Zloty',
    'R01585F' => 'Romanian Leu',
    'R01589' => 'SDR',
    'R01625' => 'Singapore Dollar',
    'R01670' => 'Tajikistan Ruble',
    'R01700J' => 'Turkish Lira',
    'R01710A' => 'New Turkmenistan Manat',
    'R01717' => 'Uzbekistan Sum',
    'R01720' => 'Ukrainian Hryvnia',
    'R01760' => 'Czech Koruna',
    'R01770' => 'Swedish Krona',
    'R01775' => 'Swiss Franc',
    'R01810' => 'S.African Rand',
    'R01815' => 'South Korean Won',
    'R01820' => 'Japanese Yen'
    ] ;


 
?>

                    @foreach ($currencyIds as $cid => $cname)
                        
                            <option value='{{ $cid}}'>{{$cname}} </option>

                    @endforeach

                    </select>
                    <hr>
                    <button> Submit</button>
                </form>

                <?php 
                
                function xStringToArray( $xmlString ){
                      return json_decode(json_encode($xmlString) ,true);
                }

                if(!empty($_POST['currency_Id'])){

                    $dateFrom = date('d/m/Y' , strtotime($_POST['dateFrom']));
                    $dateTo = date('d/m/Y' , strtotime($_POST['dateTo']));
                    $currency_Id = $_POST['currency_Id'];
            
                        // getting data as xml from CBR
                    $xmlContent = file_get_contents('http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1='.$dateFrom.'&date_req2='.$dateTo.'&VAL_NM_RQ='.$currency_Id);
                    // $xmlContent = file_get_contents('http://www.cbr.ru/scripts/XML_dynamic.asp?date_req1=02/03/2001&date_req2=14/03/2001&VAL_NM_RQ=R01235');
               
                    $xmlNorm = xStringToArray(simplexml_load_string($xmlContent)); 

                    echo ' <hr > Currencyies for yor range';
                    //  dd($xmlNorm);
                     echo '<table style="border:5px solid grey;"> <tr > <td> Date </td> <td> Price </td> </tr>';
                     foreach($xmlNorm['Record'] as $record){
                        
                         echo '<tr><td> '.xStringToArray($record)['@attributes']['Date'].'</td><td>'.$record['Value'].'</td> </tr>';
                     }
                     echo '</table>';
                    }?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
