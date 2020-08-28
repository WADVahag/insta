<?php

class Connection
{
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:server=localhost;dbname=instatest', 'root', 'root');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "ERROR: " . $exception->getMessage();
        }

    }

    public function getCurrency()
    {
        $statement = $this->pdo->prepare("SELECT * FROM currency ORDER BY date DESC");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCurrency($currency)
    {
        echo '<pre>';
        print_r($currency);
        echo '</pre>';
       $c = strval($currency['currencyID']);
        $nC = strval($currency['numCode']);
         $cC = strval($currency['сharCode']);
          $n =strval( $currency['name']); 
          $v = strval($currency['value']); 

          $d = strtotime($currency['date']); 
          $d =  $newDate =  date('Y-m-d', $d)  ;

        $statement = $this->pdo->prepare("INSERT INTO currency (currencyID,numCode,сharCode,name,value,date) VALUES ( '$c' , '$nC' , '$cC' , '$n' , '$v' , '$d')");
        
        return $statement->execute();

    }
}

return new Connection();
