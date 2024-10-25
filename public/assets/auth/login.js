function login() {    
    var email = $('input[name=email]').val();
    var password = $('input[name=password]').val();
    var csrfToken = $('input[name="_token"]').val();  // Mengambil CSRF token
    $.ajax({
        url: '/login',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: JSON.stringify({
            'email': email,
            'password': password
        }),
        contentType: 'application/json',
        dataType: 'json',
        success: function(data) {
            if (data.status) {
                // Jika login berhasil, arahkan pengguna ke /dashboard
                swal({
                    title: "Login!",
                    text: "Login successfully.",
                    icon: "success",
                }).then(() => {
                    location.href = '/dashboard'; // Reload halaman setelah OK ditekan
                });
            } else {
                // Jika login gagal, tampilkan pesan error
                swal({
                    title: "Login!",
                    text: "Username Or Password is Wrong.",
                    icon: "danger",
                })
            }
        },
        error: function(jqXHR) {
            // Menangani error dengan status selain 200
            console.error('Error:', jqXHR.responseJSON.message);
            alert('Login failed: ' + jqXHR.responseJSON.message);
        }
    });
}
