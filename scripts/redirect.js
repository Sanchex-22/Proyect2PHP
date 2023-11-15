document.getElementById('redireccionarBtn').addEventListener('click', function() {
    window.location.href = 'create_task.php';
});

document.querySelectorAll('.edit-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        window.location.href = 'edit_task.php';
    });
});
