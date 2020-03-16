<?php 
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $headers = 'From: noreply @ company . com';

    var_dump($name);
    var_dump($email);
    var_dump($subject);
    var_dump($message);
    var_dump($headers);

    $errors = [];

    $isValidName = preg_match('/^[A-z][a-z]{1,15}(\s[A-z][a-z]{1,15}){0,3}$/', $name);
    $isValidEmail = preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $email);
    $isValidSubject = preg_match('/^[a-zA-Z0-9_\.\-\!\?\*\,\:\s]+$/', $subject);
    $isValidMessage = preg_match('/^[a-zA-Z0-9_\.\-\!\?\*\,\:\s]+$/', $message);

    if(!$isValidName){
        array_push($errors, "Name invalid");
    }
    
    if(!$isValidEmail){
        array_push($errors, "Email invalid");
    }

    if(!$isValidSubject){
        array_push($errors, "Subject invalid");
    }

    if(!$isValidMessage){
        array_push($errors, "Message invalid");
    }

    if(count($errors) == 0){
        include("include/connection.php"); 
        try{
            mail("nciganovic99@gmail.com", $subject, $message, $headers);
            $sql = "INSERT INTO CONTACT (name, email, subject, message)  VALUES(:name, :email, :subject, :message)";
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":subject", $subject);
            $stmt->bindParam(":message", $message);
            $stmt->execute();
            http_response_code(200);
            echo("Email sent succesfully!");
        }
        catch(Exception $e){
            http_response_code(400);
            echo($e);

        }

    }
    else{
        foreach($errors as $e){
            echo($e);
            echo(", ");
        }
    }

?>