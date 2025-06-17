document.addEventListener('DOMContentLoaded', () => {
    // Validación del formulario al enviar
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function (event) {
            clearErrors();

            let valid = true;

            // Validar campo fecha
            const fechaInput = form.querySelector('input[name="fecha"]');
            if (fechaInput) {
                const fechaValor = fechaInput.value;
                if (!fechaValor) {
                    showError(fechaInput, 'La fecha es obligatoria.');
                    valid = false;
                } else if (new Date(fechaValor) < startOfToday()) {
                    showError(fechaInput, 'La fecha debe ser hoy o en el futuro.');
                    valid = false;
                }
            }

            // Validar campo lugar
            const lugarInput = form.querySelector('input[name="lugar"]');
            if (lugarInput && !lugarInput.value.trim()) {
                showError(lugarInput, 'El lugar es obligatorio.');
                valid = false;
            }

            // Validar campo nombre del evento
            const nombreInput = form.querySelector('input[name="nombre_evento"]');
            if (nombreInput && !nombreInput.value.trim()) {
                showError(nombreInput, 'El nombre del evento es obligatorio.');
                valid = false;
            }

            if (!valid) {
                event.preventDefault(); // Evitar envío si hay errores
            }
        });
    }

    // Mostrar error junto al campo
    function showError(inputElem, message) {
        inputElem.classList.add('is-invalid');
        let errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.innerText = message;

        if (inputElem.nextElementSibling && inputElem.nextElementSibling.classList.contains('invalid-feedback')) {
            inputElem.nextElementSibling.remove();
        }
        inputElem.insertAdjacentElement('afterend', errorDiv);
    }

    // Limpiar errores previos
    function clearErrors() {
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    }

    // Filtrar eventos en la tabla según texto ingresado
    const filtroInput = document.getElementById('filtroInput');
    const tabla = document.querySelector('table');

    if (filtroInput && tabla) {
        filtroInput.addEventListener('input', () => {
            const filtro = filtroInput.value.toLowerCase();
            const filas = tabla.querySelectorAll('tbody tr');

            filas.forEach(fila => {
                const nombre = fila.cells[0].innerText.toLowerCase();
                const lugar = fila.cells[2].innerText.toLowerCase();

                fila.style.display = (nombre.includes(filtro) || lugar.includes(filtro)) ? '' : 'none';
            });
        });
    }
});
