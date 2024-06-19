<?php
session_start();
include 'recursos/funcionalidad/php/conexion.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

function getAllProducts($conn)
{
    $sql = "SELECT id, nombre FROM productos";
    $result = $conn->query($sql);
    $productos = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
    }
    return $productos;
}

function getProductById($conn, $id)
{
    $sql = "SELECT nombre, categoria FROM productos WHERE id = $id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['crear'])) {
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];

        $sql = "INSERT INTO productos (nombre, categoria) VALUES ('$nombre', '$categoria')";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Producto creado correctamente.");</script>';
        } else {
            echo '<script>alert("Error al crear el producto: ' . $conn->error . '");</script>';
        }
    } elseif (isset($_POST['actualizar'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];

        $sql = "UPDATE productos SET nombre='$nombre', categoria='$categoria' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Producto actualizado correctamente.");</script>';
        } else {
            echo '<script>alert("Error al actualizar el producto: ' . $conn->error . '");</script>';
        }
    } elseif (isset($_POST['eliminar'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM productos WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Producto eliminado correctamente.");</script>';
        } else {
            echo '<script>alert("Error al eliminar el producto: ' . $conn->error . '");</script>';
        }
    } elseif (isset($_POST['desactivar'])) {
        $id = $_POST['id'];

        $sql = "UPDATE productos SET activo=0 WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Producto desactivado correctamente.");</script>';
        } else {
            echo '<script>alert("Error al desactivar el producto: ' . $conn->error . '");</script>';
        }
    } elseif (isset($_POST['activar'])) {
        $id = $_POST['id'];

        $sql = "UPDATE productos SET activo=1 WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Producto activado correctamente.");</script>';
        } else {
            echo '<script>alert("Error al activar el producto: ' . $conn->error . '");</script>';
        }
    }
}

$productos = getAllProducts($conn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Temática Japonesa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar {
            background-color: #c62828;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .main-content {
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #c62828;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form input[type="text"],
        form input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #c62828;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form input[type="submit"]:hover {
            background-color: #a02626;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <h2>Panel de Administración</h2>
            <ul>
                <li><a href="#crear">Crear Producto</a></li>
                <li><a href="#actualizar">Actualizar Producto</a></li>
                <li><a href="#eliminar">Eliminar Producto</a></li>
                <li><a href="#desactivar">Desactivar Producto</a></li>
                <li><a href="#activar">Actuvar Producto</a></li>
                <li><a href="chat_admin.php">CHAT</a></li>
                <li><a href="recursos/funcionalidad/php/logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Panel de Administración - Temática Japonesa</h1>

            <!-- Formulario para crear un producto -->
            <form id="crear" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Crear Producto</h2>
                Nombre: <input type="text" name="nombre" required><br><br>
                Categoría:
                <select name="categoria">
                    <option value="bebida">Bebida</option>
                    <option value="comida">Comida</option>
                    <option value="snack">Snack</option>
                </select><br><br>
                <input type="submit" name="crear" value="Crear Producto">
            </form>

            <!-- Formulario para actualizar un producto -->
            <form id="actualizar" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Actualizar Producto</h2>
                <select name="id">
                    <?php foreach ($productos as $producto) : ?>
                        <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                Nuevo Nombre: <input type="text" name="nombre" required><br><br>
                Nueva Categoría:
                <select name="categoria">
                    <option value="bebida">Bebida</option>
                    <option value="comida">Comida</option>
                    <option value="snack">Snack</option>
                </select><br><br>
                <input type="submit" name="actualizar" value="Actualizar Producto">
            </form>

            <!-- Formulario para eliminar un producto -->
            <form id="eliminar" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Eliminar Producto</h2>
                <select name="id">
                    <?php foreach ($productos as $producto) : ?>
                        <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <input type="submit" name="eliminar" value="Eliminar Producto">
            </form>

            <!-- Formulario para desactivar un producto -->
            <form id="desactivar" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Desactivar Producto</h2>
                <select name="id">
                    <?php foreach ($productos as $producto) : ?>
                        <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>

                <input type="submit" name="desactivar" value="Desactivar Producto">
            </form>
            <form id="activar" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h2>Activar Producto</h2>
                <select name="id">
                    <?php foreach ($productos as $producto) : ?>
                        <option value="<?php echo $producto['id']; ?>"><?php echo $producto['nombre']; ?></option>
                    <?php endforeach; ?>
                </select><br><br>
                <input type="submit" name="activar" value="Activar Producto">
            </form>
        </div>
    </div>
</body>

</html>

<?php
$conn->close();
?>