<?php 
    include("include/connection.php"); 
    include("include/getlogo.php");
    session_start();

    if(isset($_SESSION["userid"])){
        $id = $_SESSION["userid"];
        
       include("include/getqa.php");
    }
    else{
        $sql = "SELECT id, name FROM question WHERE active = 1";
        $stmt = $pdo->prepare($sql);
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
    }
    
    if(isset($_GET["ctg"]) && !empty($_GET["ctg"])){
        $hasCtg = true;
        $sql = "SELECT b.id, b.title, b.description, b.bgimgsrc, b.date, c.name as 'ctgname' FROM blogs b inner join categories c on c.id = b.categoryid WHERE c.name = :ctg AND active = 1 ORDER BY date DESC ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":ctg", $_GET["ctg"]);
        $stmt->execute();
        $allBlogs = $stmt->fetchAll();
    }
    else{
        //Get all blogs 
        $hasCtg = false;
        $sql = "SELECT b.id, b.title, b.description, b.bgimgsrc, b.date, c.name as 'ctgname' FROM blogs b inner join categories c on c.id = b.categoryid WHERE active = 1 ORDER BY date DESC  LIMIT 3";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $allBlogs = $stmt->fetchAll();
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
<body style="background-color: #f5f3f2;">
    <?php include("include/navbar.php"); ?>

    <!-- INTRO PAGE START -->
    <section id="intro-page">
        <div class="w-100 h-540 darker-bg d-flex">
            <div class="container m-auto">
                <div class="row">
                    <div id="intro-desc" class="col-12 pos-rel">
                        <h1 class="text-light raleway-h1">Personal blog</h1>
                        <p class="text-light raleway-p">Writing every week about programming, new technology and books.</p>
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
                <div class="col-8 all-blogs">
                    <!-- Blogs -->
                    <?php foreach($allBlogs as $blog): ?>
                    <div class="col-12 p-4 mt-4 mb-2 bg-white box-shadow">
                        <p class="p-3 text-center border-dashed color-gray"> <a href="<?= $_SERVER["PHP_SELF"]."?ctg=".strtolower($blog["ctgname"])?>">  <?= strtoupper($blog["ctgname"]) ?> </a></p>
                        <h2 class="text-center"><?= $blog["title"] ?></h2>
                        <div class="d-flex justify-content-center">
                            <div class="pb-3 pt-2 color-gray"><i class="far fa-clock"></i> <?= date("d-M-Y", strtotime($blog["date"]));  ?></div>
                        </div>
                        <div>
                            <img class="w-100" src="img/<?=$blog["bgimgsrc"] ?>" alt="Slika 1">
                        </div>
                        <p class="mt-3"><?= $blog["description"] ?></p>
                        <p class="text-center p-3"><a class="p-3 read-more-btn" href="blogdetail.php?id=<?= $blog["id"] ?>">READ MORE</a></p>
                    </div>
                    <?php endforeach ?>
                    
                    <div class="show-new-blogs">
                    </div>
                    <?php if(!$hasCtg): ?>
                    <div class="click-new-blogs">
                        <p class="w-100 text-center m-0 mt-5"><a class="text-dark loadblog" href="#" data="0">More blogs</a></p>
                        <div class="w-100 d-flex "><a href="#" data="0" class="m-auto loadblog"><i class="fas fa-chevron-down"></i></a></div>
                    </div>
                    <?php endif ?>
                </div>
                <div class="col-4 pools mt-4" data="<?=$_SESSION["userid"]?>">
                    <!-- Pools -->

                    <?php for($i = 0; $i < count($allQuestions); $i++): ?>
                    <div class="w-100 p-3 mb-3 bg-white box-shadow">
                        <p><?= $allQuestions[$i]["name"] ?></p>
                        <ul class="ml-5">
                            <?php foreach($allAnswers[$i] as $a): ?>
                            <li><input type="radio" name="<?= $allQuestions[$i]["id"] ?>" value="<?=$a["name"]?>"> <?=$a["name"]?> </li>
                            <?php endforeach ?>
                        </ul> 
                        
                        <?php if(isset($_SESSION["userid"])): ?>
                        <button class="btn btn-success ml-5 answer-btn" data="<?=$allQuestions[$i]["id"]?>">Answer</button> 
                        <?php else: ?>
                        <button class="btn btn-success ml-5 alert-btn">Answer</button> 
                        <?php endif ?>
                    </div>
                    <?php endfor ?>
                </div>
            </div> 
        </div>
    </section>
    <section class="m-5"></section>

    <?php include("include/footer.php"); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <script src="js/pool.js"></script>
    <script src="js/moreblogs.js"></script>
</body>
</html>