<?php 

$host = "localhost:3307"; // Cambia si tu servidor es diferente
$dbname = "medicalweb"; // Reemplaza con el nombre real de tu base de datos
$username = "root"; // Usuario de tu base de datos
$password = ""; // Contraseña de la base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "✅ Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "❌ Tiene un Error en la conexión: " . $e->getMessage();
}


?>