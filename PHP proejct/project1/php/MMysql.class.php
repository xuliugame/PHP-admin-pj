<?php
/**
 * Desc: Database functionality abstracted into separate class
 * Date: 2020/09/25
 * connect schema：PDO
 */
 
class MMysql {
     
    protected static $_dbh = null; 
    protected $_dbType = 'mysql';
    protected $_pconnect = true; //Whether to use long connection
    protected $_host = 'localhost';
    protected $_port = 3306;
    protected $_user = 'xxl7750';
    protected $_pass = 'Phrthe9&alleghenies';
    protected $_dbName = "xxl7750"; //database name
    protected $_sql = false; // is last sql
    protected $_where = '';
    protected $_order = '';
    protected $_limit = '';
    protected $_field = '*';
    protected $_clear = 0; //status，0:lean search，1:dirty search
    protected $_trans = 0; //Number of transaction
    /**
     * init class
     * @param array $conf database conf
     */
    public function __construct() {
        class_exists('PDO') or die("PDO: class not exists.");
        // connect database
        if ( is_null(self::$_dbh) ) {
            $this->_connect();
        }
    }
    /*public function __construct(array $conf) {
        class_exists('PDO') or die("PDO: class not exists.");
        $this->_host = $conf['host'];
        $this->_port = $conf['port'];
        $this->_user = $conf['user'];
        $this->_pass = $conf['passwd'];
        $this->_dbName = $conf['dbname'];
        // connect database
        if ( is_null(self::$_dbh) ) {
            $this->_connect();
        }
    }*/

    public function getDbh(){
        if ( is_null(self::$_dbh) ) {
            $this->_connect();
        }
        return self::$_dbh;
    }
     
    /**
     * connect function
     */
    protected function _connect() {
        $dsn = $this->_dbType.':host='.$this->_host.';port='.$this->_port.';dbname='.$this->_dbName;
        $options = $this->_pconnect ? array(PDO::ATTR_PERSISTENT=>true) : array();
        try { 
            $dbh = new PDO($dsn, $this->_user, $this->_pass, $options);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //设置如果sql语句执行错误则抛出异常，事务会自动回滚
            $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果(防SQL注入)
        } catch (PDOException $e) { 
            die('Connection failed: ' . $e->getMessage());
        }
        $dbh->exec('SET NAMES utf8');
        self::$_dbh = $dbh;
    }
 
    /** 
    * Add ` symbol to field and table names
    * Ensure that there is no error in the use of keywords in the instruction. For mysql
    * @param string $value 
    * @return string 
    */
    protected function _addChar($value) { 
        if ('*'==$value || false!==strpos($value,'(') || false!==strpos($value,'.') || false!==strpos($value,'`')) { 
            //If it contains * or uses the sql method, it will not be processed
        } elseif (false === strpos($value,'`') ) { 
            $value = '`'.trim($value).'`';
        } 
        return $value; 
    }
     
    /** 
    * Get the field information of the data table
    * @param string $tbName table name
    * @return array 
    */
    protected function _tbFields($tbName) {
        $sql = 'SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME="'.$tbName.'" AND TABLE_SCHEMA="'.$this->_dbName.'"';
        $stmt = self::$_dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $ret = array();
        foreach ($result as $key=>$value) {
            $ret[$value['COLUMN_NAME']] = 1;
        }
        return $ret;
    }
 
    /** 
    * Filter and format data table fields
    * @param string $tbName table name
    * @param array $data POST data
    * @return array $newdata 
    */
    protected function _dataFormat($tbName,$data) {
        if (!is_array($data)) return array();
        $table_column = $this->_tbFields($tbName);
        $ret=array();
        foreach ($data as $key=>$val) {
            if (!is_scalar($val)) continue; 
            if (array_key_exists($key,$table_column)) {
                $key = $this->_addChar($key);
                if (is_int($val)) { 
                    $val = intval($val); 
                } elseif (is_float($val)) { 
                    $val = floatval($val); 
                } elseif (preg_match('/^\(\w*(\+|\-|\*|\/)?\w*\)$/i', $val)) {
                    $val = $val;
                } elseif (is_string($val)) { 
                    $val = '"'.addslashes($val).'"';
                }
                $ret[$key] = $val;
            }
        }
        return $ret;
    }
     
