$(document).ready(function(){
    console.log("delRow.js");
    var table = $("#table-name").text();
    table = table.toLowerCase();
    
    
    $(".btn-danger").click(function(e){
        e.preventDefault();
        var id = $(this).attr("data");

        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: "deleterow.php",
                method:"get",
                data:{
                    "id":id,
                    "table":table
                },
                type:"json",
                success: function(data){
                    console.log(JSON.parse(data));
                    var objData = JSON.parse(data);
                    showNewTable(objData, table);
                    
                },
                error: function(err){
                    console.log(err);
                }
            })
        } 
    })
})

function showNewTable(data, table){

    // Get the size of an object
    var len = Object.keys(data[0]);
    var size = len.length;
    var html = "";
    for(d of data){
        html += "<tr>";
        for(let i = 0; i < size / 2; i++){
            html += `<td> ${d[i]} </td>`;
        }
        html += `<td><a href='editrow.php?id=${d[0]}&table=${table}' class="btn btn-warning">Edit</a></td>`;
        html += `<td><a href='#' data="${d[0]}" class="btn btn-danger">Delete</a></td>`;
        html += "</tr>";
    }

    $("#table-data").html(html);

    $(".btn-danger").click(function(e){
        e.preventDefault();
        var id = $(this).attr("data");

        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: "deleterow.php",
                method:"get",
                data:{
                    "id":id,
                    "table":table
                },
                type:"json",
                success: function(data){
                    console.log(JSON.parse(data));
                    var objData = JSON.parse(data);
                    showNewTable(objData, table);
                    
                },
                error: function(err){
                    console.log(err);
                }
            })
        } 
    })
}