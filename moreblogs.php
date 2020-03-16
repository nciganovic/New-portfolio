<?php 
    include("include/connection.php"); 

    if(isset($_GET["offset"])){
       try{
            $o = $_GET["offset"];
            $o += 3;

            $sql = 
            "SELECT b.id, b.title, b.description, b.bgimgsrc, b.date, c.name as 'ctgname' 
            FROM blogs b inner join categories c on c.id = b.categoryid 
            WHERE active = 1
            ORDER BY date DESC  LIMIT 3 OFFSET ".$o;

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $allBlogs = $stmt->fetchAll();
            http_response_code(201);
            echo(json_encode($allBlogs));
        }
        catch(Exception $e){
            http_response_code(400);
            echo($e);
        }

    }

    

?>