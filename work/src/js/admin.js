$(document).ready(function(){
    viewUsers();
    getUser();
    updateUser();
    deleteUser();
    confirmUser();
})


function viewUsers(){
    $.ajax({
		url: "view_users.php",
		type: "POST",
		cache: false,
		success: function(data){
			$('#table').html(data);
		}
	});
}


//Get Single User
function getUser(){
    $(document).on('click','#btn_edit', function(){
        var id = $(this).attr('data-id');
        // var name = $(this).attr('data-name');
        // var surname = $(this).attr('data-surname');
        var username = $(this).attr('data-username');
        var email = $(this).attr('data-email');
        var role = $(this).attr('data-role');
        $('#update_user').modal('show');
        $('#id').val(id);
        // $('#name').val(name);
		// $('#surname').val(surname);
		$('#username').val(username);
		$('#email').val(email);
		$('#role').val(role);
    })

    $(document).on('click','#btn_close', function(){
        $('form').trigger('reset');
        $('#message').html('');
        $('#up-message').html('');
        $('#delete-message').html('');
    })
}


function updateUser(){
    $(document).on('click','#btn_update', function(){
        var id = $('#id').val();
        // var name = $('#name').val();
        // var surname = $('#surname').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var role = $('#role').val();
        if(!checkFields(username,email,role)){
            $('#up-message').html('Please fill in the blanks')
        }
        else{
            $.ajax({
                url: 'update_user.php',
                method: 'post',
                data: {
                    id: id,
                    // name: name,
                    // surname: surname,
                    username: username,
                    email: email,
                    role: role
                },
                success: function(data){
                    $('#up-message').html(data);
                    $('#update').modal('show');
                    viewUsers();
                }
            })
        }
    })
}

// Delete Products
function deleteUser(){
    $(document).on('click', '#btn_delete', function(){
        var id = $(this).attr('data-id1');
        var role = $(this).attr('data-role');
        var username = $(this).attr('data-username');
        console.log(username);
        if(role == 'ADMIN'){
            alert("This user is an admin so he cannot be deleted");
            return;
        }
        $('#delete').modal('show');
        $(document).on('click', '#delete_user', function(){
            $.ajax({
                url: 'delete_user.php',
                method: 'post',
                data :{
                        id:id,
                        role:role,
                        username: username    
                    },
                success: function(data){
                    $('#message').html(data);    
                    viewUsers();
                    $('#delete').modal('hide');
                }
            })
        })
    })
}

function confirmUser(){
    $(document).on('click', '#btn_confirm', function(){
        var id = $(this).attr('data-id');
        $('#confirm').modal('show');
        $(document).on('click', '#confirm_user', function(){
            $.ajax({
                url: 'confirm_user.php',
                method: 'post',
                data: {id:id},
                success: function(data){
                    $('#message').html(data);
                    viewUsers();
                    $('#confirm').modal('hide');
                }
            })
        })
    })
}


function checkFields(username,email,role){
    if(username!="" && email!="" && role!=""){
        return true;
    }
    return false;
}
