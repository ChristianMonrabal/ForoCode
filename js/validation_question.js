document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('questionForm');
    const respuestaForm = document.getElementById('respuestaForm');

    const validateField = (field, errorElement, message) => {
        if (field && errorElement) {
            if (field.value.trim() === '') {
                errorElement.innerHTML = `<div class="alert alert-danger mt-1">${message}</div>`;
                field.classList.add('is-invalid');
            } else {
                errorElement.innerHTML = '';
                field.classList.remove('is-invalid');
            }
        }
    };

    if (respuestaForm) {
        const contenido = document.getElementById('contenido');
        const errorContenido = document.getElementById('errorContenido');

        contenido.addEventListener('blur', () => {
            validateField(contenido, errorContenido, 'El contenido de la respuesta es obligatorio.');
        });

        respuestaForm.addEventListener('submit', function(event) {
            if (contenido.value.trim().length === 0) {
                event.preventDefault();
                errorContenido.innerHTML = `<div class="alert alert-danger mt-1">El contenido no puede estar vacío.</div>`;
                contenido.classList.add('is-invalid');
            } else if (contenido.value.length > 500) {
                event.preventDefault();
                errorContenido.innerHTML = `<div class="alert alert-danger mt-1">La respuesta no puede exceder los 500 caracteres.</div>`;
                contenido.classList.add('is-invalid');
            } else {
                contenido.classList.remove('is-invalid');
                errorContenido.innerHTML = ""; 
            }
        });
    }

    if (form) {
        const titulo = document.getElementById('titulo');
        const descripcion = document.getElementById('descripcion');
        const errorTitulo = document.getElementById('errorTitulo');
        const errorDescripcion = document.getElementById('errorDescripcion');

        titulo.addEventListener('blur', () => 
            validateField(titulo, errorTitulo, 'El título es obligatorio.')
        );
        descripcion.addEventListener('blur', () => 
            validateField(descripcion, errorDescripcion, 'La descripción es obligatoria.')
        );

        form.addEventListener('submit', (e) => {
            validateField(titulo, errorTitulo, 'El título es obligatorio.');
            validateField(descripcion, errorDescripcion, 'La descripción es obligatoria.');

            if (
                titulo.classList.contains('is-invalid') ||
                descripcion.classList.contains('is-invalid')
            ) {
                e.preventDefault();
            }
        });
    }
});