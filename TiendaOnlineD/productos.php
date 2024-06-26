<?php
require 'config/config.php';
require 'config/database.php';
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

session_destroy();
print_r($_SESSION);

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seccion productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" 
    crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/estiloProduct.css">
</head>
<body>
<header class="header">
        <img class="bg" src="images/bg.svg" alt="">
        <div class="menu container">
        <img src="images/logo.jpeg" class="logo">
            <input type="checkbox" id="menu">
            <label for="menu"><img src="images/menu.png" class="menu-icono" alt=""></label>
            <nav class="navbar">
                <ul>
                    <li><a href="/index">Inicio</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="/productos.php">Productos</a></li>
                    <li><a href="/registro.php">Registro</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
                <a href="carrito.php" class="btn btn-primary">
                    Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart;?></span>
                </a>
            </nav>
        </div>
       
    </header>
    

    <main>
        <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach($resultado as $row) { ?>
            <div class="col">
                <div class="card shadow-sm">
                    <?php

                    $id= $row['id'];
                    $imagen= "images/productos/$id/pr1.jpeg";

                    ?>
                    <img src="<?php echo $imagen; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nombre']; ?> </h5>
                        <p class="card-text">$<?php echo number_format($row['precio'],2 , '.',','); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                            </div>
                             <button class="btn btn-outline-success" type="button" onclick="addProducto
                             (<?php echo $row ['id']; ?>, '<?php echo hash_hmac('sha1',$row['id'],
                             KEY_TOKEN); ?>')">Agregar</button>
                         </div>
                     </div>
                </div>
             </div>
             <?php } ?>
     </div>
     </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
crossorigin="anonymous"></script>

<script>
    function addProducto(id,token){
        let url= 'clases/carrito.php'
        let fomData =new FormData() 
        formData. append('id',id)
        formData. append('token',token)

        fetch(url, {
            method: 'POST',
            body: formData,
            mode: 'cors'
        }).then(response => response.json())
        .then(data => {
            if(data.ok){
                 let elemento =document.getElementById("num_cart")
                 elemento.innerHTML=data.numero
            }
        })
    }
</script>

</body>
</html>