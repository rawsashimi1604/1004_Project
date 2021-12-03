<?php
class DBController {
//	private $host = "localhost";
//	private $user = "sqldev";
//	private $password = "P@ssw0rd";
//	private $database = "world_of_pets";
	private $conn;
        private $config;
        
	
    function __construct() {
        $this->conn = $this->connectDB();
	}	
	
    function connectDB() {
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'],
        $config['password'], $config['dbname']);
        if ($conn->connect_error){
            $errorMsgDB = "Connection failed: " . $conn->connect_error;
            $success = false;
            alert($errorMsgDB);
        }
        else{
            return $conn;
        }

    }
	
    function runBaseQuery($query) {
        $result = mysqli_query($this->conn,$query);
        while($row=mysqli_fetch_assoc($result)) {
        $resultset[] = $row;
        }		
        if(!empty($resultset)){
            return $resultset;
        }
        else{
            $errorMsgDB = "Looks like there's nothing here..";
            echo '<script>alert($errorMsgDB)</script>';
        }
    }
    
    
    
    function runQuery($query, $param_type, $param_value_array) {
        
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        
        if(!empty($resultset)) {
            return $resultset;
        }
        else{
            $errorMsgDB = "Looks like there's nothing here..";
            alert($errorMsgDB);
        }
    }
    
    
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array($sql,'bind_param'), $param_value_reference);
    }
    
    //Insert into DB with query statement, type of each param 'sss', array() of param to be queried
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
    
    //Update DB with query statement, type of each param 'sss', array() of param to be queried
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
    }
}
?>