$(document).ready(function(){
    insertRecord();
})

// Insert Record in Database
function insertRecord(){
    $(document).on('click', '#btn_register', function(){
        var firstname = $('#firstname').val();
        var surname = $('#surname').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirm_password').val();
        var role = $('#role').val();
        console.log(firstname,surname,username,email,password,confirmPassword,role);
        if(!checkFields(firstname,surname,username,email,password,confirmPassword)){
            $('#message').html('Please fill in the blanks')
        }
        else{
            $.ajax({
                url: "keyrock_signup.php",
                method: "post",
                data:{
                    firstname: firstname,
                    surname: surname,
                    username: username,
                    email: email,
                    password: password,
                    confirmPassword: confirmPassword,
                    role: role
                },
                success: function(data){
                    $('#message').html(data);
                    $('#Registration').modal('show');
                    $('form').trigger('reset');
                }
            })
        }
    })

    $(document).on('click','#btn_close', function(){
        $('form').trigger('reset');
        $('#message').html('');
    })
}


function checkFields(firstname,surname,username,email,password,confirmPassword){
    if(firstname!="" && surname!="" && username!="" && email!="" && password!="" && confirmPassword!=""){
        return true;
    }
    return false;
}