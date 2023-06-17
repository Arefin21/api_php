<?php


    header('content-type:application/json');
    $request = $_SERVER['REQUEST_METHOD'];
    switch($request){
        case 'GET':
            getmethod();
        break; 

        case 'POST':
            $data=json_decode(file_get_contents('php://input'),true);
            postmethod($data);
        break; 

        case 'PUT':
            $data=json_decode(file_get_contents('php://input'),true);
            putmethod($data);
        break; 
        case 'DELETE':
            $data=json_decode(file_get_contents('php://input'),true);
            deletemethod($data);
        break;    
        default:
        echo '{"name": "Data not found"}';
            break;
    }

    function getmethod(){
        include "db.php";
        $sql="SELECT * FROM test";
        $result=mysqli_query($conn,$sql);

        if(mysqli_num_rows($result)>0){
            $rows=array();
            while($r=mysqli_fetch_assoc($result)){
                $rows['result'][] = $r;
            }
            echo json_encode($rows);
        }else{
            echo '{"result":"No Data Found"}';
        }
    }

    function postmethod($data){
        include "db.php";
        $name=$data['name'];
        $email=$data['email'];
        $created_at=$data['created_at'];
        $sql="INSERT INTO test (name,email,created_at) VALUES('$name','$email','$created_at')";
        if(mysqli_query($conn,$sql)){
            echo '{"result":"data insertaed"}';
        }else{
            echo '{"result":"Data not incerted"}';
        }
    }
    function putmethod($data){
        include "db.php";
        $id=$data['id'];
        $name=$data['name'];
        $email=$data['email'];
        $created_at=$data['created_at'];
        $sql="UPDATE test set name='$name',email='$email',created_at='$created_at' WHERE id='$id'";
        if(mysqli_query($conn,$sql)){
            echo '{"result":"Update insertaed"}';
        }else{
            echo '{"result":"Data not Update"}';
        }
    }

    function deletemethod($data){
        include "db.php";

        $id=$data["id"];
        
        $sql="DELETE FROM test  WHERE id=$id";
        if(mysqli_query($conn,$sql)){
            echo '{"result":"Data Deleted Successfully"}';
        }else{
            echo '{"result":"Data deletion was unsuccessful"}';
        }
    }

?>