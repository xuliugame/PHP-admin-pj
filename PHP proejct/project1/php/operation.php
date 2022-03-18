<?php 
    require("./MyUtils.class.php");
    require("./MMysql.class.php");
    require("./Venue.class.php");
    MyUtils::login();
    MyUtils::permission(2);

if(isset($_POST['m'])){
    $mysql = new MMysql();
    $m = MyUtils::senitized($_POST['m']);
    switch ($m) {
        case 'adduser':
            $name = '';
            $password = '';
            $role = '';
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("name can't be empty","./admin.php");   
            }
            if(!isset($_POST['password']) || trim($_POST['password']) == ""){
                MyUtils::error("password can't be empty","./admin.php");
            }
            if(isset($_POST['role']) && trim($_POST['role']) != ""){
                $role = MyUtils::senitized($_POST['role']);
            }
            $name = MyUtils::senitized($_POST['name']);
            $password = MyUtils::senitized($_POST['password']);
            $password = MyUtils::encrypt_sha256($password);
            $data = array(
                'name'=>$name,
                'password'=>$password,
                'role'=>$role
            );
            $res = $mysql->insert('attendee',$data);
            if($res>0){
                MyUtils::error("add user successfully", "./admin.php");
            }else{
                MyUtils::error("add user failed", "./admin.php");
            }
            break;

        case 'edituser':
            $uid = '';
            $name = '';
            $password = '';
            $role = '';
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("name can't be empty","./admin.php");   
            }
            if(!isset($_POST['password']) || trim($_POST['password']) == ""){
                MyUtils::error("password can't be empty","./admin.php");
            }
            if(isset($_POST['role']) && trim($_POST['role']) != ""){
                $role = MyUtils::senitized($_POST['role']);
            }
            if(!isset($_POST['uid']) || trim($_POST['uid']) == ""){
                MyUtils::error("uid can't be empty","./admin.php");
            }
            $uid = MyUtils::senitized($_POST['uid']);
            $name = MyUtils::senitized($_POST['name']);
            $password = MyUtils::senitized($_POST['password']);
            $password = MyUtils::encrypt_sha256($password);
            $data = array(
                'name'=>$name,
                'password'=>$password,
                'role'=>$role
            );
            $res = $mysql->where(array('idattendee'=>$uid))->update('attendee',$data);
            if($res>0){
                MyUtils::error("edit user successfully", "./admin.php");
            }else{
                MyUtils::error("edit user failed", "./admin.php");
            }
            break;

            case 'addvenue':
            $name = '';
            $capacity = '';
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("venue name can't be empty","./admin.php");   
            }
            if(!isset($_POST['capacity']) || trim($_POST['capacity']) == ""){
                MyUtils::error("capacity can't be empty","./admin.php");
            }
            $name = MyUtils::senitized($_POST['name']);
            $capacity = MyUtils::senitized($_POST['capacity']);
            $data = array(
                'name'=>$name,
                'capacity'=>$capacity
            );
            $res = Venue::save($data);// $mysql->insert('venue',$data);
            if($res>0){
                MyUtils::error("add venue successfully", "./admin.php");
            }else{
                MyUtils::error("add venue failed", "./admin.php");
            }
            break;

        case 'editvenue':
            $idvenue = '';
            $name = '';
            $capacity = '';
            if(!isset($_POST['idvenue']) || trim($_POST['idvenue']) == "" ){
                MyUtils::error("idvenue can't be empty","./admin.php");   
            }
            if(!isset($_POST['name']) || trim($_POST['name']) == ""){
                MyUtils::error("venue name can't be empty","./admin.php");
            }
            if(!isset($_POST['capacity']) || trim($_POST['capacity']) == ""){
                MyUtils::error("capacity can't be empty","./admin.php");
            }
            $idvenue = MyUtils::senitized($_POST['idvenue']);
            $name = MyUtils::senitized($_POST['name']);
            $capacity = MyUtils::senitized($_POST['capacity']);
            $data = array(
                'idvenue'=>$idvenue,
                'name'=>$name,
                'capacity'=>$capacity
            );
            $res = Venue::update($data);//$mysql->where(array('idvenue'=>$idvenue))->update('venue',$data);
            if($res>0){
                MyUtils::error("edit venue successfully", "./admin.php");
            }else{
                MyUtils::error("edit venue failed", "./admin.php");
            }
            break;

        case 'addevent':
            $name = '';
            $datestart = '';
            $dateend = '';
            $numberallowed = '';
            $venue = '';
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("event name can't be empty","./admin.php");   
            }
            if(!isset($_POST['datestart']) || trim($_POST['datestart']) == ""){
                MyUtils::error("datestart can't be empty","./admin.php");
            }
            if(!isset($_POST['dateend']) || trim($_POST['dateend']) == "" ){
                MyUtils::error("dateend can't be empty","./admin.php");   
            }
            if(!isset($_POST['numberallowed']) || trim($_POST['numberallowed']) == ""){
                MyUtils::error("numberallowed can't be empty","./admin.php");
            }
            if(!isset($_POST['venue']) || trim($_POST['venue']) == "" ){
                MyUtils::error("venue id can't be empty","./admin.php");   
            }
            $name = MyUtils::senitized($_POST['name']);
            $datestart = MyUtils::senitized($_POST['datestart']);
            $dateend = MyUtils::senitized($_POST['dateend']);
            $numberallowed = MyUtils::senitized($_POST['numberallowed']);
            $venue = MyUtils::senitized($_POST['venue']);
            $data = array(
                'name'=>$name,
                'datestart'=>$datestart,
                'dateend'=>$dateend,
                'numberallowed'=>$numberallowed,
                'venue'=>$venue
            );
            $res = $mysql->insert('event',$data);
            if($res>0){
                MyUtils::error("add event successfully", "./admin.php");
            }else{
                MyUtils::error("add event failed", "./admin.php");
            }
            break;

        case 'editevent':
            $idevent = '';
            $name = '';
            $datestart = '';
            $dateend = '';
            $numberallowed = '';
            $venue = '';
            if(!isset($_POST['idevent']) || trim($_POST['idevent']) == "" ){
                MyUtils::error("idevent name can't be empty","./admin.php");   
            }
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("event name can't be empty","./admin.php");   
            }
            if(!isset($_POST['datestart']) || trim($_POST['datestart']) == ""){
                MyUtils::error("datestart can't be empty","./admin.php");
            }
            if(!isset($_POST['dateend']) || trim($_POST['dateend']) == "" ){
                MyUtils::error("dateend can't be empty","./admin.php");   
            }
            if(!isset($_POST['numberallowed']) || trim($_POST['numberallowed']) == ""){
                MyUtils::error("numberallowed can't be empty","./admin.php");
            }
            if(!isset($_POST['venue']) || trim($_POST['venue']) == "" ){
                MyUtils::error("venue id can't be empty","./admin.php");   
            }
            $idevent = MyUtils::senitized($_POST['idevent']);
            $name = MyUtils::senitized($_POST['name']);
            $datestart = MyUtils::senitized($_POST['datestart']);
            $dateend = MyUtils::senitized($_POST['dateend']);
            $numberallowed = MyUtils::senitized($_POST['numberallowed']);
            $venue = MyUtils::senitized($_POST['venue']);
            $data = array(
                'name'=>$name,
                'datestart'=>$datestart,
                'dateend'=>$dateend,
                'numberallowed'=>$numberallowed,
                'venue'=>$venue
            );
            $res = $mysql->where(array('idevent'=>$idevent))->update('event',$data);
            if($res>0){
                MyUtils::error("edit event successfully", "./admin.php");
            }else{
                MyUtils::error("edit event failed", "./admin.php");
            }
            break;

        case 'addsession':
            $name = '';
            $startdate = '';
            $enddate = '';
            $numberallowed = '';
            $event = '';
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("session name can't be empty","./admin.php");   
            }
            if(!isset($_POST['startdate']) || trim($_POST['startdate']) == ""){
                MyUtils::error("startdate can't be empty","./admin.php");
            }
            if(!isset($_POST['enddate']) || trim($_POST['enddate']) == "" ){
                MyUtils::error("enddate can't be empty","./admin.php");   
            }
            if(!isset($_POST['numberallowed']) || trim($_POST['numberallowed']) == ""){
                MyUtils::error("numberallowed can't be empty","./admin.php");
            }
            if(!isset($_POST['event']) || trim($_POST['event']) == "" ){
                MyUtils::error("event id can't be empty","./admin.php");   
            }
            $name = MyUtils::senitized($_POST['name']);
            $startdate = MyUtils::senitized($_POST['startdate']);
            $enddate = MyUtils::senitized($_POST['enddate']);
            $numberallowed = MyUtils::senitized($_POST['numberallowed']);
            $event = MyUtils::senitized($_POST['event']);
            $data = array(
                'name'=>$name,
                'startdate'=>$startdate,
                'enddate'=>$enddate,
                'numberallowed'=>$numberallowed,
                'event'=>$event
            );
            $res = $mysql->insert('session',$data);
            if($res>0){
                MyUtils::error("add session successfully", "./admin.php");
            }else{
                MyUtils::error("add session failed", "./admin.php");
            }
            break;

        case 'editsession':
            $idsession = '';
            $name = '';
            $startdate = '';
            $enddate = '';
            $numberallowed = '';
            $event = '';
            if(!isset($_POST['idsession']) || trim($_POST['idsession']) == "" ){
                MyUtils::error("session id can't be empty","./admin.php");   
            }
            if(!isset($_POST['name']) || trim($_POST['name']) == "" ){
                MyUtils::error("event name can't be empty","./admin.php");   
            }
            if(!isset($_POST['startdate']) || trim($_POST['startdate']) == ""){
                MyUtils::error("startdate can't be empty","./admin.php");
            }
            if(!isset($_POST['enddate']) || trim($_POST['enddate']) == "" ){
                MyUtils::error("enddate can't be empty","./admin.php");   
            }
            if(!isset($_POST['numberallowed']) || trim($_POST['numberallowed']) == ""){
                MyUtils::error("numberallowed can't be empty","./admin.php");
            }
            if(!isset($_POST['event']) || trim($_POST['event']) == "" ){
                MyUtils::error("event id can't be empty","./admin.php");   
            }
            $idsession = MyUtils::senitized($_POST['idsession']);
            $name = MyUtils::senitized($_POST['name']);
            $startdate = MyUtils::senitized($_POST['startdate']);
            $enddate = MyUtils::senitized($_POST['enddate']);
            $numberallowed = MyUtils::senitized($_POST['numberallowed']);
            $event = MyUtils::senitized($_POST['event']);
            $data = array(
                'name'=>$name,
                'startdate'=>$startdate,
                'enddate'=>$enddate,
                'numberallowed'=>$numberallowed,
                'event'=>$event
            );
            $res = $mysql->where(array('idsession'=>$idsession))->update('session',$data);
            if($res>0){
                MyUtils::error("edit session successfully", "./admin.php");
            }else{
                MyUtils::error("edit session failed", "./admin.php");
            }
            break;

        case 'addattendee':
            $attendee = '';
            $session = '';
            if(!isset($_POST['attendee']) || trim($_POST['attendee']) == "" ){
                MyUtils::error("session name can't be empty","./admin.php");   
            }
            if(!isset($_POST['session']) || trim($_POST['session']) == ""){
                MyUtils::error("session can't be empty","./admin.php");
            }
            $attendee = MyUtils::senitized($_POST['attendee']);
            $session = MyUtils::senitized($_POST['session']);
            $data = array(
                'attendee'=>$attendee,
                'session'=>$session
            );
            $res = $mysql->insert('attendee_session',$data);
            if($res>0){
                MyUtils::error("add attendee successfully", "./admin.php");
            }else{
                MyUtils::error("add attendee failed", "./admin.php");
            }
            break;

        case 'addattendee':
            $attendee = '';
            $session = '';
            if(!isset($_POST['attendee']) || trim($_POST['attendee']) == "" ){
                MyUtils::error("attendee name can't be empty","./admin.php");   
            }
            if(!isset($_POST['session']) || trim($_POST['session']) == ""){
                MyUtils::error("session can't be empty","./admin.php");
            }
            $attendee = MyUtils::senitized($_POST['attendee']);
            $session = MyUtils::senitized($_POST['session']);
            $data = array(
                'attendee'=>$attendee,
                'session'=>$session
            );
            $res = $mysql->insert('attendee_session',$data);
            if($res>0){
                MyUtils::error("add attendee successfully", "./admin.php");
            }else{
                MyUtils::error("add attendee failed", "./admin.php");
            }
            break;

        case 'addmanager':
            $manager = '';
            $event = '';
            if(!isset($_POST['manager']) || trim($_POST['manager']) == "" ){
                MyUtils::error("manager name can't be empty","./admin.php");   
            }
            if(!isset($_POST['event']) || trim($_POST['event']) == ""){
                MyUtils::error("event can't be empty","./admin.php");
            }
            $manager = MyUtils::senitized($_POST['manager']);
            $event = MyUtils::senitized($_POST['event']);
            $data = array(
                'manager'=>$manager,
                'event'=>$event
            );
            $res = $mysql->insert('manager_event',$data);
            if($res>0){
                MyUtils::error("add manager successfully", "./admin.php");
            }else{
                MyUtils::error("add manager failed", "./admin.php");
            }
            break;

        default:
            MyUtils::error("error operation", "./admin.php");
            break;
    }
}else{
    MyUtils::error("error operation", "./admin.php");
}



 ?>