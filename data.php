<?php
class Data{
    public $manoj;
    public function __construct($hostname, $username, $password, $db_name){
    try{
        $this->manoj=new PDO("mysql:host=$hostname;dbname=$db_name;",$username, $password);
        $this->manoj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }    
    catch(PDOException $e){
echo "something error" . $e->getmessage();
    }    
    }
    public function insert($statement, $params)
    {
        try {
            $this->executeStatment($statement, $params);
            return  $this->manoj->lastInsertId();
        } catch (PDOException $e) {
            echo "Insert Error - " . $e->getMessage();
        }
    }

    public function select($statement){
        try{
          $result=  $this->manoj->query($statement);
            return $result->fetchAll();
        }
        catch(PDOException $e){
            echo "please read again to yourr code" .$e->getmessage();
        }
    }
    public function delete($statement){
        try{
            return $this->manoj->exec($statement);
        }
        catch(PDOException $e){
           echo "not  delete" . $e->getmessage();
        }
    }
    public function selectone($statement){
        try{
            $result=$this->manoj->query($statement);
            return $result->fetch();
        }
        catch (PDOException $e){
            echo "data is not set". $e->getmessage();
        }
    }
    public function update($statement, $params)
    {
        try {
            return $this->executeStatment($statement, $params);
        } catch (PDOException $e) {
            echo "Insert Error - " . $e->getMessage();
        }
    }
    
    private function executeStatment($statement, $params): bool
    {
        $stmt = $this->manoj->prepare($statement);
        return $stmt->execute($params);
    }
}