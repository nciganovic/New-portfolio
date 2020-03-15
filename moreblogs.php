<?php 
    include("include/connection.php"); 

    if(isset($_GET["offset"])){
        $o = $_GET["offset"];
        $o += 3
        ;

    
        $sql = 
        "SELECT b.id, b.title, b.description, b.bgimgsrc, b.date, c.name as 'ctgname' 
        FROM blogs b inner join categories c on c.id = b.categoryid 
        ORDER BY date DESC  LIMIT 3 OFFSET ".$o;

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $allBlogs = $stmt->fetchAll();

        echo(json_encode($allBlogs));
    

    }

    

?>