<?php
/*******************************************************************************
* dbManager                                                                    *
*                                                                              *
* Version: 1.1                                                                 *
* Date:    2021-02-02                                                          *
* Autor:  Dert Driver @Dert98                                                       *
*******************************************************************************/

class dbManager {

    private $table;           // Name table 
    private $primaryKey;      // primary key table
    private $conn;            // Save conection with database
    private $sql;             // Save the query prepared for execution
    private $where = 0;       // Check count where
    private $orWhere = 0;     // Check count orWhere

/*******************************************************************************
*                               Public methods                                 *
*******************************************************************************/
    function __construct($table,$primaryKey){
        $config = file_get_contents("../js/config.json");
        $config = json_decode($config, true);
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->conn = $this->setConnection($config);
    }

/************************************
        Create Connection
*************************************/
    public function setConnection($config){
        if (isset($config) && is_array($config)) {
            if(isset($config['server']) && $config['server'] != ""){
                if (isset($config['db_name']) && $config['db_name'] != "") {
                    if (isset($config['user']) && $config['user'] != "") {
                        if (isset($config['pass'])) {
                            $conn = new mysqli($config['server'], $config['user'],$config['pass'], $config['db_name']);
                            if ($conn->connect_error) {
                                die('Error de conexión: ' . $conn->connect_error);
                            }else{
                                return $conn;
                            }                            
                        }else{trigger_error("The password is not defined or is empty.", E_USER_ERROR);exit;}
                    }else{trigger_error("The name of the user is not defined or is empty.", E_USER_ERROR);exit;}
                }else{trigger_error("The name of the database is undefined or empty.", E_USER_ERROR);exit;}
            }else{trigger_error("The server is undefined or empty.", E_USER_ERROR);exit;}
        }else{trigger_error("The expected parameter for the connection must be of type Array.", E_USER_ERROR); exit;} 
    }

/************************************
        Prepare for select
*************************************/
    public function select(){
        $arg = func_get_args();
        $this->sql = 'SELECT ';
        if (func_num_args() == 0) {
            $this->sql .= '* FROM '.$this->table;
        }else{
            if (func_num_args()>1) {
                $this->sql .= implode (',',$arg);
                $this->sql .= ' FROM '.$this->table;
            }else{
                $this->sql .= $arg[0].' FROM '.$this->table;;
            }
        }
        return $this;
    }

/************************************
        Sentence where (AND)
*************************************/
    public function where($column,$condition,$value){
        $arg = [$value];
        $value = $this->insertHelper($arg);
        if ($this->where > 0) {
            $this->sql .= ' AND '.$column.' '.$condition.' '.$value;
        } else {
            $this->sql .= ' WHERE '.$column.' '.$condition.' '.$value;
        }
        $this->where++;
        return $this;
    }

/************************************
        Sentence where (OR)
*************************************/
    public function orWhere($column,$condition,$value){
        $arg = [$value];
        $value = $this->insertHelper($arg);
        if ($this->orWhere > 0) {
            $this->sql .= ' OR '.$column.' '.$condition.' '.$value;
        } else {
            $this->sql .= ' WHERE '.$column.' '.$condition.' '.$value;
        }
        $this->orWhere++;
        return $this;
    }
    

/************************************
        Prepare for JOIN
*************************************/
    public function join($t2,$t2_id,$t1_id){
        if ($t2 != '') {
            if ($t2_id != '') {
                if ($t1_id != '') {
                    $this->sql .= ' JOIN '.$t2.' ON '.$t1_id.' = '.$t2_id;
                    return $this;
                } else {trigger_error("The link is empty.", E_USER_ERROR); exit;}
            } else {trigger_error("The condition is empty.", E_USER_ERROR); exit;}
        }else{trigger_error("The name of the second table is empty.", E_USER_ERROR); exit;}
    }

/************************************
       Execute and obtain array
*************************************/
    public function getArray(){
        $result = mysqli_query($this->conn, $this->sql);
        if ($result) {
            $rows = Array();
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($rows,$row);
            }
            $this->orWhere = 0;
            $this->where = 0;
            $this->sql = "";
            return $rows;
        }
    }

    public function printArray(){
        $result = mysqli_query($this->conn, $this->sql);
        if ($result) {
            $rows = Array();
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="card text-light bg-dark m-4">';
                    print_r($row);
                echo '</div>';
            }
            return $rows;
        }
    }

