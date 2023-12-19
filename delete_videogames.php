<?php
    require('database_conection.php');

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $titulo = $_GET["titulo"];

    $sql = $conexion->prepare("DELETE FROM videojuegos WHERE titulo = ?");
    $sql->bind_param("s", $titulo);
    $sql->execute();
    header('location: index.php');
}
?>