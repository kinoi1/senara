
function addtocart(id){

    var cart = document.getElementById("totalcart").innerText;
    if(cart == ''){
        cart = 0;
    }
    document.getElementById("totalcart").innerText = parseInt(cart) + 1;
}