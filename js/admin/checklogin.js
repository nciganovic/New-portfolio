$(document).ready(function(){
    console.log("checklogin.js");

    var localEmail = localStorage.getItem("email");
    var localPsw = localStorage.getItem("psw");

    $("#exampleInputEmail").val(localEmail);
    $("#exampleInputPassword").val(localPsw);

    $(".btn").click(function(){
        var email = $("#exampleInputEmail").val();
        var psw = $("#exampleInputPassword").val();

        var emailRgx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var isValidEmail = emailRgx.test(email);

        var isValidPsw = true;
        if(psw.length > 25 || psw.length == 0){
            isValidPsw = false;
        }

        $(".errors").html("");
        if(!isValidEmail || !isValidPsw){

            if(!isValidEmail){
                $(".errors").append("<p class='text-danger'>Email is in wrong format.</p>");
            }

            if(!isValidPsw){
                $(".errors").append("<p class='text-danger'>Password is invalid. </p>");
            }
            
            return false;
        }

        var checkbox = $("#customCheck").is(':checked');
        if(checkbox){
            localStorage.setItem("email", email);
            localStorage.setItem("psw", psw);
        }
        

        console.log("PASSED!");
        return true;

        console.log(email, psw);
    })
})