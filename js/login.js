function togglePassword(id, btn) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
        input.type = 'text';
        btn.querySelector('svg').classList.add('text-indigo-600');
    } else {
        input.type = 'password';
        btn.querySelector('svg').classList.remove('text-indigo-600');
    }
}
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtns = document.querySelectorAll('.toggle-password');
    toggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const inputId = btn.getAttribute('data-input');
            togglePassword(inputId, btn);
        });
    });
});
document.getElementById('loginForm').addEventListener('submit', function (e) {
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();
    if (!username || !password) {
        e.preventDefault();
        alert('Please fill in all fields');
    }
});