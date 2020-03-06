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
    <link rel="stylesheet" type="text/css" href="css/proj.css">
    <link rel="stylesheet" type="text/css" href="css/media.css">
</head>
<body>
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
    <section id="about-me">
      <div class="container pt-5 pb-5">
        <div class="row">
          <div class="col-xs-12 col-md-4 mt-5 img-prof">
            <img class="w-75" src="img/prof.jpeg" alt="profile image">
          </div>
          <div class="col-xs-12 col-md-4 mt-5 bg-prof d-none">
            <!--display none on small-->
          </div>
          <div id="about-me-txt" class="col-xs-12 col-md-7 mt-5">
            <h2 class="mont"><strong>ABOUT ME</strong></h2>
            <p>Web developer</p>
            <p>I'm <strong>Nikola Ciganović</strong>, a Web Developer from Belgrade, Serbia. I'm currently a college student in ICT College of Vocational studies, studying Web Development.</p>
            <p>My favorite thing to do is to create stuff using my programming knowledge. If you want to contact me you can find my email inside CV.</p>
            <p>
              <?php foreach($socMedia as $sm): ?>
                <a target="blank" href="<?=$sm["href"]?>"><i class="fab <?=$sm["logo"]?> text-dark font-15 mr-3"></i></a> 
              <?php endforeach ?>
            <p class="mt-5"> <a id="cv-btn" href="CV-new.pdf">Download CV</a> </p>
          </div>
        </div>
      </div>
    </section>
    <!-- ABOUT ME END -->
  
    <!-- MY SKILLS START -->
    <section id="skills">
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-12">
            <h2 class="text-center mont m-5"><strong>SKILLS</strong></h2>
          </div>
          <?php for($i = 0; $i < count($arrSkills); $i++): ?>
          <div id="skill-card" class="mt-3 p-3 border d-flex justify-content-center flex-column align-items-center">
            <?php foreach($arrSkills[$i] as $x ): ?>
            <i id="skill-icon" class="fas <?=$x["icon"]?>"></i>
            <h3><strong class="mont"><?=$x["name"]?></strong></h3>
            <?php break; ?>
            <?php endforeach ?>
            <?php foreach($arrSkills[$i] as $x ): ?>
              <p><?=$x["Name"]?></p>
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
          <div class="col-lg-6 aos-init aos-animate" data-aos="fade-up-right" data-aos-duration="1000">
            <a href="#" target="_blank">
              <img src="img/<?=$allProjects[$i]["imgsrc"]?>" alt="Portfolio Website" class="img-fluid">
            </a>
          </div>
          <div class="col-lg-6 aos-init aos-animate" data-aos="fade-up-left" data-aos-duration="1000">
            <h4><?=$allProjects[$i]["title"]?></h4>
            <p><?=$allProjects[$i]["description"]?></p>
            <div class="tech-used-list">
              <?php foreach($arrProjSkills[$i] as $ps): ?>
              <div><?= $ps[0] ?></div>
              <?php endforeach ?>
            </div>
            <div class="external-link">
              <a href="<?=$allProjects[$i]["weburl"]?>" class="btn btn-full">Visit website</a>
              <a href="<?=$allProjects[$i]["giturl"]?>" class="btn btn-full">Source code</a>
              <a id="<?=$allProjects[$i]["demoid"]?>" href="#" class="btn btn-full open-modal-btn">Demo</a>
            </div>
          </div>
        </div>
        <?php endfor ?>
      </div>

    </section>    
    <!-- PROJECTS END -->

    <!-- CONTACT ME START -->
    <section id="contact">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12">
            <h2 class="text-center mont">CONTACT</h2>
          </div>
        </div>
        <div class="row">
          <div class="col-6 mt-3">
            <input type="text" class="form-control" name="Name" placeholder="First name">
          </div>
          <div class="col-6 mt-3">
            <input type="text" class="form-control" name="Email" placeholder="Email">
          </div>
          <div class="col-12 mt-3">
            <input type="text" class="form-control" name="Subject" placeholder="Subject">
          </div>
          <div class="col-12 mt-3">
            <textarea class="form-control w-100" name="Message" placeholder="Message"></textarea>
          </div>
        </div>
        <div class="col-12 mt-3 pl-0">
          <button type="button" class="btn btn-success send-email">Send Email</button>
        </div>   
        <div class="col-12 mt-3 form-errors">
          
        </div>      
      </div>
    </section>
    
    <!-- CONTACT ME END -->


    <?php include("include/footer.php"); ?>

    <!-- MODAL START -->
    <div id="modal">
      <div class="container-custom mt-30 bg-light bg-transparent">
        <div class="row">
          <div class="col-12 col-xl-8 p-0">
            <!--<img src="img/proj1.png" class="w-100">-->
            <div id="video" class="w-100 d-flex">
            <video autoplay controls loop muted class="w-100 border">
              
            </video>
          </div>
            <!--<img src="img/clothyy-final.gif" class="w-100 border">-->
          </div>
          <div class="col-md-4 bg-light modal-desc">
              <a class="abs-top-right" href="#"><i class="text-dark fas fa-times float-right mt-2 float-right close-modal-btn"></i></a>
              <div class="ml-3 pl-3 mtb-auto">
                <h3 class="mt-3"><strong id="proj-title" class="mont"></strong></h3>
                <p class="mt-3">Technologies i used:</p>
                <ul id="proj-list" class="ml-3">
                  
                </ul>
                <p id="proj-desc" class="font-08 mb-4 d-none"></p>
                <a class="text-light text-decoration-none souce-btn rounded-pill" target="blank" href="#">SOURCE</a>
              </div>
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