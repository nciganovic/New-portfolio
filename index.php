<?php 
  include("include/connection.php"); 
  include("include/getlogo.php");

  /* Selecting all for skills */
  $sql = "SELECT Name FROM skillsection";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $skillSectionsNames = $stmt->fetchAll();

  $arrSkills = [];
  for($i = 0; $i < count($skillSectionsNames); $i++){

    $name = $skillSectionsNames[$i]["Name"];

    $sql = "SELECT s.Name, ss.name, ss.icon FROM skillsection ss INNER JOIN skills s ON ss.id = s.SkillSectionId WHERE ss.name = :name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->execute();
    $allData = $stmt->fetchAll();
    $arrSkills[$i] = $allData;

  }

  /*Selecting for projects */ 
  $sqlProj = "SELECT * FROM projects";
  $stmt = $pdo->prepare($sqlProj);
  $stmt->execute();
  $allProjects = $stmt->fetchAll();
  $arrProjSkills = [];

  for($i = 0; $i < count($allProjects); $i++){

    $id = $allProjects[$i]["Id"];
    
    $sql = "SELECT s.Name FROM skills s INNER JOIN projectskills ps ON s.Id = ps.skillid INNER JOIN projects p on ps.projectid = p.Id WHERE p.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $allData = $stmt->fetchAll();
    $arrProjSkills[$i] = $allData;

  }

  /* Select Top 3 Blogs */
  $sql = "SELECT b.id, b.title, b.description, b.bgimgsrc, b.date, c.name as 'ctgname' FROM blogs b inner join categories c on c.id = b.categoryid ORDER BY date DESC  LIMIT 3";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $allBlogs = $stmt->fetchAll();

  session_start();
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157514571-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-157514571-1');
    </script>

    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="description" content="I'm Nikola Ciganović, a Web Developer from Belgrade, Serbia. I'm currently a college student in ICT College of Vocational studies, studying Web Development. My favorite thing to do is to create stuff using my programming knowledge.">
    <meta name="keywords" content="Nikola Ciganović, Web developer, Programmer, portfolio">
    <meta name="author" content="Nikola Ciganovic">

    <link rel="icon" href="img/icon1.ico">

    <title>Nikola Ciganović | Web developer</title>

    <script src="https://kit.fontawesome.com/d27711fee5.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans|Raleway:400,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/media.css">
