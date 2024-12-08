<?php

require_once "config.php";
session_start();

if(isset($_SESSION["username"])){
  header("location:home.php");
  exit();
} 

if(isset($_POST["login"])) 
{
  $username = mysqli_real_escape_string($connection, $_POST["username"]);
  $password = mysqli_real_escape_string($connection, $_POST["password"]);
  $query = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($connection, $query);

  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_array($result);
    if(password_verify($password, $row["password"])){
      $_SESSION["username"] = $username;
      header("location:home.php");
      exit();
    } else{
      echo '<div class="alert alert-danger mt-3">Detalles de usuario incorrectos.</div>';
    }
  } else{
    echo '<div class="alert alert-danger mt-3">Error en el inicio de sesión!</div>';
  }
}

if(isset($_POST["register"])) {
  if(empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["repeat_password"])){
    echo '<div class="alert alert-warning mt-3">Todos los campos son obligatorios.</div>';
  } elseif($_POST["password"] !== $_POST["repeat_password"]) {
    echo '<div class="alert alert-warning mt-3">Las contraseñas no coinciden.</div>';
  }
  else{
    $username = mysqli_real_escape_string($connection, $_POST["username"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users(username, password) VALUES('$username', '$password')";

    if(mysqli_query($connection, $query)){
      echo '<div class="alert alert-success mt-3">Registro completado exitosamente.</div>';
      //header("location:index.php");
      exit();
    } else{
      echo '<div class="alert alert-danger mt-3">Registro fallido: ' . mysqli_error($connection) . '</div>';
    }
  }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login y Registro</title>
    <!-- Meta Tag para Responsividad -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS (MDB UI Kit) -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
      rel="stylesheet"
    />
    <!-- Font Awesome (opcional, para iconos) -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Hoja de Estilos Personalizada -->
    <link href="styles.css" rel="stylesheet">
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">
      <?php
      if(isset($_GET["action"]) && $_GET["action"] == "register")
      {
      ?>
      
      <form method="post">
        <h3 class="text-center mb-4">Registrar</h3>
        <!-- Username Input -->
        <div class="form-outline mb-4">
          <input type="text" id="username" name="username" class="form-control" required />
          <label class="form-label" for="username">Nombre de Usuario</label>
        </div>

        <!-- Password Input -->
        <div class="form-outline mb-4">
          <input type="password" id="password" name="password" class="form-control" required />
          <label class="form-label" for="password">Contraseña</label>
        </div>
        <div class="form-outline mb-4">
          <input type="password" id="repeat_password" name="repeat_password" class="form-control" required />
          <label class="form-label" for="repeat_password">Repetir Contraseña</label>
        </div>
        
        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-block mb-4" name="register">Registrar</button>

        <!-- Register Buttons -->
        <div class="text-center">
          <p>¿Ya eres miembro? <a href="index.php">Iniciar Sesión</a></p>
        </div>
      </form>
      <?php
      }
      else
      {
      ?>
      
      <form method="post">
        <h3 class="text-center mb-4">Iniciar Sesión</h3>
        <!-- Username Input -->
        <div class="form-outline mb-4">
          <input type="text" id="username" name="username" class="form-control" required />
          <label class="form-label" for="username">Nombre de Usuario</label>
        </div>

        <!-- Password Input -->
        <div class="form-outline mb-4">
          <input type="password" id="password" name="password" class="form-control" required />
          <label class="form-label" for="password">Contraseña</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary btn-block mb-4" name="login">Iniciar Sesión</button>

        <!-- Register Buttons -->
        <div class="text-center">
          <p>¿No eres miembro? <a href="index.php?action=register">Registrar</a></p>
        </div>
      </form>
      <?php
      }
      ?>
    </div>
  </div>

  <!-- Bootstrap JS (MDB UI Kit) -->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"
    defer
  ></script>
</body>
</html>


