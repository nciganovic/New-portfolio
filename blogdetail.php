<?php 
    include("include/connection.php"); 
    include("include/getlogo.php");
    session_start();

    if(isset($_GET["id"]) && !empty($_GET["id"])){
        $id = $_GET["id"];
        $sql = "SELECT b.id, b.title, b.description, b.text as 'text', b.bgimgsrc, b.date, c.name as 'ctgname', b.keywords as 'keywords' FROM blogs b inner join categories c on c.id = b.categoryid WHERE b.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $blog = $stmt->fetchAll();
        $blog = $blog[0];
    }
    else{
        $url = "http://".$_SERVER["HTTP_HOST"]."/newportfolio/index.php";
        header("location: ".$url);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$blog["description"]?>">
    <meta name="keywords" content="<?=$blog["keywords"]?>">
    <meta name="author" content="Nikola Ciganovic">
    
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
                <div class="col-12">
                    <!-- Blogs -->
                    <div class="col-12 p-4 mt-4 mb-2 bg-white box-shadow">
                        <p class="p-3 text-center border-dashed color-gray"><?= strtoupper($blog["ctgname"]) ?></p>
                        <h2 class="text-center"><?= $blog["title"] ?></h2>
                        <div class="d-flex justify-content-center">
                            <div class="pb-3 pt-2 color-gray"><i class="far fa-clock"></i> <?= date("d-M-Y", strtotime($blog["date"]));  ?></div>
                        </div>
                        <div>
                            <img class="w-100" src="img/<?=$blog["bgimgsrc"] ?>" alt="<?= $blog["title"] ?>">
                        </div>
                        <div class="mt-3"><?=$blog["text"] ?></div>
                        
                    </div>
                    
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
</body>
</html>