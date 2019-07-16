$(document).ready(function(){

    function errorMsg(message) {
        $("#message").html(`<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>${message}</div>`);
    }

    function validateEmail(email) {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $("#register-form").on("submit", function(e) {

        e.preventDefault();
        let submit = true;
        let errorHtml = "";

        const formData = $(this).serializeArray();

        let password = "";
        for(let i=0; i < formData.length; i++) {
            const item = formData[i];
            switch (item.name) {
                case 'email':
                    if (!validateEmail(item.value)) {
                        errorMsg("Please enter valid email");
                        submit = false;
                    }
                    break;
                case 'password':
                    password = item.value;
                    console.log("item.value", item.value)
                    break;
                case 'retypepwd':
                    if (item.value != password) {
                        errorMsg("Entered passwords do not match");
                        submit = false;
                    }
                    break;
            }

            if (!submit) return;
        }

        if (submit) $("#message").html("")

        $.ajax({
            type: "POST",
            url: "register.php",
            data: $(this).serialize(),
            success: function(html){
                if(html=='true') {
                    window.location="index.php";
                }
                else {
                    // $("#message").html(html);
                }
            },
            beforeSend:function()
            {
                $("#message").html("<p class='text-center'><img src='/assets/img/ajax-loader.gif'></p>")
            }
        });
    });
});

$('#retypepwd').on('keyup', function () {
    if ($(this).val() == $('#mypassword').val()) {
        document.getElementById("submit").disabled = false;
    } else{
        document.getElementById("submit").disabled = true;
        $('#message').html('Passwords don\'t match').css('color', 'red');
    }
});