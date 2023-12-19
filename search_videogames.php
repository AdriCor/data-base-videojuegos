<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda de videojuegos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'index.php' ?>
    <?php require 'database_conection.php' ?>
</head>

<body>
    <div class="container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $palabras = '%' . $_POST["palabras"] . '%';
            $columna = $_POST["columna"];
            $orden = $_POST["orden"];
            $stmt = $conexion->prepare("SELECT * FROM videojuegos WHERE titulo LIKE CONCAT ('%',?,'%')
            ORDER BY $columna $orden");
            $stmt->bind_param("s", $palabras);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $conexion->close();

            if ($resultado->num_rows === 0) {
                ?>
                <div class="alert alert-danger" role="alert">No se encuentra en la lista</div>
                <?php
            } else {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "Titulo: " . $fila['titulo'] . "<br>";
                    echo "Distribuidora: " . $fila['distribuidora'] . "<br>";
                    echo "Precio: " . $fila['precio'] . " €" . "<br>";
                }
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>