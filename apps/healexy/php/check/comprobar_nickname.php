<?php
    @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if(mysqli_connect_error()){
            echo"error al conectar";
        }else{
            $nickname =$_REQUEST['nickname'];
            //echo "$nickname";
            $consulta="SELECT nickname FROM loggeos WHERE nickname = \"".strtolower($nickname)."\"";
            $result = mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);

            if($cambios>=1){
                echo '<div class="alert alert-danger">Apodo en uso :( </div>';
            }else{
                echo '<div class="alert alert-success">Apodo disponible</div>';
            }
        }
?>
