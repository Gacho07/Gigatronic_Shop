$(document).ready(function() {
    $("#firstNameContact").val("")
    $("#formEmail").val("")
    $("#contentContact").val("")
    checkFormClientSide()
})

function checkFormClientSide() {
    $("#firstNameContact").blur(checkFirstName)
    $("#firstNameContact").addClass("cssBorder")
    $("#formEmail").blur(checkEmail)
    $("#formEmail").addClass("cssBorder")
    $("#contentContact").blur(checkMessage)
    $("#contentContact").addClass("cssBorder")

    $("#btnSendMessage").click(checkForm)

    let reFirstName = /^[A-Z][a-z]{2,14}$/
    let reEmail = /^[\w]+[\.\w\d]*\@[\w]+([\.][\w]+)+$/
    let reMessage = /^[\w\d\s\.\,\+]+$/

    function checkFirstName() {
        let firstName = $("#firstNameContact").val()
        if (!reFirstName.test(firstName)) {
            $("#firstNameContact").addClass("notCorrect")
        } else {
            $("#firstNameContact").removeClass("notCorrect")
        }
    }
    function checkEmail() {
        let email = $("#formEmail").val()
        if (!reEmail.test(email)) {
            $("#formEmail").addClass("notCorrect")
        } else {
            $("#formEmail").removeClass("notCorrect")
        }
    }
    function checkMessage() {
        let message = $("#contentContact").val()
        if (!reMessage.test(message)) {
            $("#contentContact").addClass("notCorrect")
        } else {
            $("#contentContact").removeClass("notCorrect")
        }
    }

    function checkForm() {
        var firstName = $("#firstNameContact").val()
        var email = $("#formEmail").val()
        var message = $("#contentContact").val()

        var arrayMistakes = []

        if ($('.notCorrect').length || (firstName == "") || (email == "") || (message == "")) {
            if (!reFirstName.test(firstName))
                arrayMistakes.push("Minimum 3 and maximum 15 characters for first name.")
            if (!reEmail.test(email))
                arrayMistakes.push("Email is not in good format.")
            if (!reMessage.test(message))
                arrayMistakes.push("Message must contain only uppercase, lowercase, numbers and .,+")
            
            checkEmpty(firstName, email, message)
        } else {
            $("#notification").html("")
        }
    }

    function checkEmpty(firstName, email, message) {
        if (firstName == "") {
            $("#firstNameContact").addClass("notCorrect")
        }
        if (email == "") {
            $("#formEmail").addClass("notCorrect")
        }
        if (message == "") {
            $("#contentContact").addClass("notCorrect")
        }
    }
}