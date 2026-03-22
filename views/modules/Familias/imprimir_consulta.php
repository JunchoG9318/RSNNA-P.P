<?php
define("BASE_URL", "/proyectoclon/RSNNA-P.P/");
session_start();

// ============================================
// VALIDAR SESIÓN
// ============================================
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "views/modules/login/login.php");
    exit();
}

include "../../../config/conexion.php";
include("../../../header.php");

// ============================================
// DATOS DEL USUARIO
// ============================================
$usuario = $_SESSION['usuario_nombre'] ?? 'No identificado';
$tipo_usuario = $_SESSION['usuario_tipo'] ?? 'Sin rol';
$usuario_id = $_SESSION['usuario_id'];

// ============================================
// PROCESAR BÚSQUEDA
// ============================================
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$busqueda_segura = mysqli_real_escape_string($conexion, $busqueda);

// ============================================
// CONSULTA CORREGIDA - FILTRA POR NOMBRE TAMBIÉN
// ============================================
$sql = "SELECT 
            -- Datos del menor desde ingresos_fundacion
            i.menor_nombres,
            i.menor_tipo_doc,
            i.menor_num_doc,
            i.fecha_nacimiento,
            i.sexo,
            i.direccion_domicilio,
            i.eps,
            i.salud_general,
            
            -- Datos de la fundación
            i.fundacion_nombre,
            i.fundacion_direccion,
            f.nombre_director,
            f.telefono_director,
            f.ciudad,
            
            -- Datos del familiar desde registro_familiar
            rf.nombre AS familiar_nombre,
            rf.apellidos AS familiar_apellidos,
            rf.parentesco,
            rf.telefono_celular AS familiar_telefono,
            rf.correo_electronico AS familiar_correo,
            rf.interno_nombre AS nombre_esperado
            
        FROM registro_familiar rf
        
        -- Unir con ingresos_fundacion usando documento Y nombre aproximado
        LEFT JOIN ingresos_fundacion i ON 
            TRIM(rf.interno_numero_documento) = TRIM(i.menor_num_doc)
            AND (
                -- Coincidencia exacta de nombre
                UPPER(TRIM(rf.interno_nombre)) = UPPER(TRIM(i.menor_nombres))
                OR
                -- O el nombre de rf está contenido en i.menor_nombres
                UPPER(TRIM(rf.interno_nombre)) LIKE CONCAT('%', UPPER(TRIM(i.menor_nombres)), '%')
                OR
                -- O i.menor_nombres está contenido en rf.interno_nombre
                UPPER(TRIM(i.menor_nombres)) LIKE CONCAT('%', UPPER(TRIM(rf.interno_nombre)), '%')
            )
        
        -- Unir con fundaciones para obtener datos actualizados
        LEFT JOIN fundaciones f ON i.fundacion_nombre = f.nombre
        
        -- Filtrar por el usuario logueado
        WHERE rf.id_usuario = '$usuario_id'";

// ============================================
// AGREGAR BÚSQUEDA POR DOCUMENTO O NOMBRE
// ============================================
if (!empty($busqueda)) {
    $sql .= " AND (
                i.menor_num_doc LIKE '%$busqueda_segura%' 
                OR i.menor_nombres LIKE '%$busqueda_segura%'
                OR rf.interno_numero_documento LIKE '%$busqueda_segura%'
                OR rf.interno_nombre LIKE '%$busqueda_segura%'
            )";
}

$sql .= " 
        -- Para cada registro_familiar, obtener el ingreso más reciente que coincida
        AND (i.fecha_ingreso IS NULL OR i.fecha_ingreso = (
            SELECT MAX(i2.fecha_ingreso)
            FROM ingresos_fundacion i2
            WHERE TRIM(i2.menor_num_doc) = TRIM(rf.interno_numero_documento)
            AND (
                UPPER(TRIM(rf.interno_nombre)) = UPPER(TRIM(i2.menor_nombres))
                OR UPPER(TRIM(rf.interno_nombre)) LIKE CONCAT('%', UPPER(TRIM(i2.menor_nombres)), '%')
                OR UPPER(TRIM(i2.menor_nombres)) LIKE CONCAT('%', UPPER(TRIM(rf.interno_nombre)), '%')
            )
        ))
        
        ORDER BY rf.fecha_registro DESC";

