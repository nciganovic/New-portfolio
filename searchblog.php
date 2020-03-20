<?php
    include("include/connection.php");

    if(isset($_GET["search"]) && !empty($_GET["search"])){
        
        $search = trim($_GET["search"], " ");
        if($search != ""){
            $adj = '%'.$search.'%';
            try{
            $sql = "SELECT b.id, b.title, b.description, b.bgimgsrc, b.date, c.name as 'ctgname' FROM blogs b inner join categories c on c.id = b.categoryid 
            WHERE active = 1 AND b.title LIKE :search OR b.description LIKE :search ORDER BY date DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':search', $adj);
            $stmt->execute();
            $allBlogs = $stmt->fetchAll();
            
            

            if(count($allBlogs) != 0){
                echo(json_encode($allBlogs));
                http_response_code(200);
            }
            else{
                echo(json_encode($allBlogs));
                http_response_code(404);
            }
            
            }
            catch(Exception $e){
                echo($e);
                http_response_code(500);
            }
        }
        else{
            die();
        }
    }
    else{
        die();
    }

?>