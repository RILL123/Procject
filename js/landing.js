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

    // Smooth scroll to About section
    var aboutNav = document.getElementById('aboutNav');
    var aboutSection = document.getElementById('about');
    if (aboutNav && aboutSection) {
        aboutNav.addEventListener('click', function (e) {
            e.preventDefault();
            aboutSection.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Smooth scroll to Services section
    var servicesNav = document.getElementById('servicesNav');
    var servicesSection = document.getElementById('services');
    if (servicesNav && servicesSection) {
        servicesNav.addEventListener('click', function (e) {
            e.preventDefault();
            servicesSection.scrollIntoView({ behavior: 'smooth' });
        });
    }
});
