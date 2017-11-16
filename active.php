<?php


ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('DATABASE', 'pb435');
define('USERNAME', 'pb435');
define('PASSWORD', 'Qwerty10');
define('CONNECTION', 'sql2.njit.edu');
class dbConn
{

    protected static $db;

    private function __construct()
    {
        try
        {

            self::$db = new PDO( 'mysql:host=' . CONNECTION .';dbname=' . DATABASE, USERNAME, PASSWORD );
            self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch (PDOException $e) {

            echo "Connection Error: " . $e->getMessage();
        }
    }
    public static function getConnection() {

        if (!self::$db) {

            new dbConn();
        }

        return self::$db;
    }
}
class collection {

    static public function findAll()
    {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet;
    }

    static public function findOne($id)
    {
        $db = dbConn::getConnection();
        $tableName = get_called_class();
        $sql = 'SELECT * FROM ' . $tableName . ' WHERE id =' . $id;
        $statement = $db->prepare($sql);
        $statement->execute();
        $class = static::$modelName;
        $statement->setFetchMode(PDO::FETCH_CLASS, $class);
        $recordsSet =  $statement->fetchAll();
        return $recordsSet[0];
    }
}

class accounts extends collection
{
    protected static $modelName = 'account';
}

class todos extends collection
{
    protected static $modelName = 'todo';
}

    class model
    {
    protected $tableName;
    public function save()
     {
        if ($this->id = '')
        {
            $sql = $this->insert();
        }
        else
        {
            $sql = $this->update();
        }

        $db = dbConn::getConnection();
        $statement = $db->prepare($sql);
        $statement->execute();
        $tableName = get_called_class();
        $array = get_object_vars($this);
        $columnString = implode(',', $array);
        $valueString = ":".implode(',:', $array);

        echo 'I just saved record: ' . $this->id;
    }

}

      class account extends model
      {

      }


     class todo extends model
     {
      public $id;
      public $owneremail;
      public $ownerid;
      public $createddate;
      public $duedate;
      public $message;
      public $isdone;
      public function __construct()
       {
        $this->tableName = 'todos';

       }
}

//$records = accounts::findAll();

//$records = todos::findAll();

$record = todos::findOne(3);

//$record = new todo();
//$record->message = 'some task';
//$record->isdone = 0;

print_r($record);
//$record = todos::create();
//print_r($record);

?>
