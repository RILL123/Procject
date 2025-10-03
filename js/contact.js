
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('accountBtn');
    var notif = document.getElementById('loginNotif');
    if (btn && notif) {
        btn.addEventListener('click', function (e) {
            notif.classList.toggle('hidden');
        });
        document.addEventListener('click', function (e) {
            if (!btn.contains(e.target) && !notif.contains(e.target)) {
                notif.classList.add('hidden');
            }
        });
    }
});
