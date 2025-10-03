document.addEventListener('DOMContentLoaded', function () {
    let modal = document.getElementById('modal-konfirmasi');
    let modalYa = document.getElementById('modal-ya');
    let modalTidak = document.getElementById('modal-tidak');
    let modalPesan = document.getElementById('modal-pesan');
    let formToSubmit = null;

    // Hapus episode
    document.querySelectorAll('.btn-hapus-episode').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            formToSubmit = btn.closest('form');
            modalPesan.textContent = 'Apakah Anda yakin ingin menghapus episode ini?';
            modal.classList.remove('hidden');
        });
    });

    // Hapus anime
    let btnHapusAnime = document.getElementById('btn-hapus-anime');
    if (btnHapusAnime) {
        btnHapusAnime.addEventListener('click', function (e) {
            e.preventDefault();
            // Form edit anime adalah parent terdekat dari tombol
            formToSubmit = btnHapusAnime.closest('form');
            modalPesan.textContent = 'Apakah Anda yakin ingin menghapus anime ini?';
            modal.classList.remove('hidden');
        });
    }

    // Modal tombol
    modalYa.addEventListener('click', function () {
        if (formToSubmit) {
            // Untuk hapus anime, tambahkan input name=delete jika belum ada
            if (formToSubmit.querySelector('input[name="delete"]') === null && formToSubmit.querySelector('#btn-hapus-anime')) {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete';
                input.value = '1';
                formToSubmit.appendChild(input);
            }
            formToSubmit.submit();
        }
        modal.classList.add('hidden');
        formToSubmit = null;
    });
    modalTidak.addEventListener('click', function () {
        modal.classList.add('hidden');
        formToSubmit = null;
    });
});
