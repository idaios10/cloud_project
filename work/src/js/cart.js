$(document).ready(function(){
    viewCart();
    deleteFromCart();
    addToCart();
})

function viewCart(){
    $.ajax({
		url: "view_cart.php",
		type: "POST",
		cache: false,
		success: function(data){
			$('#table').html(data);
		}
	});
}

function deleteFromCart(){
    $(document).on('click', '#btn_delete_from_cart', function(){
        var id = $(this).attr('data-id');
        var quantity = $(this).attr('data-quantity');
        if(quantity == 1){
            $('#delete').modal('show');
            $(document).on('click', '#delete_product', function(){
                $.ajax({
                    url: 'delete_from_cart.php',
                    method: 'post',
                    data :{
                        id:id,
                        quantity:quantity
                    },
                    success: function(data){
                        viewCart();
                        $('#message').html(data);
                        $('#delete').modal('hide');
                    }
                })
            })
        }
        else{
            $.ajax({
                url: 'delete_from_cart.php',
                method: 'post',
                data :{
                    id:id,
                    quantity:quantity
                },
                success: function(data){
                    viewCart();
                    $('#message').html(data);
                }
            })
        }
    })
}


function addToCart(){
    $(document).on('click', '#btn_add_to_cart', function(){
        var pid = $(this).attr('data-pid');
        $.ajax({
            url: 'add_to_cart.php',
            method: 'post',
            data :{pid:pid},
            success: function(data){
                viewCart();
            }
        })
    })
}

$(document).on('click','#btn_close', function(){
    $('form').trigger('reset');
    $('#message').html('');
    $('#up-message').html('');
    $('#delete-message').html('');
})
