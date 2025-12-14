// login.js - Integrasi Login dengan API

const AUTH_URL = 'auth.php';

// Event listener untuk form login
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const rememberMe = document.getElementById('rememberMe').checked;
    const loginBtn = document.getElementById('loginBtn');
    
    // Disable button dan tampilkan loading
    loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
    loginBtn.disabled = true;
    
    // Buat FormData
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    
    // Kirim request ke API
    fetch(`${AUTH_URL}?action=login`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data); // Debug
        
        if (data.success) {
            showAlert(data.message, 'success');
            
            // Simpan remember me jika dicentang
            if (rememberMe) {
                localStorage.setItem('rememberMe', 'true');
                localStorage.setItem('username', username);
            } else {
                localStorage.removeItem('rememberMe');
                localStorage.removeItem('username');
            }
            
            // Redirect ke dashboard
            setTimeout(() => {
                window.location.href = data.data.redirect;
            }, 1500);
        } else {
            showAlert(data.message, 'danger');
            loginBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Masuk';
            loginBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan koneksi. Pastikan server Apache dan MySQL aktif.', 'danger');
        loginBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Masuk';
        loginBtn.disabled = false;
    });
});

// Event listener untuk forgot password
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('resetEmail').value;
    
    const formData = new FormData();
    formData.append('email', email);
    
    fetch(`${AUTH_URL}?action=forgot_password`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Link reset password telah dikirim ke ${email}`);
            bootstrap.Modal.getInstance(document.getElementById('forgotPasswordModal')).hide();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
});

// Fungsi show alert
function showAlert(message, type = 'danger') {
    const alertDiv = document.getElementById('alertMessage');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `<i class="fas fa-${type === 'danger' ? 'exclamation-circle' : 'check-circle'} me-2"></i>${message}`;
    alertDiv.style.display = 'block';
    
    setTimeout(() => {
        alertDiv.style.display = 'none';
    }, 5000);
}

// Load remember me data saat halaman dimuat
window.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('rememberMe') === 'true') {
        document.getElementById('username').value = localStorage.getItem('username') || '';
        document.getElementById('rememberMe').checked = true;
    }
});

// Hide alert saat user mengetik
document.querySelectorAll('#username, #password').forEach(input => {
    input.addEventListener('input', () => {
        document.getElementById('alertMessage').style.display = 'none';
    });
});

// Toggle password visibility
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');

togglePassword.addEventListener('click', function() {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('fa-eye');
    this.classList.toggle('fa-eye-slash');
});