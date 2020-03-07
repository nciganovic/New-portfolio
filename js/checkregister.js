$(document).ready(function(){
    console.log("checkregister.js");

    $(".btn").click(function(){
        var username = $("#exampleInputName").val();
        var email = $("#exampleInputEmail").val();
        var psw = $("#exampleInputPassword").val();
        var pswR = $("#exampleInputPasswordR").val();

        var usernameRgx = /^(?=.{5,15}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/;
        var isValidUsername = usernameRgx.test(username);

        var emailRgx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var isValidEmail = emailRgx.test(email);

        var isValidPsw = true;
        if(psw.length > 25 || psw.length <= 4 || pswR.length > 25 || pswR.length <= 4){
            isValidPsw = false;
        }

        $(".errors").html("");
        $(".server-erros").html("");
        if(!isValidUsername || !isValidEmail || !isValidPsw){
            if(!isValidUsername){
                $(".errors").append("<p class='text-danger text-center'>Username is in wrong format. Valid formats are: user_15 , user.15 , user15 .</p>");
            }

            if(!isValidEmail){
                $(".errors").append("<p class='text-danger text-center'>Email is in wrong format.</p>");
            }

            if(!isValidPsw){
                $(".errors").append("<p class='text-danger text-center'>Password is invalid. Must be between 5 and 25 characters.</p>");
            }

            if(psw != pswR){
                $(".errors").append("<p class='text-danger text-center'>Passwords are not identical.</p>");
            }
            
            return false;
        }

        var checkbox = $("#customCheck").is(':checked');
        if(checkbox){
            localStorage.setItem("email", email);
            localStorage.setItem("psw", psw);
        }
        
        return true;
    })
})