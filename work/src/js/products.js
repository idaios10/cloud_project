$(document).ready(function(){
    addToCart();
    search();
    view_products();
})

function addToCart(){
    $(document).on('click', '#btn_add_to_cart', function(){
        var pid = $(this).attr('data-pid');
        $.ajax({
            url: 'add_to_cart.php',
            method: 'post',
            data :{pid:pid},
            success: function(data){
                const res = JSON.parse(data);
                $('#message').html(res.message);
                if(res.message != 'Product was already in Cart added 1 to quantity'){
                    $.ajax({
                        url: 'orion_create_entity.php',
                        method: 'POST',
                        data: {
                            pid:pid,
                            name: res.name,
                            date: res.date_of_withdrawal
                        },
                        success: function(data){
                            $('#orion1').html(data);
                        }
                    });

                    $.ajax({
                        url: 'orion_add_subscription.php',
                        method: 'POST',
                        data: {
                            pid:pid,
                            name: res.name,
                            date: res.date_of_withdrawal
                        },                        
                        success: function(data){
                            $('#orion2').html(data);
                            // alert(data);
                        }
                    });
                } 
            }
        })
    })
}


function view_products(){
    $.ajax({
		url: "view_products.php",
		type: "POST",
		cache: false,
		success: function(data){
			$('#table').html(data);
		}
	});
}

function search(){
    $('#search').keyup(function(){
        var search =   $(this).val();
        var filter = $('#filter').val();
        // alert(search+filter);
        $.ajax({
            url: 'fetch_products.php',
            type: "POST",
            data:{
                search:search,
                filter:filter
            },
            success: function(data){
                $('#table').html(data);
            }
        });
    });
}


