<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="http://localhost/Worksync/assets/css/styleRegistro.css">
    <link rel="shortcut icon" href="http://localhost/Worksync/assets/img/LogoWorksync.png">
    <title>Inicio de Sesion</title>
</head>

<body>
    <form action="index.php" method="POST">
        <div class="container">
            <h1>Ingreso</h1>
            <?php if (isset($error)) echo "<p style='color:black;'>$error</p>"; ?>
        </div>
        <hr>
        <i class="fa-solid fa-user"></i>
        <label>Documento</label>
        <input type="text" id="documento" name="documento" placeholder="Documento" required>
      
        <i class="fa-solid fa-unlock"></i>
        <label>Contraseña</label>
        <input type="password" id="clave" name="clave" placeholder="Contraseña" required>
        <hr>
        <button type="submit" id="loginButton">Entrar</button>
    </form>
</body>

</html>
