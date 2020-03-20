$(document).ready(function(){
    $(".alert-btn").click(function(){
        alert("You need to login in order to vote.");
    });

    $(".answer-btn").click(function(){
        var questionId = $(this).attr("data");
        var value = $('input[name=' + questionId + ']:checked').val(); 
        var userId = $(".pools").attr("data");

        if(value){
            console.log("value exists!");
            $.ajax({
                url: "answer.php",
                method: "post",
                data:{
                    answer: value,
                    userId: userId,
                    questionId: questionId
                },
                type:"text/json",
                success: function(data){
                    parsed = JSON.parse(data);
                    var questions = parsed[0]; 
                    var answers = parsed[1];
                    console.log(questions);
                    console.log(answers);
                    showQuestionsAndAnswers(questions, answers);
                },
                error: function(err){
                    console.log(err);
                }
            })
        }

        
        
    })
})

function showQuestionsAndAnswers(questions, answers){
    var html = ""; 
    for(let i = 0; i < questions.length; i++){
        html += ` <div class="w-100 p-3 mb-3 bg-white box-shadow br d-none question-card">
                        <p class="text-center raleway-p">${questions[i].name}</p>
                        <div class="d-flex mt-3 mb-3">
                        <ul class="m-auto">`
        
        for(a of answers[i]){
            html += `<li><input type="radio" name="${questions[i].id}" value="${a.name}"><label class="raleway-p">${a.name}</label> </li>`;
        }
        html += "</ul></div>";
        html += `<div class="d-flex"><button class="btn theme-blue-1 answer-btn m-auto raleway-p btn-question text-light" data="${questions[i].id}">Answer</button> </div></div>`;
    }

    $(".pools").html(html);

    $(".answer-btn").click(function(){
        var questionId = $(this).attr("data");
        var value = $('input[name=' + questionId + ']:checked').val(); 
        var userId = $(".pools").attr("data");

        if(value){
            console.log("value exists!");
            $.ajax({
                url: "answer.php",
                method: "post",
                data:{
                    answer: value,
                    userId: userId,
                    questionId: questionId
                },
                type:"text/json",
                success: function(data){
                    parsed = JSON.parse(data);
                    var questions = parsed[0]; 
                    var answers = parsed[1];
                    console.log(questions);
                    console.log(answers);
                    showQuestionsAndAnswers(questions, answers);
                },
                error: function(err){
                    console.log(err);
                }
            })
        }

        
        
    })
}