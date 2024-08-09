<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('Config.php');

$message = ''; // Variable para almacenar el mensaje de éxito
$messageType = ''; // Variable para almacenar el tipo de mensaje

// Crear (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    $sql = "INSERT INTO departamento (nombre, numero, email, telefono) VALUES ('$nombre', '$numero', '$email', '$telefono')";
    if ($conn->query($sql) === TRUE) {
        $message = 'Usuario agregado correctamente.';
        $messageType = 'success';
    } else {
        $message = 'Error: ' . $conn->error;
        $messageType = 'error';
    }
}

// Actualizar (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];

    $sql = "UPDATE departamento SET nombre='$nombre', numero='$numero', email='$email', telefono='$telefono' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = 'Usuario actualizado correctamente.';
        $messageType = 'success';
    } else {
        $message = 'Error: ' . $conn->error;
        $messageType = 'error';
    }
}

// Borrar (Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    $sql = "DELETE FROM departamento WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = 'Usuario eliminado correctamente.';
        $messageType = 'success';
    } else {
        $message = 'Error: ' . $conn->error;
        $messageType = 'error';
    }

    // Evitar que el mensaje de SweetAlert se muestre más de una vez
    if (isset($_POST['ajax'])) {
        echo json_encode(['message' => $message, 'type' => $messageType]);
        exit;
    }
}

// Leer (Read)
$sql = "SELECT id, nombre, numero, email, telefono FROM departamento";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Example</title>
    <link rel="stylesheet" href="estilo050824.css">
    <script src="script050824.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar el mensaje de SweetAlert solo si hay uno
            <?php if ($message && !isset($_POST['ajax'])): ?>
                Swal.fire({
                    icon: '<?php echo $messageType; ?>',
                    title: '<?php echo ($messageType === 'success') ? 'Éxito' : 'Error'; ?>',
                    text: '<?php echo $message; ?>',
                    timer: 3000, // Tiempo en milisegundos antes de ocultarse
                    showConfirmButton: false
                });
            <?php endif; ?>
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Lista de Usuarios</h1>
        <form id="createForm" method="POST" action="index.php">
            <input type="hidden" name="action" value="create">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre:" required>
            <input type="text" name="numero" id="numero" placeholder="Numero de departamento:" required>
            <input type="email" name="email" id="email" placeholder="Email:" required>
            <input type="text" name="telefono" id="telefono" placeholder="Telefono de contacto:" required>
            <button type="submit">Agregar Usuario</button>
        </form>

        <ul id="userList">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo htmlspecialchars($row["nombre"]). " - " . htmlspecialchars($row["numero"]) ." - " . htmlspecialchars($row["email"]). " - " . htmlspecialchars($row["telefono"]);
                    echo ' <button class="editBtn" data-id="' . $row["id"] . '" data-nombre="' . htmlspecialchars($row["nombre"])  . '" data-numero="' . htmlspecialchars($row["numero"]). '" data-email="' . htmlspecialchars($row["email"]) .'" data-telefono="' . htmlspecialchars($row["telefono"]) . '">Editar</button>';
                    echo ' <form class="deleteForm" method="POST" action="index.php" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="' . $row["id"] . '">
                        <button type="submit" class="deleteBtn">Eliminar</button>
                    </form>';
                    echo "</li>";
                }
            } else {
                echo "<p>No hay usuarios registrados.</p>";
            }
            ?>
        </ul>

        <div id="editFormContainer" style="display:none;">
            <h2>Editar Usuario</h2>
            <form id="editForm" method="POST" action="index.php">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="nombre" id="editName" placeholder="Nombre" required>
                <input type="text" name="numero" id="editNum" placeholder="Numero" required>
                <input type="email" name="email" id="editEmail" placeholder="Email" required>
                <input type="text" name="telefono" id="editTel" placeholder="Telefono" required>
                <button type="submit">Actualizar Usuario</button>
                <button type="button" id="cancelEditBtn">Cancelar</button>
            </form>
        </div>
    </div>
</body>
</html>
