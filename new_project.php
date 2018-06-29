<?php
 $pdo = new PDO('mysql:host=localhost;dbname=address_book;port=3306;charset=utf8','c0116196','password');
 
 $postData = file_get_contents('php://input');

 $jsonDecode = json_decode($postData,true);

if($_SERVER["REQUEST_METHOD"]!="POST"){
 
}else {
    if($jsonDecode['flag'] == 0){
        $name = $jsonDecode['name'];
        $pass = $jsonDecode['pass'];
        $sql2 = sprintf("SELECT * FROM schedule WHERE name = '$name'");
        $stmt = $pdo->query($sql2);
        $table = $stmt->fetchAll();
        $json = json_encode($table,JSON_UNESCAPED_UNICODE);
        $date = json_decode($json,true);
        $decision = count($date);
        if($decision == 0){
            $sql1 = $pdo -> prepare("INSERT INTO schedule(
                name,pass,date,content
                )VALUES(
                    :name,:pass,:date,:content
                )");
            $array = array(":name" => $jsonDecode['name'],":pass" => $jsonDecode['pass'],":date" => $jsonDecode['date'],":content" => $jsonDecode['content']);
            $sql1 -> execute($array);
            $sql2 = sprintf("SELECT * FROM schedule WHERE pass = '$pass' AND name = '$name'");
            $stmt = $pdo->query($sql2);
            $table = $stmt->fetchAll();
            echo json_encode($table,JSON_UNESCAPED_UNICODE);
        }else {
            $date = array();
            echo json_encode($date,JSON_UNESCAPED_UNICODE);
        }
    }else if($jsonDecode['flag'] == 1){
        $name = $jsonDecode['name'];
        $pass = $jsonDecode['pass'];
        $sql2 = sprintf("SELECT * FROM schedule WHERE pass = '$pass' AND name = '$name'");           
        $stmt = $pdo->query($sql2);
        $table = $stmt->fetchAll();
        echo json_encode($table,JSON_UNESCAPED_UNICODE);
    }else if($jsonDecode['flag'] == 2){
        $name = $jsonDecode['name'];
        $pass = $jsonDecode['pass'];
        $sql1 = $pdo -> prepare("INSERT INTO schedule(
            name,pass,date,content
            )VALUES(
                :name,:pass,:date,:content
            )");
        $array = array(":name" => $jsonDecode['name'],":pass" => $jsonDecode['pass'],":date" => $jsonDecode['date'],":content" => $jsonDecode['content']);
        $sql1 -> execute($array);
        $sql2 = sprintf("SELECT * FROM schedule WHERE pass = '$pass' AND name = '$name'");
        $stmt = $pdo->query($sql2);
        $table = $stmt->fetchAll();
        echo json_encode($table,JSON_UNESCAPED_UNICODE);
    }else if($jsonDecode['flag'] == 3){
        $name = $jsonDecode['name'];
        $pass = $jsonDecode['pass'];
        foreach($jsonDecode as $value){
            $id = $value;
            $sql2 = sprintf("DELETE FROM schedule WHERE id ='$id'");
            $srmt = $pdo -> exec($sql2);
        }
        $sql2 = sprintf("SELECT * FROM schedule WHERE pass = '$pass' AND name = '$name'");           
        $stmt = $pdo->query($sql2);
        $table = $stmt->fetchAll();
        echo json_encode($table,JSON_UNESCAPED_UNICODE);
    }
}
?>