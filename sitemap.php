<?php 
    include("include/connection.php");

    $sql = "SELECT b.id as 'id' FROM blogs b WHERE active = 1 ORDER BY date DESC";
    $allBlogs = $pdo->query($sql)->fetchAll();
    

    $base_url = "https://nikolaciganovic.com/newportfolio/";
    header("Content-Type: application/xml; charset=utf-8");

    echo "<?xml version='1.0' encoding='UTF-8'?>";
    echo "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'>";

    echo "<url>";
    echo "<loc>".$base_url."index.php</loc>";
    echo "<changefreq>daily</changefreq>";
    echo "<priority>1</priority>";
    echo "</url>";

    echo "<url>";
    echo "<loc>".$base_url."blog.php</loc>";
    echo "<changefreq>weekly</changefreq>";
    echo "<priority>0.8</priority>";
    echo "</url>";

    echo "<url>";
    echo "<loc>".$base_url."login.php</loc>";
    echo "<changefreq>monthly</changefreq>";
    echo "<priority>0.5</priority>";
    echo "</url>";

    echo "<url>";
    echo "<loc>".$base_url."register.php</loc>";
    echo "<changefreq>monthly</changefreq>";
    echo "<priority>0.5</priority>";
    echo "</url>";

    foreach($allBlogs as $blog){
        echo "<url>";
        echo "<loc>".$base_url."blogdetail.php?id=".$blog["id"]."</loc>";
        echo "<changefreq>monthly</changefreq>";
        echo "<priority>0.6</priority>";
        echo "</url>";
    }

    echo "</urlset>";

?>