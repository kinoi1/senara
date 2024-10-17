$(document).ready(function() {
    $('#reseller').DataTable();
});

document.getElementById('toggleFormButton').onclick = function(event) {
    const form = document.getElementById('resellerForm');
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


function edit(resellerid, csrfToken) {
    fetch(`/reseller/edit/${resellerid}`, {
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
            a = data.reseller;
            // Mengisi form dengan data yang didapatkan dari server
            $("[name='resellerid']").val(a.ResellerID);
            $("[name='nama']").val(a.Name);
            $("[name='refferal']").val(a.Refferal);
            $(document.getElementById('toggleFormButton')).data('trigger', 'edit').click();
            // Jika ada field lain, tambahkan di sini
        } else {
            alert('Failed to load product data');
        }
    })
    .catch(error => console.error('Error:', error));
}


// Function to delete a product
function deleteReseller(resellerid, csrfToken) {
    // Konfirmasi menggunakan SweetAlert1
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this reseller!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((isConfirm) => {
        if (isConfirm) {
            // Jika konfirmasi delete disetujui
            fetch(`/reseller/delete/${resellerid}`, {
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
                        text: "Reseller deleted successfully.",
                        icon: "success",
                    }).then(() => {
                        location.reload(); // Reload halaman setelah OK ditekan
                    });
                } else {
                    // Jika gagal
                    swal({
                        title: "Error!",
                        text: "Failed to delete reseller.",
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
    $("[name='resellerid']").val('');
}