</head>
<body class="theme-blue-3">
    <?php include("include/navbar.php"); ?>
    
    <!-- INTRO PAGE START -->
    <section id="intro-page">
        <div class="w-100 vh-100 darker-bg d-flex">
            <div class="container m-auto">
                <div class="row">
                    <div id="intro-desc" class="col-12 pos-rel">
                        <h1 class="text-light raleway-h1">Hi! I'm Nikola.</h1>
                        <p class="text-light raleway-p">Programmer & Web Developer located in Belgrade, Serbia.</p>
                        <div class="arrow">
                          <a class="ml-5" href="#about-me"><i class="fas fa-angle-down text-light font-25 animated bounce infinite"></i></a>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </section>
    <!-- INTRO PAGE END -->

    <!-- ABOUT ME START -->
    <section id="about-me" class="pb-5">
      <div class="container pt-5 pb-5">
        <div class="row">
          <div class="col-xs-12 col-md-4 mt-5 img-prof ">
            <img class="w-75 br" src="img/prof.jpeg" alt="profile image">
          </div>
          <div class="col-xs-12 col-md-4 mt-5 bg-prof d-none br">
            <!--display none on small-->
          </div>
          <div id="about-me-txt" class="col-xs-12 col-md-7 mt-5">
            <h2 class="mont">ABOUT ME</h2>
            <p class="raleway-p">Web developer</p>
            <p class="raleway-p">I'm <strong>Nikola Ciganović</strong>, a Web Developer from Belgrade, Serbia. I'm currently a college student in ICT College of Vocational studies, studying Web Development.</p>
            <p class="raleway-p">My favorite thing to do is to create stuff using my programming knowledge. If you want to contact me you can find my email inside CV.</p>
            <p>
              <?php foreach($socMedia as $sm): ?>
                <a target="blank" href="<?=$sm["href"]?>"><i class="fab <?=$sm["logo"]?> text-dark font-15 mr-3"></i></a> 
              <?php endforeach ?>
            <p class="mt-5"> <a id="cv-btn" class="raleway-p br" href="CV-new.pdf">Download CV</a> </p>
          </div>
        </div>
      </div>
    </section>
    <!-- ABOUT ME END -->
  
    <!-- MY SKILLS START -->
    <section id="skills" class="theme-blue-1 pb-5">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-12">
            <h2 class="text-center mont m-5 txt-theme-3">SKILLS</h2>
          </div>
          <?php for($i = 0; $i < count($arrSkills); $i++): ?>
          <div id="skill-card" class="mt-3 p-3 border d-flex justify-content-center flex-column align-items-center theme-blue-3 br">
            <?php foreach($arrSkills[$i] as $x ): ?>
            <i id="skill-icon" class="fas text-dark <?=$x["icon"]?>"></i>
            <h3><strong class="raleway-h1 text-dark"><?=$x["name"]?></strong></h3>
            <?php break; ?>
            <?php endforeach ?>
            <?php foreach($arrSkills[$i] as $x ): ?>
              <p class="text-dark raleway-p"><?=$x["Name"]?></p>
            <?php endforeach ?>
          </div>
          <?php endfor ?>
        </div>
      </div>
    </section>
    <!-- MY SKILLS END -->
    
    <!-- PROJECTS START -->
    <section class="section-projects" id="projects">
      <div class="container">
        <h2 class="text-center mont m-5">PROJECTS</h2>
      </div>
      <div class="container">
        <!-- First Featured Project -->
        <?php for($i = 0; $i < count($allProjects); $i++): ?>
        <div class="row project-holder mt-5">
          <div class="col-lg-6">
            <a href="<?=$allProjects[$i]["weburl"]?>" target="_blank">
              <img src="img/<?=$allProjects[$i]["imgsrc"]?>" alt="<?=$allProjects[$i]["title"]?>" class="img-fluid br">
            </a>
          </div>
          <div class="col-lg-6 mt-on-small">
            <h4 class="raleway-p font-weight-bold"><?=$allProjects[$i]["title"]?></h4>
            <p class="raleway-p"><?=$allProjects[$i]["description"]?></p>
            <div class="tech-used-list">
              <?php foreach($arrProjSkills[$i] as $ps): ?>
              <div class="raleway-p"><?= $ps[0] ?></div>
              <?php endforeach ?>
            </div>
            <div class="external-link">
              <?php if($allProjects[$i]["title"] == "My personal website"): ?>
                <a href="<?=$allProjects[$i]["giturl"]?>" class="btn btn-full raleway-p rounded-pill pl-3 pr-3 pt-2 pb-2 proj-btn d-none">Source code</a>
              <?php else: ?>
                <a target="_blank" href="<?=$allProjects[$i]["weburl"]?>" class="btn btn-full raleway-p rounded-pill pl-3 pr-3 pt-2 pb-2 proj-btn d-none">Visit website</a>
                <a target="_blank" href="<?=$allProjects[$i]["giturl"]?>" class="btn btn-full raleway-p rounded-pill pl-3 pr-3 pt-2 pb-2 proj-btn d-none">Source code</a>
                <a id="<?=$allProjects[$i]["demoid"]?>" href="#" class="btn btn-full open-modal-btn raleway-p rounded-pill pl-3 pr-3 pt-2 pb-2 proj-btn d-none">Demo</a>
              <?php endif ?>
              
            </div>
          </div>
        </div>
        <?php endfor ?>
      </div>

    </section>    
    <!-- PROJECTS END -->

    <!-- CONTACT ME START -->
    <section id="contact" class="theme-blue-1">
      <div class="container mt-5 pb-5">
        <div class="row">
          <div class="col-12">
            <h2 class="text-center mont m-5 txt-theme-3">CONTACT</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-6 col-lg-12 mt-3">
            <input type="text" class="form-control raleway-p theme-blue-3" name="Name" placeholder="First name">
          </div>
          <div class="col-xl-6 col-lg-12 mt-3">
            <input type="text" class="form-control raleway-p theme-blue-3" name="Email" placeholder="Email">
          </div>
          <div class="col-12 mt-3">
            <input type="text" class="form-control raleway-p theme-blue-3" name="Subject" placeholder="Subject">
          </div>
          <div class="col-12 mt-3">
            <textarea class="form-control w-100 raleway-p theme-blue-3" name="Message" placeholder="Message"></textarea>
          </div>
        </div>
        <div class="col-12 mt-3 pl-0">
          <button type="button" class="btn send-email raleway-p theme-blue-3 font-12">Send Email</button>
        </div>   
        <div class="col-12 mt-3 form-errors raleway-p">
          
        </div>      
      </div>
    </section>
    
    <!-- CONTACT ME END -->

    <!-- BLOGS START -->
    <section id="contact">
      <div class="container mt-5">
        <div class="col-12">
          <h2 class="text-center mont">BLOGS</h2>
        </div>
        <div class="d-flex">
          <div class="card-deck">
            <?php foreach($allBlogs as $blog): ?>
            <a href="blogdetail.php?id=<?=$blog["id"]?>" class="card p-0">
              <img class="card-img-top" src="img/<?=$blog["bgimgsrc"]?>" alt="<?=$blog["title"]?>">
              <div class="card-body">
                <h3 class="card-title raleway-p"><?=$blog["title"]?></h3>
                <p class="card-text raleway-p"><?=$blog["description"]?></p>
                <p class="card-text"><small class="text-muted raleway-p"><?= date("d-M-Y", strtotime($blog["date"]));  ?></small></p>
              </div>
              <div class="card-footer">
                <small class="text-muted raleway-p"><?=$blog["ctgname"]?></small>
              </div>
            </a>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </section>
    <!-- BLOG END -->


    <?php include("include/footer.php"); ?>

    <!-- MODAL START -->
    <div id="modal">
      <div class="container-custom mt-30 bg-light bg-transparent">
        <div class="row d-flex">
          <div class="col-lg-8 col-md-12 p-0 m-auto">
            <!--<img src="img/proj1.png" class="w-100">-->
            <div id="video" class="w-100 d-flex">
            <video autoplay controls loop muted class="w-100 border">
              
            </video>
          </div>
            <!--<img src="img/clothyy-final.gif" class="w-100 border">-->
          </div>
          <div class="close-sm col-12 d-flex justify-content-center bg-transparent">
            <!-- display none on 1200+ px -->
            <p><a href="#"><i class="text-light fas fa-times float-right mt-2 float-right close-modal-btn font-25"></i></a></p>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL END -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
    <script src="js/email.js"></script>
</body>
</html>