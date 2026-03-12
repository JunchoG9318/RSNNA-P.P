document.getElementById('formCompleto').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('accion', idEdicion ? 'actualizar' : 'guardar');
    if (idEdicion) formData.append('id', idEdicion);

    fetch('controlador_registro_interno.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Registro guardado correctamente');
            idEdicion = null;
            this.reset();
            cargarRegistros();
            document.querySelector('#fundacion-tab').click();
        } else {
            alert('Error: ' + (result.error || 'Desconocido'));
        }
    })
    .catch(error => console.error('Error al guardar:', error));
});

function cargarRegistros() {
    fetch('controlador_registro_interno.php?accion=listar')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('tablaRegistros');
            tbody.innerHTML = '';
            data.forEach(r => {
                tbody.innerHTML += `
                    <tr>
                        <td>${r.id}</td>
                        <td>${r.fecha_ingreso || ''}</td>
                        <td>${r.menor_nombres || ''}</td>
                        <td>${r.menor_tipo_doc || ''} ${r.menor_num_doc || ''}</td>
                        <td>${r.acudiente_nombres || ''}</td>
                        <td>${r.motivo_ingreso || ''}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="editarRegistro(${r.id})">Editar</button>
                            <button class="btn btn-danger btn-sm" onclick="eliminarRegistro(${r.id})">Eliminar</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error cargando registros:', error));
}

function editarRegistro(id) {
    fetch('controlador_registro_interno.php?accion=obtener&id=' + id)
        .then(response => response.json())
        .then(r => {
            if (r.error) {
                alert(r.error);
                return;
            }
            idEdicion = id;
            
            // Función para asignar valor a un campo por su id
            const setVal = (idCampo, valor) => {
                const campo = document.getElementById(idCampo);
                if (campo) {
                    if (campo.type === 'radio') {
                        const radio = document.querySelector(`input[name="${campo.name}"][value="${valor}"]`);
                        if (radio) radio.checked = true;
                    } else {
                        campo.value = valor || '';
                    }
                }
            };
            
            // Asignar todos los campos (la lista completa de tu código original)
            // ... (mantén todas las asignaciones que ya tenías)
        })
        .catch(error => console.error('Error al obtener registro:', error));
}

function eliminarRegistro(id) {
    if (confirm('¿Eliminar este registro?')) {
        fetch('controlador_registro_interno.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'accion=eliminar&id=' + id
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                alert('Registro eliminado');
                cargarRegistros();
            } else {
                alert('Error al eliminar: ' + (result.error || 'Desconocido'));
            }
        })
        .catch(error => console.error('Error al eliminar:', error));
    }
}

