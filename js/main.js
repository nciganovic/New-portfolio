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
            //console.log(window.scrollY);
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
        console.log(window.innerWidth);
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
            //console.log(window.scrollY);
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

    var data = [{
        title: "CLOTHYY",
        tech: ["HTML 5", "CSS 3", "Javascript | Jquery library", "Python 3.7 | Django Framework", "MySQL", "Linux Server", "Apache 2"],
        desc: "Contains features like shopping cart, user shopping history, searching for specific product, stripe integration.",
        img:""
    },
    {
        title: "Email Developer",
        tech: ["HTML 5", "CSS 3", "Javascript"],
        desc: "Simple HTML and CSS landing page for selling online courses i made in 2 days as a youtube challenge. ",
        img:""
    },
    {
        title: "IMPERIAL",
        tech: ["HTML 5", "CSS 3", "Javascript | Jquery"],
        desc: "Imperial is restaurant website. First website i made that has Javascript and Jquery implemented. Also has regex for form validation.",
        img:""
    },
    {
        title: "Read And Write",
        tech: ["HTML 5", "CSS 3", "Python 3.7 | Django"],
        desc: "Read and Write is a website for bloggers to write their blogs. Users can create, read, update, delete their blogs. Users can also view their stats, like and comment.",
        img:""
    },
    {
        title: "Amazon REST API",
        tech: ["Python 3.7", "Django REST Framework", "Beautiful Soup 4"],
        desc: "REST API for amazon.com, let's you get information about certain products. Database is automaticly filled using script with Beautiful Soup",
        img:""
    },
    {
        title: "LEARN.PY",
        tech: ["HTML 5", "CSS 3", "Bootstap 4"],
        desc: "Mobile friendly website for selling online Python courses.",
        img:""
    },
    ]

    function fillData(item){
        $('#proj-title').text(item.title);
        $('#proj-list').html('');
        for(x in item.tech){
            $('#proj-list').append(`<li class="font-08">${item.tech[x]}</li>`) 
        }
        $('#proj-desc').text(item.desc);
    }

    $('#clothyy').click(function(){
        console.log('clothyy click');
        fillData(data[0]);
    })

    $('#htmlemail').click(function(){
        console.log('htmlemail click');
        fillData(data[1]);
    })

    $('#imperial').click(function(){
        fillData(data[2]);
        console.log('imperial click');
    })

    $('#randw').click(function(){
        fillData(data[3]);
        console.log('randw click');
    })

    $('#restapi').click(function(){
        fillData(data[4]);
        console.log('restapi click');
    })

    $('#learnpy').click(function(){
        fillData(data[5]);
        console.log('learnpy click');
    })
})




