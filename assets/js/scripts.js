document.querySelector('.btn-back').addEventListener('click', function() {
    if (document.referrer) {
        window.location.href = document.referrer;
    } else {
        window.location.href = '/index.php';
    }
});