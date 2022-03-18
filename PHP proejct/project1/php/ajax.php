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
            case 'deleteuser':
                if(!isset($_POST['uid']) || trim($_POST['uid']) == "" ){
                    echo 0;
                    return;
                }
                $res = $mysql->where('idattendee='.$_POST['uid'])->delete('attendee');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'deletevenue':
                if(!isset($_POST['idvenue']) || trim($_POST['idvenue']) == "" ){
                    echo 0;
                    return;
                }
                $res = Venue::delete($_POST['idvenue']);
                //$mysql->where('idvenue='.$_POST['idvenue'])->delete('venue');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'deleteevent':
                if(!isset($_POST['idevent']) || trim($_POST['idevent']) == "" ){
                    echo 0;
                    return;
                }
                $res = $mysql->where('idevent='.$_POST['idevent'])->delete('event');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'deletesession':
                if(!isset($_POST['idsession']) || trim($_POST['idsession']) == "" ){
                    echo 0;
                    return;
                }
                $res = $mysql->where('idsession='.$_POST['idsession'])->delete('session');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'deleteattendee':
                if(!isset($_POST['session']) || trim($_POST['session']) == "" ){
                    echo 0;
                    return;
                }
                if(!isset($_POST['attendee']) || trim($_POST['attendee']) == "" ){
                    echo 0;
                    return;
                }
                $data = array(
                    'attendee'=>$_POST['attendee'],
                    'session'=>$_POST['session']
                );
                $res = $mysql->where($data)->delete('attendee_session');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'deletemanager':
                if(!isset($_POST['event']) || trim($_POST['event']) == "" ){
                    echo 0;
                    return;
                }
                if(!isset($_POST['manager']) || trim($_POST['manager']) == "" ){
                    echo 0;
                    return;
                }
                $data = array(
                    'manager'=>$_POST['manager'],
                    'event'=>$_POST['event']
                );
                $res = $mysql->where($data)->delete('manager_event');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;
            
            default:
                echo 0;
                break;
        }
    }else{
        echo 0;
    }



 ?>