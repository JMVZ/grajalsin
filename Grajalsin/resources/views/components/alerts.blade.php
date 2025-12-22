<!-- SweetAlert2 - Mensajes de sesión -->
@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#16a34a',
            timer: 3000,
            timerProgressBar: true,
        });
    });
</script>
@endif

@if (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc2626',
        });
    });
</script>
@endif

@if (session('warning'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: '{{ session('warning') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f59e0b',
        });
    });
</script>
@endif

@if (session('info'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'info',
            title: 'Información',
            text: '{{ session('info') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3b82f6',
        });
    });
</script>
@endif

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Error de validación',
            html: `
                <ul style="text-align: left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc2626',
        });
    });
</script>
@endif

<!-- Función global para confirmación de eliminación -->
<script>
function confirmDelete(arg1, arg2) {
    const isEvent = typeof arg1 === 'object' && arg1 !== null && 'preventDefault' in arg1;
    const event = isEvent ? arg1 : (typeof window !== 'undefined' ? window.event : null);
    const formId = isEvent ? arg2 : arg1;

    if (event && typeof event.preventDefault === 'function') {
        event.preventDefault();
    }

    if (!formId) {
        console.warn('confirmDelete: formId no proporcionado');
        return;
    }
    const form = document.getElementById(formId);

    if (!form) {
        console.warn('confirmDelete: no se encontró el formulario con id', formId);
        return;
    }

    const submitForm = () => {
        const submitter = form.querySelector('[type="submit"], button');
        if (submitter) {
            submitter.disabled = true;
        }
        form.submit();
    };

    if (typeof Swal === 'undefined') {
        if (confirm('¿Estás seguro? Esta acción no se puede revertir.')) {
            submitForm();
        }
        return;
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm();
        }
    });
}

function confirmAction(arg1, arg2, arg3) {
    const isEvent = typeof arg1 === 'object' && arg1 !== null && 'preventDefault' in arg1;
    const event = isEvent ? arg1 : (typeof window !== 'undefined' ? window.event : null);
    const message = isEvent ? arg2 : arg1;
    const formId = isEvent ? arg3 : arg2;

    if (event && typeof event.preventDefault === 'function') {
        event.preventDefault();
    }

    if (!formId) {
        console.warn('confirmAction: formId no proporcionado');
        return;
    }
    const form = document.getElementById(formId);

    if (!form) {
        console.warn('confirmAction: no se encontró el formulario con id', formId);
        return;
    }

    const submitForm = () => {
        const submitter = form.querySelector('[type="submit"], button');
        if (submitter) {
            submitter.disabled = true;
        }
        form.submit();
    };

    if (typeof Swal === 'undefined') {
        if (confirm(message || '¿Estás seguro?')) {
            submitForm();
        }
        return;
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: message,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm();
        }
    });
}
</script>

