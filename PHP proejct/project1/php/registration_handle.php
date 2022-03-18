<?php 

	require("./MyUtils.class.php");
    require("./MMysql.class.php");
    MyUtils::login();
    MyUtils::permission(3);

    if(isset($_POST['m'])){
        $mysql = new MMysql();
        $m = MyUtils::senitized($_POST['m']);
        switch ($m) {
        	case 'apply':
        		if(!isset($_POST['session']) || trim($_POST['session']) == "" ){
                    echo 0;
                    return;
                }
                $data = array(
                    'session'=>$_POST['session'],
                    'attendee'=>$_SESSION['id']
                );
                $res = $mysql->insert('registration',$data);
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'deleteapply':
        		if(!isset($_POST['idregistration']) || trim($_POST['idregistration']) == "" ){
                    echo 0;
                    return;
                }
                $res = $mysql->where(array("idregistration"=>$_POST['idregistration']))->delete('registration');
                if($res>0){
                    echo 1;
                }else{
                    echo 0;
                }
                break;

            case 'editapply':
        		if(!isset($_POST['idregistration']) || trim($_POST['idregistration']) == "" ){
                    echo 0;
                    return;
                }
                $res = $mysql->where(array("idregistration"=>$_POST['idregistration']))->update('registration',array("session"=>$_POST['session']));
                if($res>0){
	                MyUtils::error("edit apply successfully", "./registration.php");
	            }else{
	                MyUtils::error("edit apply failed", "./registration.php");
	            }
                break;

            case 'accapply':
        		if(!isset($_POST['idregistration']) || trim($_POST['idregistration']) == "" ){
                    echo 0;
                    return;
                }
                //$res = $mysql->where(array("idregistration"=>$_POST['idregistration']))->update('registration',array("accept"=>1));
                $sql = "UPDATE registration SET accept = 1 WHERE idregistration='".$_POST['idregistration']."'";
                $res=$mysql->doSql($sql);
                if($res){
                    $query = $mysql->where(array("idregistration"=>$_POST['idregistration']))->select("registration");
                    $data = array(
                        'session'=>$query[0]['session'],
                        'attendee'=>$query[0]['attendee']
                    );
                    $res = $mysql->insert('attendee_session',$data); 
                }
                if($res>0){
	                echo 1;
	            }else{
	                echo 0;
	            }
                break;
        	
        	default:
        		# code...
        		break;
        }

    }


 ?>