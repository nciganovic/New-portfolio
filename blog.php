<?php 
    include("include/connection.php"); 
    include("include/getlogo.php");
    session_start();

    // Get ids of unanswerd questions
    //SELECT q.id FROM question q INNER JOIN choice c ON q.id = c.questionid WHERE q.id NOT IN ( SELECT q.id FROM question q INNER JOIN poolanswer pa ON q.id = pa.questionid WHERE pa.userid = 11 ) GROUP BY q.id

    // Get names of questions and names of answers for every question
    //SELECT q.id, q.name, c.name FROM question q INNER JOIN choice c ON q.id = c.questionid WHERE q.id NOT IN ( SELECT q.id FROM question q INNER JOIN poolanswer pa ON q.id = pa.questionid WHERE pa.userid = 11 )

    // Select id and name of all unanswerd questions by this user
    //SELECT q.id, q.name FROM question q WHERE q.id NOT IN ( SELECT q.id FROM question q INNER JOIN poolanswer pa ON q.id = pa.questionid WHERE pa.userid = 11 )

    if(isset($_SESSION["userid"])){
        $id = $_SESSION["userid"];
        
        $sql = "SELECT q.id, q.name FROM question q WHERE q.id NOT IN ( SELECT q.id FROM question q INNER JOIN poolanswer pa ON q.id = pa.questionid WHERE pa.userid = :userid )";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":userid", $id);
        $stmt->execute();
        $allQuestions = $stmt->fetchAll();

        var_dump($allQuestions);

        $allAnswers = []; 

        foreach($allQuestions as $q){
            $sql = "SELECT name FROM choice where questionid = :qid";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":qid", $q["id"]);
            $stmt->execute();
            $one_Q_answers = $stmt->fetchAll();

            array_push($allAnswers, $one_Q_answers);
        }

        var_dump($allAnswers);
    }
    else{

    }
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>

    <script src="https://kit.fontawesome.com/d27711fee5.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Raleway:400,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/blog.css">
</head>
<body>
    <?php include("include/navbar.php"); ?>

    <!-- INTRO PAGE START -->
    <section id="intro-page">
        <div class="w-100 h-540 darker-bg d-flex">
            <div class="container m-auto">
                <div class="row">
                    <div id="intro-desc" class="col-12 pos-rel">
                        <h1 class="text-light raleway-h1">Personal blog</h1>
                        <p class="text-light raleway-p">Writing about programming, new technology and books.</p>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <!-- INTRO PAGE END -->

    <!-- BLOG SECTION -->
    <section id="blog">
        <div class="container">
            <div class="row">
                <div class="col-8 border-right">
                    <!-- Blogs -->
                </div>
                <div class="col-4">
                    <!-- Pools -->
                    <?php for($i = 0; $i < count($allQuestions); $i++): ?>
                    <div class="w-100 p-3">
                        <p><?= $allQuestions[$i]["name"] ?></p>
                        <ul class="ml-5">
                            <?php foreach($allAnswers[$i] as $a): ?>
                            <li><input type="radio" name="rb1"> <?= $a["name"] ?> </li>
                            <?php endforeach ?>
                        </ul> 
                        <button class="btn btn-success ml-5">Answer</button> 
                    </div>
                    <?php endfor ?>
                </div>
            </div> 
        </div>
    </section>

    <?php include("include/footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>
</html>