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
                console.log(data);
                var data = JSON.parse(data)
                if(data.length == 0){
                    console.log("No new blogs!");
                    $(".click-new-blogs").html("<p class='text-center raleway-p'>No more blogs available.</p>")
                }
                else{
                    var html = makeNewBlogs(data);
                    $(".show-new-blogs").append(html);
                    $(".loadblog").attr("data", Number(offset) + 3);
                }
            },  
            error: function(err){
                console.log(err);
            }
        })

    })

    $("#btn-search").click(function(){
        
        var search = $("#search").val();
        search = search.trim();
        
        if(search != ""){
            $.ajax({
                url: "searchblog.php",
                data:{
                    search: search
                },
                method: "GET",
                type: "text/json",
                success: function(data){
                    var data = JSON.parse(data);
                    var html = makeNewBlogs(data);
                    $(".begin-blogs").html(`<h2 class='text-center raleway-p mt-4'>Results of '${search}' search:</h2>`);
                    $(".begin-blogs").append(html);
                 
                    
                },
                error: function(err){
                    $(".begin-blogs").html(`<p class='text-center mt-5 raleway-p'>No blogs have '${search}' in their title or description.</p>`);
                }
            })
        }

    })

});

function makeNewBlogs(data){
    var html = "";

    for(d of data){
        var dateAndTime = d["date"];
        var date = dateAndTime.split(" ")[0];
        var year = date.split("-")[0];
        var month = date.split("-")[1];
        var day = date.split("-")[2];
        switch(month){
            case "01": month = "Jan"; break;
            case "02": month = "Feb"; break;
            case "03": month = "Mar"; break;
            case "04": month = "Apr"; break;
            case "05": month = "May"; break;
            case "06": month = "Jun"; break;
            case "07": month = "Jul"; break;
            case "08": month = "Aug"; break;
            case "09": month = "Sep"; break;
            case "10": month = "Oct"; break;
            case "11": month = "Nov"; break;
            case "12": month = "Dec"; break;
        }

        html += `   <div class="col-12 p-4 mt-4 mb-2 bg-white box-shadow br">
                        <p class="p-3 text-center border-dashed color-gray"> <a class="mont" href="blog.php?ctg=${d["ctgname"]}">  ${ d["ctgname"].toUpperCase()} </a></p>
                        <h2 class="text-center raleway-p font-weight-bold">${d["title"]}</h2>
                        <div class="d-flex justify-content-center">
                            <div class="pb-3 pt-2 color-gray raleway-p"><i class="far fa-clock"></i> ${day + "-" + month + "-" + year}</div>
                        </div>
                        <div>
                            <img class="w-100" src="img/${d["bgimgsrc"]}" alt="Slika 1">
                        </div>
                        <p class="mt-3 raleway-p">${d["description"]}</p>
                        <p class="text-center p-3"><a class="p-3 read-more-btn raleway-p br theme-blue-1" href="blogdetail.php?id=${d["id"]}">READ MORE</a></p>
                    </div>    
        `
    }
    
    return html;
}