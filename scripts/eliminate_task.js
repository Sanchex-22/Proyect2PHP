document.addEventListener('DOMContentLoaded', function() {
    const eliminateButtons = document.querySelectorAll('.btn-eliminar');
    
    eliminateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const taskId = this.dataset.id;
            eliminarTarea(taskId);
        });
    });

    function eliminarTarea(id) {
        // Envía una solicitud al servidor para eliminar la tarea con el ID especificado
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'eliminar_tarea.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                // La tarea fue eliminada exitosamente
                // Puedes actualizar la interfaz o redirigir a otra página si es necesario
                console.log('Tarea eliminada con éxito');
            } else {
                console.error('Error al eliminar la tarea');
            }
        };
        xhr.onerror = function() {
            console.error('Error de red al intentar eliminar la tarea');
        };
        xhr.send('id=' + id);
    }
});