/************************************
        Prepare for insert
*************************************/
    public function insert(){
        $arg = func_get_args();
        $this->sql = 'INSERT INTO '.$this->table.' VALUES ';
        if (func_num_args() != 0) {
            if (func_num_args()>1) {
                $args = $this->insertHelper($arg);
                $this->sql .= '(null,'.$args.')';
            }
        }else{trigger_error("At least you must assign a parameter to the function.", E_USER_ERROR); exit;}
    }

/************************************
        Prepare for update
*************************************/
    public function update($id_reg,$values){
        $this->sql = 'UPDATE '.$this->table.' SET ';
        $values = json_encode($values);
        $values = str_replace( "{", " ", $values);
        $values = str_replace( "}", " ", $values);
        $values = str_replace( "\":\"", "=", $values);
        $values = str_replace( "\",\"", ",", $values);
        $values = str_replace( "\":", "=", $values);
        $values = str_replace( "\"", "", $values);
        $this->sql .=$values.' WHERE '.$this->primaryKey.' = '.$id_reg;
    }

/************************************
       Execute update or insert
*************************************/
    public function save(){
        $result = $this->conn->query($this->sql);
        if ($result) {
            $data['status'] = true;
            $data['msg'] = '';
        } else {
            $data['status'] = false;
            $data['msg'] = "Error: ".$this->conn->error;
        }
        return $data;
    }

/************************************
            Execute delete
*************************************/    
    public function delete($id_reg){
        $this->sql = 'DELETE FROM '.$this->table.' WHERE '.$this->primaryKey.' = '.$id_reg;
        $result = $this->conn->query($this->sql);
        if ($result) {
            $data['status'] = true;
            $data['msg'] = '';
        } else {
            $data['status'] = false;
            $data['msg'] = "Error: ".$this->conn->error;
        }
        return $data;
    }

/************************************
            Execute query personal
*************************************/ 

    public function qy($qry){
        $this->sql = $qry;
        $result = $this->conn->query($this->sql);
        if ($result) {
            $rows = Array();
            while ($row = mysqli_fetch_array($result)) {
                array_push($rows,$row);
            }
            $this->orWhere = 0;
            $this->where = 0;
            return $rows;
        }
    }

/*************************************
 *        Helpers Functions          *
 *************************************/

    public function insertHelper($args){
        $new_chain = '';
        for ($i=0; $i < sizeof($args); $i++) { 
            switch (gettype($args[$i])) {
                case 'boolean':
                   $new_chain .= $args[$i];
                    break;
                case 'integer':
                   $new_chain .= $args[$i];
                    break;
                case 'double':
                   $new_chain .= $args[$i];
                    break;
                case 'string':
                   $new_chain .= '"'.$args[$i].'"';
                    break;
                default:break;
            }
            if(($i != (sizeof($args)-1))){
                $new_chain .= ",";
            }
        }
        return $new_chain;
    }
    public function buscarUsuario($u){
        $this->sql = 'SELECT * FROM '.$this->table.' WHERE firstname = "'.$u.'"';
        $data = $this->conn->query($this->sql);
        return $data;
    }
    public function close(){
        mysqli_close($this->conn);
    }
    public function setTable($table,$primaryKey){
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        mysqli_close($this->conn);
    }
    public function getRegId($id_reg){
        $this->sql = 'SELECT * FROM '.$this->table.' WHERE '.$this->primaryKey.' = "'.$id_reg.'"';
        $result = $this->conn->query($this->sql);
        foreach ($result as $reg) {
                $data = $reg;            //sacar reg de la posicion 0
        }
        return $data;
    }
 }