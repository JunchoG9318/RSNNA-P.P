// Al cargar la página, llenar el select de fundaciones
fetch('obtener_fundaciones.php')
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById('fundacion_nombre');
        // Limpiar opciones (dejando solo la primera si es necesario)
        select.innerHTML = '<option selected disabled>-- Seleccione una fundación --</option>';
        data.forEach(f => {
            const option = document.createElement('option');
            option.value = f.id;       // o f.nombre si prefieres
            option.textContent = f.nombre;
            select.appendChild(option);
        });
    })
    .catch(error => console.error('Error cargando fundaciones:', error));