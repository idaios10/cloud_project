$(document).ready(function(){
    view_products();
    insery_product();
    getRecord();
    updateProduct();
    deleteProduct();
})

function insery_product(){
    $(document).on('click', '#btn_register', function(){
        var name = $('#name').val();
        var pcode = $('#pcode').val();
        var price = $('#price').val();
        var date = $('#date').val();
        var category = $('#category').val();

        if(!checkFields(name,pcode,price,date,category)){
            $('#message').html('Please fill in the blanks')
        }
        else{
            $.ajax({
                url: "insert_product.php",
                method: "post",
                data:{
                    name: name,
                    pcode: pcode,
                    price: price,
                    date: date,
                    category: category
                },
                success: function(data){
                    $('#Registration').modal('show');
                    $('form').trigger('reset');
                    view_products();
                    $('#msg').html(data);
                }
            })
        }
    })

    $(document).on('click','#btn_close', function(){
        $('form').trigger('reset');
        $('#message').html('');
        $('#up-message').html('');
        $('#delete-message').html('');
    })
}

function view_products(){
    $.ajax({
		url: "view_my_products.php",
		type: "POST",
		cache: false,
		success: function(data){
			$('#table').html(data);
		}
	});
}


//Get Single Record
function getRecord(){
    $(document).on('click','#btn_edit', function(){
        var id = $(this).attr('data-id');
        var name = $(this).attr('data-name');
        var pcode = $(this).attr('data-pcode');
        var price = $(this).attr('data-price');
        var date = $(this).attr('data-date');
        var category = $(this).attr('data-category');
        $('#update').modal('show');
        $('#up_id').val(id);
        $('#up_name').val(name);
		$('#up_pcode').val(pcode);
		$('#up_price').val(price);
		$('#up_date').val(date);
		$('#up_category').val(category);
    })
}


function updateProduct(){
    $(document).on('click','#btn_update', function(){
        var id = $('#up_id').val();
        var name = $('#up_name').val();
        var pcode = $('#up_pcode').val();
        var price = $('#up_price').val();
        var date = $('#up_date').val();
        var category = $('#up_category').val();
        if(!checkFields(name,pcode,price,date,category)){
            $('#up-message').html('Please fill in the blanks')
        }
        else{
            $.ajax({
                url: 'update_product.php',
                method: 'post',
                data: {
                    id: id,
                    name: name,
                    pcode: pcode,
                    price: price,
                    date: date,
                    category: category
                },
                success: function(data){
                    $('#up-message').html(data);
                    $('#update').modal('hide');
                    view_products();
                    console.log(data);
                }
            })
        }
    })
}

// Delete Products
function deleteProduct(){
    $(document).on('click', '#btn_delete', function(){
        var id = $(this).attr('data-id1');
        $('#delete').modal('show');
        $(document).on('click', '#delete_product', function(){
            $.ajax({
                url: 'delete_product.php',
                method: 'post',
                data :{id:id},
                success: function(data){
                    $('#delete-message').html(data);    
                    view_products();
                    $('#delete').modal('hide');
                }
            })
        })
    })
}


function checkFields(name,pcode,price,date,category){
    if(name!="" && pcode!="" && price!="" && date!="" && category!=""){
        return true;
    }
    return false;
}