    /**
    * query
    * @param string $sql sql
    * @return mixed 
    */
    protected function _doQuery($sql='') {
        $this->_sql = $sql;
        //var_dump($sql);
        $pdostmt = self::$_dbh->prepare($this->_sql); 
        $pdostmt->execute();
        $result = $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
     
    /** 
    * Execute statement For INSERT, UPDATE and DELETE, the exec result returns the number of affected rows
    * @param string $sql sql
    * @return integer 
    */
    protected function _doExec($sql='') {
        $this->_sql = $sql;
        return self::$_dbh->exec($this->_sql);
    }
 
    /** 
    * Execute sql statement, automatically judge to query or perform operation
    * @param string $sql SQL
    * @return mixed 
    */
    public function doSql($sql='') {
        $queryIps = 'INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|LOAD DATA|SELECT .* INTO|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK'; 
        if (preg_match('/^\s*"?(' . $queryIps . ')\s+/i', $sql)) { 
            return $this->_doExec($sql);
        }
        else {
            //query
            return $this->_doQuery($sql);
        }
    }
 
 
    /**
     * insert function
     * @param string $tbName table name
     * @param array $data array of key-value
     * @return int effect row
     */
    public function insert($tbName,array $data){
        $data = $this->_dataFormat($tbName,$data);
        if (!$data) return;
        $sql = "insert into ".$tbName."(".implode(',',array_keys($data)).") values(".implode(',',array_values($data)).")";
        return $this->_doExec($sql);
    }
 
    /**
     * delete function
     * @param string $tbName table name
     * @return int effect row
     */
    public function delete($tbName) {
        //Security considerations prevent the entire table from being deleted
        if (!trim($this->_where)) return false;
        $sql = "delete from ".$tbName." ".$this->_where;
        $this->_clear = 1;
        $this->_clear();
        return $this->_doExec($sql);
    }
  
    /**
     * update function
     * @param string $tbName table name
     * @param array $data array of parameter
     * @return int effect rows
     */
    public function update($tbName,array $data) {
        //Security considerations prevent the entire table from being updated
        if (!trim($this->_where)) return false;
        $data = $this->_dataFormat($tbName,$data);
        if (!$data) return;
        $valArr = '';
        foreach($data as $k=>$v){
            $valArr[] = $k.'='.$v;
        }
        $valStr = implode(',', $valArr);
        $sql = "update ".trim($tbName)." set ".trim($valStr)." ".trim($this->_where);
        return $this->_doExec($sql);
    }
  
    /**
     * query function
     * @param string $tbName table name
     * @return array result set
     */
    public function select($tbName='') {
        $sql = "select ".trim($this->_field)." from ".$tbName." ".trim($this->_where)." ".trim($this->_order)." ".trim($this->_limit);
        $this->_clear = 1;
        $this->_clear();
        return $this->_doQuery(trim($sql));
    }
  
    /**
     * @param mixed $option Two-dimensional array, such as：$option['field1'] = array(1,'=>','or')
     * @return $this
     */
    public function where($option) {
        if ($this->_clear>0) $this->_clear();
        $this->_where = ' where ';
        $logic = 'and';
        if (is_string($option)) {
            $this->_where .= $option;
        }
        elseif (is_array($option)) {
            foreach($option as $k=>$v) {
                if (is_array($v)) {
                    $relative = isset($v[1]) ? $v[1] : '=';
                    $logic    = isset($v[2]) ? $v[2] : 'and';
                    $condition = ' ('.$this->_addChar($k).' '.$relative.' '.$v[0].') ';
                }
                else {
                    $logic = 'and';
                    $condition = ' ('.$this->_addChar($k).'='.$v.') ';
                }
                $this->_where .= isset($mark) ? $logic.$condition : $condition;
                $mark = 1;
            }
        }
        return $this;
    }
  
    /**
     * Set sort
     * @param mixed $option Sort condition array, such as:array('sort'=>'desc')
     * @return $this
     */
    public function order($option) {
        if ($this->_clear>0) $this->_clear();
        $this->_order = ' order by ';
        if (is_string($option)) {
            $this->_order .= $option;
        }
        elseif (is_array($option)) {
            foreach($option as $k=>$v){
                $order = $this->_addChar($k).' '.$v;
                $this->_order .= isset($mark) ? ','.$order : $order;
                $mark = 1;
            }
        }
        return $this;
    }
  
    /**
     * Set the number of query rows and pages
     * @param int $page pagenumber
     * @param int $pageSize 
     * @return $this
     */
    public function limit($page,$pageSize=null) {
        if ($this->_clear>0) $this->_clear();
        if ($pageSize===null) {
            $this->_limit = "limit ".$page;
        }
        else {
            $pageval = intval( ($page - 1) * $pageSize);
            $this->_limit = "limit ".$pageval.",".$pageSize;
        }
        return $this;
    }
  
    /**
     * Set query field
     * @param mixed $field Field array
     * @return $this
     */
    public function field($field){
        if ($this->_clear>0) $this->_clear();
        if (is_string($field)) {
            $field = explode(',', $field);
        }
        $nField = array_map(array($this,'_addChar'), $field);
        $this->_field = implode(',', $nField);
        return $this;
    }
  
    /**
     * Clean up mark function
     */
    protected function _clear() {
        $this->_where = '';
        $this->_order = '';
        $this->_limit = '';
        $this->_field = '*';
        $this->_clear = 0;
    }
  
    /**
     * Manually clean up marks
     * @return $this
     */
    public function clearKey() {
        $this->_clear();
        return $this;
    }
 
    /**
    * Start transaction
    * @return void 
    */
    public function startTrans() { 
        if ($this->_trans==0) self::$_dbh->beginTransaction();
        $this->_trans++; 
        return; 
    }
     
    /** 
    * Used for query submission under non-automatic submission status 
    * @return boolen 
    */
    public function commit() {
        $result = true;
        if ($this->_trans>0) { 
            $result = self::$_dbh->commit(); 
            $this->_trans = 0;
        } 
        return $result;
    }
 
    /** 
    * rollback 
    * @return boolen 
    */
    public function rollback() {
        $result = true;
        if ($this->_trans>0) {
            $result = self::$_dbh->rollback();
            $this->_trans = 0;
        }
        return $result;
    }
 
    /**
    * close connect
    */
    public function close() {
        if (!is_null(self::$_dbh)) self::$_dbh = null;
    }
 
}