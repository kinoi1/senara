$(document).ready(function(){
    CountCart();

    $('#cart_icon').mouseenter(function() {
        $('.cart-modal').show(); // Menampilkan modal saat kursor masuk
    });

    $('#cart_icon').mouseleave(function() {
        $('.cart-modal').hide(); // Menyembunyikan modal saat kursor keluar
    });

    // Jika ingin modal tetap tampil saat kursor ada di atas modal
    $('.cart-modal').mouseenter(function() {
        $(this).show();
    }).mouseleave(function() {
        $(this).hide();
    });
});

function CountCart(){
    var cart = document.getElementById("totalcart").innerText;
    if(parseInt(cart) > 0){
        $('#totalcart').show();
    }
}

function addtocart(id,button){

    token = button.getAttribute('data-token');
    qty  = $('#qty_'+id).val();
    var cart = document.getElementById("totalcart").innerText;
    if(cart == ''){
        cart = 0;
    }
    cart = parseInt(cart) + 1;
    document.getElementById("totalcart").innerText = cart;

    if(parseInt(cart) > 0){
        $('#totalcart').show();
    }
    $.ajax({
        url: 'paket/add-to-cart',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: JSON.stringify({
            'productid': id,
            'qty': qty,
        }),
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                console.log(response.message);
            } else {
                console.log('Failed to add product to cart');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}