$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$total_registros = mysqli_num_rows($resultado);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script>
    function imprimirTarjeta(id) {
        var contenido = document.getElementById(id).outerHTML;
        var ventana = window.open('', '', 'width=800,height=600');
        ventana.document.write(`
        <html>
        <head>
            <title>Imprimir</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
                .card { border: 1px solid #ccc; border-radius: 12px; overflow: hidden; margin-bottom: 20px; }
                .card-header { background-color: #006341; color: white; padding: 15px; font-weight: bold; font-size: 1.2rem; }
                .card-body { padding: 15px; }
                .info-row { display: flex; margin-bottom: 10px; border-bottom: 1px dashed #e0e0e0; padding-bottom: 8px; }
                .info-label { width: 130px; font-weight: 600; color: #006341; }
                .info-value { flex: 1; color: #333; }
                .section-title { color: #006341; font-weight: bold; margin: 15px 0 10px 0; border-left: 4px solid #006341; padding-left: 10px; }
                hr { border: 1px solid #006341; opacity: 0.3; }
            </style>
        </head>
        <body>${contenido}</body>
        </html>
        `);
        ventana.document.close();
        ventana.print();
    }
</script>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
    .container { width: 100%; max-width: 1400px; margin: 0 auto; padding: 20px; }
    
    /* ESTILOS DEL BUSCADOR */
    .buscador-container {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin: 20px 0 30px 0;
        box-shadow: 0 4px 12px rgba(0,99,65,0.15);
        border: 2px solid #006341;
    }
    .buscador-titulo {
        color: #006341;
        font-size: 1.3rem;
        font-weight: bold;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .buscador-form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }
    .buscador-input {
        flex: 1;
        min-width: 300px;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s;
    }
    .buscador-input:focus {
        outline: none;
        border-color: #006341;
        box-shadow: 0 0 0 3px rgba(0,99,65,0.1);
    }
    .buscador-btn {
        background: #006341;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .buscador-btn:hover {
        background: #004d33;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,99,65,0.3);
    }
    .buscador-limpiar {
        background: #dc3545;
        color: white;
        border: none;
        padding: 15px 25px;
        border-radius: 8px;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .buscador-limpiar:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    .buscador-info {
        margin-top: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        color: #006341;
        font-size: 0.95rem;
        border-left: 4px solid #006341;
    }
    
    /* TUS ESTILOS ORIGINALES */
    .card-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px; margin-top: 20px; }
    .card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1); border: 1px solid #e0e0e0; transition: transform 0.3s; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,99,65,0.2); }
    .card-header { background-color: #006341; color: white; padding: 15px; font-weight: bold; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; }
    .card-body { padding: 20px; }
    .info-row { display: flex; margin-bottom: 12px; border-bottom: 1px dashed #e0e0e0; padding-bottom: 8px; }
    .info-label { width: 130px; font-weight: 600; color: #006341; }
    .info-value { flex: 1; color: #333; }
    .section-title { color: #006341; font-weight: bold; margin: 15px 0 10px 0; border-left: 4px solid #006341; padding-left: 10px; }
    .badge { background-color: #006341; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; display: inline-block; margin: 0 5px 10px 0; }
    .title { text-align: center; margin-bottom: 30px; }
    .title h1 { color: #006341; }
    .footer { width: 100%; background-color: #006341; color: white; text-align: center; padding: 20px; margin-top: 30px; }
    .btn-volver { background: white; color: #006341 !important; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; }
    .btn-volver:hover { background: #e8f0e8; transform: translateY(-2px); box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
    .alert-info { background-color: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 8px; text-align: center; }
    @media print { header, .footer, .btn-volver, button, .buscador-container { display: none !important; } }
</style>

<body>
    <!-- Header -->
    <div style="width: 100%; background-color: #006341; color: white; padding: 15px 0;">
        <div style="width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 20px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <i class="bi bi-person-circle me-2"></i>
                <strong><?php echo $usuario; ?></strong> | 
                <span class="badge"><?php echo $tipo_usuario; ?></span>
            </div>
            <a href="<?php echo BASE_URL; ?>views/modules/Familias/panel_familia.php" class="btn-volver">
                <i class="bi bi-arrow-left me-2"></i>Volver al panel
            </a>
        </div>
    </div>

    <div class="container">
        <div class="title">
            <h1><i class="bi bi-search me-2"></i>Sistema RSNNA - ICBF</h1>
            <div class="badge"><i class="bi bi-calendar me-2"></i><?php echo date('d/m/Y H:i'); ?></div>
        </div>

        <!-- BUSCADOR AGREGADO -->
        <div class="buscador-container">
            <div class="buscador-titulo">
                <i class="bi bi-search" style="font-size: 1.5rem;"></i>
                Buscar Niño, Niña o Adolescente (NNA)
            </div>
            
            <form method="GET" action="" class="buscador-form">
                <input type="text" 
                       name="busqueda" 
                       class="buscador-input" 
                       placeholder="Ingrese número de documento o nombre completo..."
                       value="<?php echo htmlspecialchars($busqueda); ?>"
                       autocomplete="off">
                <button type="submit" class="buscador-btn">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if (!empty($busqueda)): ?>
                    <a href="imprimir_consulta.php" class="buscador-limpiar">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                <?php endif; ?>
            </form>
            
            <?php if (!empty($busqueda)): ?>
                <div class="buscador-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Búsqueda:</strong> "<?php echo htmlspecialchars($busqueda); ?>" | 
                    <strong>Resultados:</strong> <?php echo $total_registros; ?> encontrado(s)
                </div>
            <?php else: ?>
                <div class="buscador-info">
                    <i class="bi bi-info-circle me-2"></i>
                    Ejemplos: <strong>1070463862</strong> (documento), <strong>Kevin Molina</strong> (nombre completo)
                </div>
            <?php endif; ?>
        </div>

        <!-- TOTAL DE REGISTROS -->
        <div class="badge" style="margin-bottom: 20px;">
            <i class="bi bi-files me-2"></i>Total registros: <?php echo $total_registros; ?>
        </div>

        <div class="card-grid">
            <?php
            if ($total_registros == 0 && !empty($busqueda)) {
                echo "<div class='alert-info'><i class='bi bi-info-circle me-2'></i>No se encontraron resultados para '<strong>" . htmlspecialchars($busqueda) . "</strong>'</div>";
            } elseif ($total_registros == 0) {
                echo "<div class='alert-info'><i class='bi bi-info-circle me-2'></i>No hay registros de menores asociados a esta familia.</div>";
            }
            
            $contador = 0;
            while ($row = mysqli_fetch_assoc($resultado)) {
                $contador++;
                $fecha_nac = !empty($row['fecha_nacimiento']) ? date('d/m/Y', strtotime($row['fecha_nacimiento'])) : 'No registrada';
                
                // Determinar si hay datos de fundación
                $tiene_fundacion = !empty($row['fundacion_nombre']);
            ?>
                <div class="card" id="card_<?php echo $contador; ?>">
                    <div class="card-header">
                        <i class="bi bi-person-circle"></i> 
                        <?php echo htmlspecialchars($row['menor_nombres'] ?: $row['nombre_esperado']); ?>
                    </div>
                    <div class="card-body">
                        <!-- Datos básicos del menor -->
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-card-text me-2"></i>Documento:</span>
                            <span class="info-value">
                                <?php echo $row['menor_tipo_doc'] ?: 'TI'; ?> 
                                <?php echo $row['menor_num_doc'] ?: 'No disponible'; ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label"><i class="bi bi-calendar me-2"></i>Nacimiento:</span>
                            <span class="info-value"><?php echo $fecha_nac; ?></span>
                        </div>
                        
                        <!-- Datos de la fundación (si existe) -->
                        <div class="section-title">
                            <i class="bi bi-building me-2"></i>Fundación
                        </div>
                        
                        <?php if ($tiene_fundacion): ?>
                            <div class="info-row">
                                <span class="info-label">Fundación:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['fundacion_nombre']); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Dirección:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['fundacion_direccion'] ?: 'No disponible'); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Ciudad:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['ciudad'] ?: 'No disponible'); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Director:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['nombre_director'] ?: 'No disponible'); ?></span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tel. Director:</span>
                                <span class="info-value"><?php echo htmlspecialchars($row['telefono_director'] ?: 'No disponible'); ?></span>
                            </div>
                        <?php else: ?>
                            <div class="info-row">
                                <span class="info-label">Fundación:</span>
                                <span class="info-value text-muted"><em>Sin fundación asignada</em></span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Datos del familiar -->
                        <div class="section-title">
                            <i class="bi bi-people me-2"></i>Familiar a Cargo
                        </div>
                        <div class="info-row">
                            <span class="info-label">Nombre:</span>
                            <span class="info-value">
                                <?php echo htmlspecialchars($row['familiar_nombre'] . ' ' . $row['familiar_apellidos']); ?>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Parentesco:</span>
                            <span class="info-value"><?php echo htmlspecialchars($row['parentesco']); ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Teléfono:</span>
                            <span class="info-value"><?php echo htmlspecialchars($row['familiar_telefono']); ?></span>
                        </div>
                        
                        <button onclick="imprimirTarjeta('card_<?php echo $contador; ?>')"
                            style="margin-top:20px; background:#006341; color:white; border:none; padding:10px; border-radius:5px; cursor:pointer; width:100%; font-size:1rem;">
                            <i class="bi bi-printer me-2"></i>Imprimir
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="footer">
        <i class="bi bi-shield-check me-2"></i>Sistema RSNNA - ICBF | Protegiendo a la niñez y adolescencia
    </div>

</body>

<?php include("../../../footer.php"); ?>