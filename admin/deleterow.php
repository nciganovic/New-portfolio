<?php 
    include("includes/checkuserrole.php");

    include("../include/connection.php");

    if(isset($_GET["table"])){
        //Delete this row
        try{
            $table = $_GET["table"];
            $id = $_GET["id"];
    
            $sql = "DELETE FROM ".$table." WHERE id=".$id;
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
    
            include("includes/gettable.php");
            http_response_code(200);
            echo json_encode($tableInfo);
        }
        catch(Exception $e){
            http_response_code(400);
            echo($e);
        }
        
    }
    else{
        header("location: dashboard.php");
    }

?>
