var nav = document.getElementsByTagName('nav')[0];

if(window.innerWidth > 992){
    nav.classList.remove('dark-nav');
    nav.classList.add('transp-nav');

    var nav = document.getElementsByTagName('nav')[0];
        if(window.scrollY > 5){
            nav.classList.remove('transp-nav');
            nav.classList.add('dark-nav');
        }
        else{
            nav.classList.add('transp-nav');
            nav.classList.remove('dark-nav');
        }
        window.addEventListener('scroll', function(e){
            if(window.innerWidth > 992){
                if(window.scrollY > 5){
                    nav.classList.remove('transp-nav');
                    nav.classList.add('dark-nav');
                }
                else{
                    nav.classList.add('transp-nav');
                    nav.classList.remove('dark-nav');
                }
            }
        })
}
else{
    nav.classList.add('dark-nav');
    nav.classList.remove('transp-nav');
}

        
window.onresize = function(event) {
    if(window.innerWidth > 992){
        var nav = document.getElementsByTagName('nav')[0];
        if(window.scrollY > 5){
            nav.classList.remove('transp-nav');
            nav.classList.add('dark-nav');
        }
        else{
            nav.classList.add('transp-nav');
            nav.classList.remove('dark-nav');
        }
        window.addEventListener('scroll', function(e){
            if(window.innerWidth > 992){
                if(window.scrollY > 5){
                    nav.classList.remove('transp-nav');
                    nav.classList.add('dark-nav');
                }
                else{
                    nav.classList.add('transp-nav');
                    nav.classList.remove('dark-nav');
                }
            }
        })
    
    } 
    else{
        var nav = document.getElementsByTagName('nav')[0];
        nav.classList.add('dark-nav');
        nav.classList.remove('transp-nav');
    }    
};

/* Modal */
$(document).ready(function(){
    $(".open-modal-btn").click(function(e){
        e.preventDefault();
        
        $('#modal').css('display','block');

    })

    $(".close-modal-btn").click(function(e){
        e.preventDefault();
        
        $('#modal').css('display','none');
 
    })

    function fillData(item){
        $('#video').html(`
            <video autoplay controls loop muted id="video" class="w-100 border">
                <source src="video/${item}" type="video/mp4">
            </video>
        `)
    }

    $('.demo-btn').click(function(e){
        e.preventDefault();
        console.log("click demo!");
        var video = $(this).attr("data");
        console.log(video);
        fillData(video);
    })

})




