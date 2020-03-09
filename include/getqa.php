<?php 
    $sql = "SELECT q.id, q.name FROM question q WHERE q.id NOT IN ( SELECT q.id FROM question q INNER JOIN poolanswer pa ON q.id = pa.questionid WHERE pa.userid = :userid )";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":userid", $id);
    $stmt->execute();
    $allQuestions = $stmt->fetchAll();

    $allAnswers = []; 

    foreach($allQuestions as $q){
        $sql = "SELECT name FROM choice where questionid = :qid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":qid", $q["id"]);
        $stmt->execute();
        $one_Q_answers = $stmt->fetchAll();

        array_push($allAnswers, $one_Q_answers);
    }
?>