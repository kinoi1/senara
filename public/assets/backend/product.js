$(document).ready(function() {
    $('#product').DataTable();

    $('#product tbody tr:first-child td').css('width', '19px'); // Sesuaikan lebar
    console.log($('#product tbody tr:first-child td'));
});

document.getElementById('toggleFormButton').onclick = function(event) {
    const form = document.getElementById('productForm');
    console.log(form.classList);
    if (form.classList.contains('d-none')) {
        // Jika form tersembunyi, tampilkan form
        form.classList.remove('d-none');
    } 
    if ($(event.target).data('trigger') == 'edit') {
    }else {
        resetForm(); // Reset form saat ditampilkan
    }
    $(event.target).data('trigger', '');
    $('.dropify').dropify();
};


function edit(productid, csrfToken) {
    fetch(`/product/edit/${productid}`, {
        method: 'GET', // Mengubah menjadi method GET
        headers: {
            'X-CSRF-TOKEN': csrfToken, // Menyertakan CSRF token jika diperlukan
            'Content-Type': 'application/json'
        },
    })
    .then(response => response.json()) // Mengambil data JSON dari respons
    .then(data => {
        if (data) {
            resetForm();
            console.log(data);
            a = data.product;
            // Mengisi form dengan data yang didapatkan dari server
            $("[name='productid']").val(a.ProductID);
            $("[name='nama']").val(a.Name);
            $("[name='price']").val(a.Price);
            $("[name='qty']").val(a.Qty);
            // $("[name='gambar']").val(a.Image);
            
            $(document.getElementById('toggleFormButton')).data('trigger', 'edit').click();
            // Jika ada field lain, tambahkan di sini
        } else {
            alert('Failed to load product data');
        }
    })
    .catch(error => console.error('Error:', error));
}


// Function to delete a product
function deleteProduct(productid, csrfToken) {
    // Konfirmasi menggunakan SweetAlert1
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this Product!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((isConfirm) => {
        if (isConfirm) {
            // Jika konfirmasi delete disetujui
            fetch(`/product/delete/${productid}`, {
                method: 'POST', // Gunakan POST
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-HTTP-Method-Override': 'DELETE', // Override method ke DELETE
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (response.ok) {
                    // Jika berhasil
                    swal({
                        title: "Deleted!",
                        text: "Product deleted successfully.",
                        icon: "success",
                    }).then(() => {
                        location.reload(); // Reload halaman setelah OK ditekan
                    });
                } else {
                    // Jika gagal
                    swal({
                        title: "Error!",
                        text: "Failed to delete Product.",
                        icon: "error",
                    });
                }
            })
            .catch(error => {
                // Jika ada error lain
                swal({
                    title: "Error!",
                    text: "Something went wrong.",
                    icon: "error",
                });
                console.error('Error:', error);
            });
        }
    });
}



function resetForm() {
    // Reset form menggunakan jQuery
    $('#form')[0].reset();
    $("[name='productid']").val('');
}
