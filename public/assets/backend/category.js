$(document).ready(function() {
    $('#category').DataTable();

    $('#category tbody tr:first-child td').css('width', '19px'); // Sesuaikan lebar
});

document.getElementById('toggleFormButton').onclick = function(event) {
    const form = document.getElementById('categoryForm');
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


function edit(categoryid, csrfToken) {
    fetch(`/category/edit/${categoryid}`, {
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
            a = data.category;
            // Mengisi form dengan data yang didapatkan dari server
            $("[name='categoryid']").val(a.CategoryID);
            $("[name='name']").val(a.Name);
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
function deleteCategory(categoryid, csrfToken) {
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
            fetch(`/category/delete/${categoryid}`, {
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
    $("[name='categoryid']").val('');
}
