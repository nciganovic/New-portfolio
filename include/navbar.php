<?php 
    $sql = "SELECT * FROM menu";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
?>
<!-- NAVBAR START -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top transp-nav">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars font-15 text-light"></i>
        </button>
        <a class="navbar-brand text-light mont" href="index.php">NIKOLA CIGANOVIĆ</a>
        
        <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <?php if(isset($_SESSION["role"])): ?> 
                    <?php foreach($data as $d): ?>
                        <?php if($d["Name"] != "Login" && $d["Name"] != "Register"): ?>
                        <li class="nav-item active ml-2 mr-2">
                            <a class="nav-link text-light font-weight-bold mont" href="<?=$d["Src"]?>"><?=$d["Name"]?> <span class="sr-only">(current)</span></a>
                        </li>   
                        <?php endif ?>
                    <?php endforeach ?>
                    <li class="nav-item active ml-2 mr-2">
                        <a class="nav-link text-light font-weight-bold mont" href="logout.php"> Logout <span class="sr-only">(current)</span></a>
                    </li>
                <?php else: ?>
                    <?php foreach($data as $d): ?>
                    <li class="nav-item active ml-2 mr-2">
                        <a class="nav-link text-light font-weight-bold mont" href="<?=$d["Src"]?>"><?=$d["Name"]?> <span class="sr-only">(current)</span></a>
                    </li>
                    <?php endforeach ?>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
    <!-- NAVBAR END -->