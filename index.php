<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Videojuegos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require 'database_conection.php' ?>
</head>

<body>
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
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sql = $conexion->prepare("SELECT * FROM videojuegos");
        $sql->execute();
        $resultado = $sql->get_result();
        $conexion->close();
    }
    ?>
    <div class="container">
        <h1>Videojuegos</h1>
        <form action="" method="POST">
            <div class="row mb-3">
                <div class="col-4">
                    <input class="form-control" id="palabras" name="palabras" type="text">
                </div>
                <div class="col-2">
                    <input class="btn btn-primary" type="submit" value="Buscar">
                </div>
                <div class="col-2">
                    <a class="btn btn-primary" href='create_videogames.php'>Crear nuevo videojuego</a>
                </div>
            </div>

            <div class="row mb-3">
                <label class="form-label">Filtrar por:</label>
                <div class="col-2">
                    <select class="form-select" name="columna">
                        <option selected value="titulo">Titulo</option>
                        <option value="distribuidora">Distribuidora</option>
                        <option value="precio">Precio</option>
                    </select>
                </div>
                <div class="col-2">
                    <select class="form-select" name="orden">
                        <option selected value="asc">Ascendente</option>
                        <option value="desc">Descendente</option>
                    </select>
                </div>
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Distribuidora</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila['titulo'] . "</td>";
                    echo "<td>" . $fila['distribuidora'] . "</td>";
                    echo "<td>" . $fila['precio'] . "</td>";
                    ?>
                    <td>
                        <form action="view_videogame.php" method="get">
                            <input type="hidden" name="titulo" value="<?php echo $fila["titulo"] ?>">
                            <input class="btn btn-secondary" type="submit" value="Ver">
                        </form>
                    </td>
                    <td>
                        <form action="delete_videogames.php" method="get">
                            <input type="hidden" name="titulo" value="<?php echo $fila["titulo"] ?>">
                            <input class="btn btn-danger" type="submit" value="Borrar">
                        </form>
                    </td>
                    <?php
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>