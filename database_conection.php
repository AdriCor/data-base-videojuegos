<?php
    $_servidor = 'localhost'; //Almacenamos la IP
    $_usuario = 'root';
    $_contrasena = 'acc1234';
    $_base_de_datos = 'db_videojuegos';

    $conexion = new mysqli($_servidor,$_usuario,$_contrasena,$_base_de_datos)
        or die ("Error de conexión");
?>