$(document).ready(function(){
    console.log("delRow.js");
    var table = $("#table-name").text();
    table = table.toLowerCase();
    var url = "deleterow.php?table="
    var fullUrl = url + table;
    
    
    $(".btn-danger").click(function(e){
        e.preventDefault();
        var id = $(this).attr("data");
        var idUrl = "&id=" + id;
        fullUrl += idUrl;
        console.log(fullUrl);

        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: fullUrl,
                method:"get",
                type:"text/php",
                success: function(data){
                    $("#table-holder").html(data);
                },
                error: function(err){
                    console.log(err);
                }
            })
        } 
    })


    
})