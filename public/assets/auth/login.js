function login() {    
    var email = $('input[name=email]').val();
    var password = $('input[name=password]').val();
    var csrfToken = $('input[name="_token"]').val();  // Mengambil CSRF token

    fetch(`/login`, {
        method: 'POST',  // Pastikan menggunakan method POST untuk login
        headers: {
            'X-CSRF-TOKEN': csrfToken,  // Menyertakan CSRF token
            'Content-Type': 'application/json'  // Mengatur tipe konten sebagai JSON
        },
        body: JSON.stringify({  // Mengubah objek ke JSON string dan mengirimkannya dalam body
            'email': email,
            'password': password
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();  // Mengambil data JSON dari respons
    })
    .then(data => {
        if (data.ok) {
            // Jika berhasil
            swal({
                title: "Login!",
                text: "Login successfully.",
                icon: "success",
            }).then(() => {
                location.href = '/dashboard'; // Reload halaman setelah OK ditekan
            });
        } else {
            // Jika gagal
            swal({
                title: "Error!",
                text: "Email Or Password is Wrong.",
                icon: "error",
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat login: ' + error.message);
    });
}
