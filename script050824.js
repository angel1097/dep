document.addEventListener('DOMContentLoaded', function() {
    const editFormContainer = document.getElementById('editFormContainer');
    const editForm = document.getElementById('editForm');
    const editId = document.getElementById('editId');
    const editName = document.getElementById('editName');
    const editNum = document.getElementById('editNum');
    const editEmail = document.getElementById('editEmail');
    const editTel = document.getElementById('editTel');

    document.querySelectorAll('.editBtn').forEach(button => {
        button.addEventListener('click', function() {
            editId.value = this.dataset.id;
            editName.value = this.dataset.nombre;
            editNum.value = this.dataset.numero;
            editEmail.value = this.dataset.email;
            editTel.value = this.dataset.telefono;
            editFormContainer.style.display = 'block';
        });
    });

    editForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Evitar el envío del formulario hasta la confirmación
        Swal.fire({
            title: '¿Está seguro?',
            text: '¿Desea actualizar este usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                editForm.submit(); // Enviar el formulario si se confirma
            }
        });
    });

    document.querySelectorAll('.deleteForm').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Evitar el envío del formulario hasta la confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'No podrás recuperar este usuario después de eliminarlo.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Enviar el formulario si se confirma
                }
            });
        });
    });

    document.getElementById('cancelEditBtn').addEventListener('click', function() {
        editFormContainer.style.display = 'none';
    });
});
