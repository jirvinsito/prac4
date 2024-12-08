<?php
session_start();

if(!isset($_SESSION["username"])){
    header("location:index.php");
} 
require_once "config.php"; // Incluir la configuración de la base de datos

?>


<!DOCTYPE html>
<html>
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


    <head>
        <title>Introduction to PHP</title>
    </head>

    <body>
        <div class="container align-middle">
            <span class="row"> Welcome to Home page </span>

            <div class="row">
            <?php
            $query="SELECT * FROM users";
            $result=mysqli_query($connection, $query);

            if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_assoc($result)){
                    echo
                    '
                        <div class="col-md-4 my-3">
                            <div class="card" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">'.$row["username"].'</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">ID: '.$row["id"].'</h6>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                
                ';
                }
            }
            ?>

            <a href="logout.php">Logout</a>
        </div>
    </body>


</html>
