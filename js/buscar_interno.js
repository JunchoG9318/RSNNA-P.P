  // Datos simulados (normalmente vendrían de una BD)
  const internos = [
    { nombre: "Juan Pérez", documento: "123456789", estado: "Activo" },
    { nombre: "María Gómez", documento: "987654321", estado: "Inactivo" },
    { nombre: "Carlos López", documento: "456789123", estado: "Activo" },
    {nombre: "Juan Vargas", documento: "1070609723", estado: "Activo"}         
    
  ];
function buscarInterno() {
    const texto = document.getElementById("busqueda").value.toLowerCase();
    const tbody = document.getElementById("resultadosBusqueda");

    tbody.innerHTML = "";

    const filtrados = internos.filter(i =>
      i.nombre.toLowerCase().includes(texto) ||
      i.documento.includes(texto)
    );

    if (filtrados.length === 0) {
      tbody.innerHTML = `
        <tr>
          <td colspan="3" class="text-center">No se encontraron resultados</td>
        </tr>`;
      return;
    }

    filtrados.forEach(i => {
      tbody.innerHTML += `
        <tr>
          <td>${i.nombre}</td>
          <td>${i.documento}</td>
          <td>${i.estado}</td>
        </tr>`;
    });
  }