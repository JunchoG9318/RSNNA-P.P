<?php
include("header.php");
?>

<div class="container py-4">

    <!-- BUSCADOR -->
    <div class="row mb-4 justify-content-center">

        <div class="col-md-6">

            <input type="text"
                   id="busqueda"
                   class="form-control"
                   placeholder="Buscar por nombre o documento..."
                   onkeyup="buscarInterno()">

        </div>

    </div>


    <!-- RESULTADOS -->
    <div class="row justify-content-center">

        <div class="col-md-10">

            <table class="table table-bordered table-striped shadow">

                <thead class="table-success text-center">

                    <tr>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Estado</th>
                    </tr>

                </thead>

                <tbody id="resultadosBusqueda">
                    <!-- Resultados -->
                </tbody>

            </table>

        </div>

    </div>

</div>


<script>

    // Datos simulados (luego vendrán de BD)
    const internos = [

        { nombre: "Juan Pérez", documento: "123456789", estado: "Activo" },
        { nombre: "María Gómez", documento: "987654321", estado: "Inactivo" },
        { nombre: "Carlos López", documento: "456789123", estado: "Activo" },
        { nombre: "Juan Vargas", documento: "1070609723", estado: "Activo" }

    ];


    // Mostrar todos al cargar
    mostrarTodos();


    function mostrarTodos() {

        const tbody = document.getElementById("resultadosBusqueda");

        tbody.innerHTML = "";

        internos.forEach(i => {

            tbody.innerHTML += `
                <tr class="text-center">
                    <td>${i.nombre}</td>
                    <td>${i.documento}</td>
                    <td>${i.estado}</td>
                </tr>
            `;

        });

    }


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
                    <td colspan="3" class="text-center text-danger">
                        No se encontraron resultados
                    </td>
                </tr>
            `;

            return;
        }


        filtrados.forEach(i => {

            tbody.innerHTML += `
                <tr class="text-center">
                    <td>${i.nombre}</td>
                    <td>${i.documento}</td>
                    <td>${i.estado}</td>
                </tr>
            `;

        });

    }

</script>


<?php
include("footer.php");
?>
