<?php

    require "../config/config.php";
    session_start();

    if(empty($_SESSION['id']) || empty($_SESSION['logged_in'])){

        echo "<script> alert('You need to login first'); window.location.href='login.php'; </script>";

    }else{

        if(!empty($_GET)){
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM `posts` WHERE id='$id'");
            
            if($stmt->execute()){
                header("location:starter.php");
            }
        }

    }

?>