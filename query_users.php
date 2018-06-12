<?php
    include_once("dbConnect.php");
    if(!isset($_POST['pre_name']))
        die("Name not found");
    
    
    $pre_name = preg_replace("/\s+/",' ',trim($_POST['pre_name']));
    $pre_name = explode(' ',$pre_name);
    $words = array();
    for ($i=0; $i<count($pre_name);$i++){
        array_push($words,"%".$pre_name[$i] ."%");
        array_push($words,"%".$pre_name[$i] ."%");
    }

    $aux = array();
    for ($i=0; $i<count($words);$i++){
        array_push($aux,$words[$i]);
    }
    $type = "ss";
    $sql = "Select concat(lastname,' ',firstname) as 'Name', id_user as 'Id', address from users where lower(lastname) like lower(?) or lower(firstname) like lower(?)";
    for($i=1;$i<count($pre_name);$i++){
        $type.="ss";
        $sql.= " or lower(lastname) like lower(?) or lower(firstname) like lower(?)";
    }

    if(!($stmt=$conn->prepare($sql))){
        echo json_encode(array("error"=>("Could not post your report. ".$conn->error)));
        die();        
    }
    @call_user_func_array(array($stmt,"bind_param"),array_merge(array($type),$words));
    $stmt -> execute();
    $users = array();
    if($result = $stmt->get_result()){
        while($row = $result->fetch_assoc()){
            $user = new \stdClass();
            $user->name = $row['Name'];
            $user->id_user = $row['Id'];
            $user->address = $row['address'];
            array_push($users,$user);
        }
    }
    $stmt -> close();
    if(count($users) === 0)
        echo json_encode(array("status"=> "null", "result" => array()));
    else
        echo json_encode(array("status" => "users", "result" => $users));
?>   