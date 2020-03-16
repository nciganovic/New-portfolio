<?php 
    include("include/connection.php");

    if(isset($_POST["answer"]) && isset($_POST["userId"]) && isset($_POST["questionId"])){
        try{
            $answer = $_POST["answer"]; 
            $id = $_POST["userId"];
            $questionId = $_POST["questionId"];
    
            $sql = "INSERT INTO poolanswer (questionid, answer, userid) VALUES(:q, :a, :u)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":q", $questionId);
            $stmt->bindParam(":a", $answer);
            $stmt->bindParam(":u", $id);
            $stmt->execute();
    
            include("include/getqa.php");
    
            $allData = [];
            array_push($allData, $allQuestions);
            array_push($allData, $allAnswers);

            http_response_code(201);
            echo json_encode($allData);
        }
        catch(Exception $e){
            http_response_code(400);
            echo($e);
        }
        
    }  

?>