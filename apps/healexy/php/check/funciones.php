<?php

    //Esta función sirve para introducir los datos del registro
    function introducir($datos){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if(mysqli_connect_error()){
            echo"error al conectar";
        }else{
            $consulta="INSERT INTO loggeos (nickname, Usuario, Contrasena, TipoUser, Correo, Altura, Peso, Metabolismo) VALUES ('$datos[nickname]','$datos[Usuario]','$datos[Contrasena]','$datos[TipoUser]','$datos[Correo]','$datos[Altura]','$datos[Peso]','$datos[Metabolismo]')";
            $result = mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);

            if($cambios>=1){
                return true;
            }else{
                return false;
            }
        }
      mysqli_close($con);
    }


    //Esta función sirve para comprobar si el usuario y la contraseña son correctos en el login
    function comprobarUsuario($nick, $passwd){
        $usuarios=array();
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT nickname as nick, Contrasena as pwd FROM loggeos WHERE nickname=\"$nick\"";
            $result=mysqli_query($con,$consulta);
            if ($result==true) {
                while ($usuario=mysqli_fetch_assoc($result)) {
                    $usuarios[]=$usuario;
                }
                for ($i=0; $i < count($usuarios); $i++) {
                    if ($usuarios[$i]['nick']==$nick) {
                        if ($usuarios[$i]['pwd']==$passwd) {
                            return 2;
                        }else{
                            return 1;
                        }
                    }else{
                        return 0;
                    }
                }
            }
        }else{
            return 3;
        }
      mysqli_close($con);
    }


    //Esta función sirve para comprobar el nickname
    function comprobarNickOnly($nick){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT nickname FROM loggeos WHERE nickname=\"$nick\"";
            $result=mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);
            if($cambios>=1){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
      mysqli_close($con);
    }


    //Esta función sirve para comprobar el correo
    function comprobarCorreoOnly($correoo){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT Correo FROM loggeos WHERE Correo=\"$correoo\"";
            $result=mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);
            if($cambios>=1){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
      mysqli_close($con);
    }


    //Esta función sirve para obtener el tipo de usuario que e el usuario logeado
    function obtenerTipo($nick, $passwd){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT TipoUser FROM loggeos WHERE nickname=\"$nick\" AND Contrasena=\"$passwd\"";
            $result=mysqli_query($con,$consulta);
            if ($result==true) {
                $tipo=mysqli_fetch_row($result);
                foreach ($tipo as $key => $value) {
                    $tipo=$value;
                }
                return $tipo;
            }else{
                return 0;
            }
        }
      mysqli_close($con);
    }


    //Esta función sirve para obtener el id del ususario
    function obtenerID($Uzer){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT IDuser FROM loggeos WHERE nickname=\"$Uzer[nombre]\" AND Contrasena=\"$Uzer[contrasena]\" AND TipoUser=\"$Uzer[tipo]\"";
            $result=mysqli_query($con,$consulta);
            if ($result==true) {
                $posID=mysqli_fetch_row($result);
                foreach ($posID as $key => $IdI) {
                }
                return $IdI;
            }else{
                return 0;
            }
        }
      mysqli_close($con);
    }


    //Esta función sirve para obtener el nickname del ususario
    function obtenerNICK($Uzer){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT nickname as nick FROM loggeos WHERE nickname=\"$Uzer[nombre]\" AND Contrasena=\"$Uzer[contrasena]\"";
            $result=mysqli_query($con,$consulta);
            if ($result==true) {
                $Nickii=mysqli_fetch_row($result);
                foreach ($Nickii as $key => $Niki) {
                }
                return $Niki;
            }else{
                return 0;
            }
        }
      mysqli_close($con);
    }


    //Esta función sirve para mostrar los alimentos que el usuario va introduciendo
    function Mostrar_Alimentos($arrayali){ //$arrayali=$_SESSION['comida'];
        //Creo el array general para englobar los datos recogidos en un único array
        $general = array();
        $infonutriS=array();
        //El for lo uso para representar los distintos alimentos introducidos por el usuario
        for ($i=0; $i < count($arrayali); $i++) {
            $nombali=$arrayali[$i]['nombre'];
            $cantali=$arrayali[$i]['gramos'];
            //Mis alimentos en la base de datos comparten el mismo peso, es decir, 100 gramos de platano (puede ser medio plátano o uno y medio depende del tamanno) [#el_tamanno_importa] por lo que si todos los alimentos pesaran 100 gramos y el usuario consume solo 43 gramos; lo que hay que hacer es dividir toda la información nutricional ente 100 y multiplicarla por los gramos consumidos por el usuario
            $peso=$cantali*0.01;
            @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
            if (!mysqli_connect_error()) {
                //Multiplico aqui directamente el peso de los alimentos del usuario para mayor comodidad y accesibilidad a las cifras reales de mi base de datos
                $consulta="SELECT Calorias *$peso as calorias, Gramos *$peso as gramos, CarboHidratos *$peso as carbohidratos, Grasas *$peso as grasas, Proteinas *$peso as proteinas FROM alimentos WHERE Nombre = \"$nombali\"";
                $result=mysqli_query($con,$consulta);
                if ($result==true) {
                    while ($infonutri=mysqli_fetch_assoc($result)) {
                        $infonutriS[]=$infonutri;
                    }
                //Aqui meto todos los datos en el array general. Creo este array debido a que primero pense como iba a reprensentar los datos, cree un array de como me iba a quedar y de que forma yo sacaria los datos del array para poder mostrarlos al usuario.
                $general[$i]=array(
                    'nombre' => $nombali,
                    'gramos' => $infonutriS[$i]['gramos'],
                    'datos' => $infonutriS[$i]
                );

                }else{
                    return 0;
                }
            }
            //mysqli_close($con); NI PUTA IDEA
        }
        return $general;
        mysqli_close($con);
    }


    //Esta función sirve para comprobar la fecha actual con la de la tabla comidadeldia
    function comprobarFechaOnly($aidi){
        $fecha = date('yy-m-d');
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT Fecha as fecha FROM comidadeldia WHERE fecha=\"$fecha\" AND IdUserComida =\"$aidi\"";
            $result=mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);
            if($cambios>=1){
                return false;
            }else{
                return true;
            }
        }else{
            return 0;
        }
      mysqli_close($con);
    }


    //Esta función sirve para comprobar la fecha actual con la de la tabla dia
    function comprobarFechadiahoraOnly(){
        $fecha = date('yy-m-d');
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT Fechadiahora as fecha FROM diaaadia WHERE fecha =\"$fecha\"";
            $result=mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);
            if($cambios>=1){
                return false;
            }else{
                return true;
            }
        }else{
            return 0;
        }
      mysqli_close($con);
    }


    //Esta función sirve para comprobar la fecha recibida en la BD
    function comprobarFechadelUser($fecha, $aidi){
      @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
      if (!mysqli_connect_error()) {
        $consulta="SELECT Fecha as fecha FROM comidadeldia WHERE fecha=\"$fecha\" AND IdUserComida =\"$aidi\"";
        $result=mysqli_query($con,$consulta);
        $cambios = mysqli_affected_rows($con);
        if($cambios>=1){
          return true;
        }else{
          return false;
        }
      }else{
        return 0;
      }
      mysqli_close($con);
    }


    //Esta función sirve para subir el resumen del dia de las comidas del ususario
    function subirDatosBD($aidi, $info){
        $fecha = date('yy-m-d');
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if(mysqli_connect_error()){
            echo"error al conectar";
        }else{
            $consulta="INSERT INTO comidadeldia (IdUserComida, Fecha, TGramos, TCalorias, TCarbohidratos, TGrasas, TProteinas) VALUES ('$aidi','$fecha','$info[TGramos]','$info[TCalorias]','$info[TCarbohidratos]','$info[TGrasas]','$info[TProteinas]')";
            $result = mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);

            if($cambios>=1){
                return true;
            }else{
                return false;
            }
        }
      mysqli_close($con);
    }


    //Esta función sirve para introducir los datos del registro de alimentos dependiendo del dia
    function subirDatosBDAliMentos($aidi, $datainfo){
        $fecha = date('yy-m-d');
        for ($i=0; $i < count($datainfo) ; $i++) {
            $nombreAli=$datainfo[$i]['nombre'];
            $cantidadAli=$datainfo[$i]['gramos'];

            @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
            if(mysqli_connect_error()){
                echo"error al conectar";
            }else{
                $consulta="INSERT INTO alimentosdeldia (IdUserAlimentosS, fechaAliment, Nalimento, Calimento) VALUES ('$aidi','$fecha','$nombreAli','$cantidadAli')";
                $result = mysqli_query($con,$consulta);
                $cambios = mysqli_affected_rows($con);
            }
            mysqli_close($con);
        }
    }


    //Esta función sirve para subir el dato del peso del usuario en el dia
    function subirPeso($aidi, $cantpeso){
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        $fecha = date('yy-m-d');
        if(mysqli_connect_error()){
            echo"error al conectar";
        }else{
            if (comprobarFechadiahoraOnly() == true) {
                $consultaELIMINAR="DELETE FROM diaaadia WHERE Fechadiahora =\"$fecha\"";
                mysqli_query($con,$consultaELIMINAR);
            }

            $consulta="INSERT INTO diaaadia (IdUserDIA, Peso, Fechadiahora) VALUES ('$aidi', '$cantpeso', '$fecha')";
            $result = mysqli_query($con,$consulta);
            $cambios = mysqli_affected_rows($con);
            if($cambios>=1){
                return true;
            }else{
                return false;
            }
        }
      mysqli_close($con);
    }


    //Esta función sirve para poder completar los datos del diagrama de peso
    function DiagramadePeso($aidi){
        $arrayPesoS=array();
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT Peso as peso, Fechadiahora as fecha FROM diaaadia WHERE IdUserDIA =\"$aidi\"";
            $result=mysqli_query($con,$consulta);
            if ($result==true) {
                while ($arrayPeso=mysqli_fetch_assoc($result)) {
                    $arrayPesoS[]=$arrayPeso;
                }
                return $arrayPesoS;
            }
        }else{
            return 0;
        }
      mysqli_close($con);
    }


  //Esta función se encarga de mostrar los datos de la comida del usuario SEGÚN UNA UNUICA FECHA
  function TotalAaAlimentos($fecha, $uzer){
    $IduserCom=obtenerID($uzer);
    $tablas =array();
    @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
    if (!mysqli_connect_error()) {
      $consulta="SELECT TGramos, TCalorias, TCarbohidratos, TGrasas, TProteinas FROM comidadeldia WHERE Fecha=\"$fecha\" AND IdUserComida=\"$IduserCom\"";
      $result=mysqli_query($con,$consulta);
      if (mysqli_num_rows($result) == 0) {
        $errorDatos= "No hay registro de datos almacenados ese día";
        return $errorDatos;
      }else{
          if ($result==true) {
            while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
            }
            return $tablas;
          }else{
            return 1;
          }
      }
    }else{
      return 0;
    }
    mysqli_close($con);
  }


  //Esta función se encarga de mostrar los alimentos del usuario SEGÚN UNA UNUICA FECHA
  function AaAlimentos($fecha, $uzer){
    $IduserCom=obtenerID($uzer);
    $tablas =array();
    @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
    if (!mysqli_connect_error()) {
      $consulta="SELECT Nalimento as Nombre, Calimento as Calorias FROM alimentosdeldia WHERE fechaAliment=\"$fecha\" AND IdUserAlimentosS=\"$IduserCom\"";
      $result=mysqli_query($con,$consulta);
      if (mysqli_num_rows($result) == 0) {
        $errorDatos= "No hay registro de datos almacenados ese día";
        return $errorDatos;
      }else{
          if ($result==true) {
            while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
            }
            return $tablas;
          }else{
            return 1;
          }
      }
    }else{
      return 0;
    }
    mysqli_close($con);
  }


    //Esta función se encarga de mostrar los datos de la comida del usuario SEGÚN UN RANGO DE DÍAS
    function TotalAaAlimentosEnRango($fecha1, $fecha2, $uzer){
        $IduserCom=obtenerID($uzer);
        $tablas =array();
        @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
        if (!mysqli_connect_error()) {
            $consulta="SELECT Fecha, TGramos, TCalorias, TCarbohidratos, TGrasas, TProteinas FROM comidadeldia WHERE Fecha BETWEEN \"$fecha1\" AND \"$fecha2\" AND IdUserComida=\"$IduserCom\"";
            $result=mysqli_query($con,$consulta);
            if (mysqli_num_rows($result) == 0) {
                return 3;
            }else{
                if ($result==true) {
                    while ($tabla=mysqli_fetch_assoc($result)) {
                        $tablas[]=$tabla;
                    }
                    return $tablas;
                }else{
                    return 2;
                }
            }
        }else{
        return 2;
      }
      mysqli_close($con);
    }


  //Esta función sirve para mostrar la tabla alimentos de la BD en una tabla
  function Mostrar_Alimento(){
      $tablas =array();
      @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
      if (!mysqli_connect_error()) {
          $consulta="SELECT * FROM alimentos WHERE 1";
          $result=mysqli_query($con,$consulta);
            if ($result==true) {
              while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
              }
            echo "
            <div style='overflow-x:auto'>
                <hr/>
                <h1 style=' text-align: center;'>Alimentos</h1>
                <table class='table table-dark'>
                  <thead>
                    <tr>";
                        if (isset($tablas)){
                          foreach ($tablas[0] as $productos => $valor){
                            echo "
                              <th scope='col' class='text-center'>"
                              .strtoupper($productos).
                              "</th>";
                          }
            echo "
                    </tr>
                  </thead>
                  <tbody>";
                      foreach ($tablas as $productos){
                        echo "<tr>";
                        foreach ($productos as $key => $value) {
                          echo "<td class='text-center'>$value</td>";
                        }
                        echo"</tr>";
                      }
                    }
            echo "
                  </tbody>
                </table>
                <hr/>
            </div>";
            }else{
              return 0;
            }
      }
  }


  //Esta función sirve para mostrar la tabla comidadeldia de la BD en una tabla
  function Mostrar_Comidadeldia(){
      $tablas =array();
      @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
      if (!mysqli_connect_error()) {
          $consulta="SELECT * FROM comidadeldia WHERE 1";
          $result=mysqli_query($con,$consulta);
            if ($result==true) {
              while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
              }
            echo "
            <div style='overflow-x:auto'>
              <hr/>
              <h1 style=' text-align: center;'>Comida del dia</h1>
                <table class='table table-dark'>
                  <thead>
                    <tr>";
                        if (isset($tablas)){
                          foreach ($tablas[0] as $productos => $valor){
                            echo "
                              <th scope='col' class='text-center'>"
                              .strtoupper($productos).
                              "</th>";
                          }
            echo "
                    </tr>
                  </thead>
                  <tbody>";
                      foreach ($tablas as $productos){
                        echo "<tr>";
                        foreach ($productos as $key => $value) {
                          echo "<td class='text-center'>$value</td>";
                        }
                        echo"</tr>";
                      }
                    }
            echo "
                  </tbody>
                </table>
                <hr/>
            </div>";
            }else{
              return 0;
            }
      }
  }


  //Esta función sirve para mostrar la tabla diaaadia de la BD en una tabla
  function Mostrar_Diaadia(){
      $tablas =array();
      @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
      if (!mysqli_connect_error()) {
          $consulta="SELECT * FROM diaaadia WHERE 1";
          $result=mysqli_query($con,$consulta);
            if ($result==true) {
              while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
              }
            echo "
            <div style='overflow-x:auto'>
              <hr/>
              <h1 style=' text-align: center;'>Peso</h1>
                <table class='table table-dark'>
                  <thead>
                    <tr>";
                        if (isset($tablas)){
                          foreach ($tablas[0] as $productos => $valor){
                            echo "
                              <th scope='col' class='text-center'>"
                              .strtoupper($productos).
                              "</th>";
                          }
            echo "
                    </tr>
                  </thead>
                  <tbody>";
                      foreach ($tablas as $productos){
                        echo "<tr>";
                        foreach ($productos as $key => $value) {
                          echo "<td class='text-center'>$value</td>";
                        }
                        echo"</tr>";
                      }
                    }
            echo "
                  </tbody>
                </table>
                <hr/>
            </div>";
            }else{
              return 0;
            }
      }
  }


  //Esta función sirve para mostrar la tabla loggeos de la BD en una tabla
  function Mostrar_Logs(){
      $tablas =array();
      @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
      if (!mysqli_connect_error()) {
          $consulta="SELECT * FROM loggeos WHERE 1";
          $result=mysqli_query($con,$consulta);
            if ($result==true) {
              while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
              }
            echo "
            <div style='overflow-x:auto'>
              <hr/>
              <h1 style=' text-align: center;'>Usuarios</h1>
                <table class='table table-dark'>
                  <thead>
                    <tr>";
                        if (isset($tablas)){
                          foreach ($tablas[0] as $productos => $valor){
                            echo "
                              <th scope='col' class='text-center'>"
                              .strtoupper($productos).
                              "</th>";
                          }
            echo "
                    </tr>
                  </thead>
                  <tbody>";
                      foreach ($tablas as $productos){
                        echo "<tr>";
                        foreach ($productos as $key => $value) {
                          echo "<td class='text-center'>$value</td>";
                        }
                        echo"</tr>";
                      }
                    }
            echo "
                  </tbody>
                </table>
                <hr/>
            </div>";
            }else{
              return 0;
            }
      }
  }


  //Esta función sirve para mostrar la tabla alimentosdeldia de la BD en una tabla
  function Mostrar_alimentosdeldia(){
      $tablas =array();
      @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
      if (!mysqli_connect_error()) {
          $consulta="SELECT * FROM alimentosdeldia WHERE 1";
          $result=mysqli_query($con,$consulta);
            if ($result==true) {
              while ($tabla=mysqli_fetch_assoc($result)) {
                $tablas[]=$tabla;
              }
            echo "
            <div style='overflow-x:auto'>
              <hr/>
              <h1 style=' text-align: center;'>Alimentos del día</h1>
                <table class='table table-dark'>
                  <thead>
                    <tr>";
                        if (isset($tablas)){
                          foreach ($tablas[0] as $productos => $valor){
                            echo "
                              <th scope='col' class='text-center'>"
                              .strtoupper($productos).
                              "</th>";
                          }
            echo "
                    </tr>
                  </thead>
                  <tbody>";
                      foreach ($tablas as $productos){
                        echo "<tr>";
                        foreach ($productos as $key => $value) {
                          echo "<td class='text-center'>$value</td>";
                        }
                        echo"</tr>";
                      }
                    }
            echo "
                  </tbody>
                </table>
                <hr/>
            </div>";
            }else{
              return 0;
            }
      }
  }

  //Esta función comprueba que le alimento introducido exista en la base de datos
  function alimentocheck($alimento){
    @$con=mysqli_connect(getenv("HEALEXY_DB_HOST"),getenv("HEALEXY_DB_USER"),getenv("HEALEXY_DB_PASSWORD"),getenv("HEALEXY_DB_NAME"));
    if (!mysqli_connect_error()) {
        $consulta="SELECT Nombre FROM alimentos WHERE Nombre =\"$alimento\"";
        $result=mysqli_query($con,$consulta);
        $cambios = mysqli_affected_rows($con);
        if($cambios==1){
            return true;
        }else{
            return false;
        }
    }else{
        return 0;
    }
  mysqli_close($con);
  }


?>
