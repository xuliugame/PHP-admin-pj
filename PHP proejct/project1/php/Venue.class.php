<?php
class Venue{
	private $idvenue, $name, $capacity;

    // name: Table Name, key: Primary Key (can be an array), auto: AUTO_INCREMENT field
    protected static $_table = array('name' => 'venue', 'key' => 'idvenue', 'auto' => 'idvenue');
    // relationships between PHP properties and MySQL field names
    protected static $_propertyList = array('idvenue' => 'idvenue', 'name' => 'name', 'capacity' => 'capacity');

    // A method that fetches all venues as an array
    public static function GetAll() {
    	$mysql = new MMysql();
        $dbh = $mysql->getDbh();
        $sql = 'SELECT * FROM venue';
        $pdostmt = $dbh->prepare($sql); 
        $pdostmt->execute();
        $venues = array();
        while ($ve = $pdostmt->fetchObject(__CLASS__)) {
            $venues[] = $ve;
        }
        return $venues;
    }

    public static function save($data) {
    	$mysql = new MMysql();
        $dbh = $mysql->getDbh();
        $sql = "INSERT INTO venue (`idvenue`, `name`, `capacity`) VALUES (null,'".$data['name']."','".$data['capacity']."')";
        return $dbh->exec($sql);
    }

    public static function update($data) {
    	$mysql = new MMysql();
        $dbh = $mysql->getDbh();
        $sql = "UPDATE venue SET `name`='".$data['name']."', `capacity` = '".$data['capacity']."' WHERE idvenue=".$data['idvenue'];
        return $dbh->exec($sql);
    }

    public static function delete($id) {
    	$mysql = new MMysql();
        $dbh = $mysql->getDbh();
        $sql = "DELETE FROM venue WHERE idvenue =".$id;
        return $dbh->exec($sql);
    }

    public function getId(){
    	return $this->idvenue;
    }
    public function getName(){
    	return $this->name;
    }
    public function getCap(){
    	return $this->capacity;
    }
}
?>