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
        html += `   <div class="w-100 p-3">
                        <p>${questions[i].name}</p>
                        <ul class="ml-5">`
        
        for(a of answers[i]){
            html += `<li><input type="radio" name="${questions[i].id}" value="${a.name}"> ${a.name} </li>`;
        }
        html += "</ul>";
        html += `<button class="btn btn-success ml-5 answer-btn" data="${questions[i].id}">Answer</button> </div>`;
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