<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Platos - Temática Japonesa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #5c0029; /* Color vino tinto */
            margin: 0;
            padding: 0;
            color: #fff; /* Texto en color blanco para contraste */
        }
        .header {
            background-color: rgba(0, 0, 0, 0.5); /* Fondo negro semi-transparente */
            padding: 20px 0;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            font-size: 3rem;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        .filter {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter select {
            padding: 10px;
            font-size: 1rem;
            background-color: #f5f5f5;
            border: none;
            border-radius: 5px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        li {
            background-color: rgba(255, 255, 255, 0.7); /* Fondo blanco semi-transparente */
            border-radius: 10px;
            margin: 10px;
            padding: 20px;
            width: calc(33.33% - 20px);
            text-align: center;
            transition: transform 0.2s ease-in-out;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1 0 auto; /* Ajuste para flexibilidad */
        }
        li:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .footer {
            background-color: rgba(0, 0, 0, 0.5); /* Fondo negro semi-transparente */
            padding: 20px 0;
            text-align: center;
            margin-top: 30px;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }
        .footer a {
            color: #fff;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer a:hover {
            text-decoration: underline;
        }

        @media screen and (max-width: 768px) {
            li {
                width: calc(50% - 20px);
            }
        }

        @media screen and (max-width: 480px) {
            li {
                width: calc(100% - 20px);
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍣Menú de Platos🏯</h1>
        <!-- Filtro por categoría -->
        <div class="filter">
            <label for="categoria">Filtrar por Categoría:</label>
            <select name="categoria" id="categoria">
                <option value="all">Todos</option>
                <option value="bebida">Bebida</option>
                <option value="comida">Comida</option>
                <option value="snack">Snack</option>
            </select>
        </div>
    </div>

    <div class="container">
        <ul id="menu">
            <?php
            include 'recursos/funcionalidad/php/conexion.php';
            // Consulta para obtener todos los productos activos
            $sql = "SELECT * FROM productos WHERE activo = 1 ORDER BY categoria, nombre";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li data-categoria='" . $row["categoria"] . "'><strong>" . $row["nombre"] . "</strong><br>" . $row["categoria"] . "</li>";
                }
            } else {
                echo "<li>No hay productos disponibles.</li>";
            }
            $conn->close();
            ?>
        </ul>
    </div>

    <div class="footer">
        <a href="login.html">Iniciar Sesión</a>
        <a href="chat_clientes.php">Chat clientes</a>
    </div>

    <script>
        // Filtrar productos por categoría
        document.getElementById('categoria').addEventListener('change', function() {
            var categoria = this.value;
            var lis = document.querySelectorAll('#menu li');

            lis.forEach(function(li) {
                if (categoria === 'all' || li.getAttribute('data-categoria') === categoria) {
                    li.style.display = 'block';
                } else {
                    li.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
