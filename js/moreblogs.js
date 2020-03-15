$(document).ready(function(){
    console.log("moreblogs.js");

    $(".loadblog").click(function(e){
        e.preventDefault();
        
        var offset = $(this).attr("data");
        console.log(offset);

        $.ajax({
            url: "moreblogs.php",
            method: "get",
            type:"text/json",
            data:{
                "offset": offset
            },
            success: function(data){
                console.log(JSON.parse(data));
                var data = JSON.parse(data)
                if(data.length == 0){
                    console.log("No new blogs!");
                    $(".click-new-blogs").html("<p class='text-center'>No more blogs available.</p>")
                }
                else{
                    makeNewBlogs(data);
                    $(".loadblog").attr("data", Number(offset) + 3);
                }
            },  
            error: function(err){
                console.log(err);
            }
        })

    })

});

function makeNewBlogs(data){
    var html = "";

    for(d of data){

        html += `   <div class="col-12 p-4 mt-4 mb-2 bg-white box-shadow">
                        <p class="p-3 text-center border-dashed color-gray">${d["ctgname"]}</p>
                        <h2 class="text-center">${d["title"]}</h2>
                        <div class="d-flex justify-content-center">
                            <div class="pb-3 pt-2 color-gray"><i class="far fa-clock"></i> ${d["date"]}</div>
                        </div>
                        <div>
                            <img class="w-100" src="img/${d["bgimgsrc"]}" alt="Slika 1">
                        </div>
                        <p class="mt-3">${d["description"]}p>
                        <p class="text-center p-3"><a class="p-3 read-more-btn" href="blogdetail.php?id=${d["id"]}">READ MORE</a></p>
                    </div>    
        `
    }
    
    $(".show-new-blogs").append(html);
}