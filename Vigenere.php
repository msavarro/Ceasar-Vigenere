<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php
//Abecedario de letras, para obtener su valor segun su indice
$abc = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
$clave = $mensaje = $cifrar = $cifrado = $descifrado = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $clave = test_input($_POST["clave"]);
  $mensaje = test_input($_POST["mensaje"]);
  $cifrar = test_input($_POST["cifrar"]);
}

$mensaje = strtolower($mensaje);
$cadena = str_split($mensaje);
$clave = strtolower($clave);
$clave = str_replace(' ','',$clave);
$clave_cadena = str_split($clave);



if ($cifrar == "on"){
  $descifrado = $mensaje;
  $aux = cifrar($clave_cadena,$cadena);
  $cifrado = implode($aux);
} else{
  $cifrado = $mensaje;
  $aux = descifrar($clave_cadena,$cadena);
  $descifrado = implode($aux);
}

function cifrar($clave,$cadena){
  global $abc;
  $cifrado = array();
  //Variable contador del recorrido de la clave
  $i=0;
  //Tamaño de la clave
  $clave_size = sizeof($clave);
  //Recorrer la cadena del mensaje a cifrar
  foreach($cadena as $caracter){
    //Obtener el valor ascii del caracter i del mensaje
    $ascii = ord($caracter); 
    //Obtener el valor ascii del caracter i de la clave
    $ascii_c = ord($clave[$i]);
    //Si el caracter es una letra, codificarla, sino pues no
    if($ascii > 96 && $ascii < 123){
      //Obtener la letra cifrada
      $char_cifrado = $abc[(($ascii - 97) + ($ascii_c-97)) % 26];
      //Como se utilizo un caracter de la clave para cifrar, se aumenta el contador
      $i++;
      //Si la clace ya fue utilizada por completo, se reinicia el contador
      if($clave_size == $i){
        $i = $i - $clave_size;
      }
    }else{
      //Si el caracter no era una letra, no se codifica
      $char_cifrado = $caracter;
    }
    //Agregar el caracter cifrado al resultado
    array_push($cifrado, $char_cifrado);
  }
  return $cifrado;
}

function descifrar($clave,$cadena){
  global $abc;
  $descifrado = array();
  //Variable contador del recorrido de la clave
  $i=0;
  //Tamaño de la clave
  $clave_size = sizeof($clave);
  foreach($cadena as $caracter){
    //Obtener el valor ascii del caracter i del mensaje
    $ascii = ord($caracter); 
    //Obtener el valor ascii del caracter i de la clave
    $ascii_c = ord($clave[$i]);
    //Si el caracter es una letra, codificarla, sino pues no
    if($ascii > 96 && $ascii < 123){
      //Obtener el offset de la letra a descifrar
      $offset = (($ascii - 97) - ($ascii_c-97)) % 26;
      //Si el offset es negativo, hay que repararlo sumandole la cantidad de letras en el abecedario
      if($offset < 0){
        $offset = $offset + 26;
      }
      //Obtener la letra descifrada segun el offset
      $char_descifrado = $abc[$offset];
      //Como se utilizo un caracter de la clave para cifrar, se aumenta el contador
      $i++;
      //Si la clace ya fue utilizada por completo, se reinicia el contador
      if($clave_size == $i){
        $i = $i - $clave_size;
      }
    }else{
      //Si no era una letra, no se descifra
      $char_descifrado = $caracter;
    }
    //Agregar al resultado el nuevo caracter
    array_push($descifrado, $char_descifrado);
  }
  return $descifrado;
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Codificador Vignère</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
<br><br>  
  Clave: <textarea name="clave" rows="5" cols="40"></textarea>
  <br><br>
  <br><br>  
  Mensaje: <textarea name="mensaje" rows="5" cols="40"></textarea>
  <br><br>
  Objetivo:
  <input type="radio" name="cifrar" value="on">Cifrar
  <input type="radio" name="cifrar" value="off">Descifrar
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
//Clave: <input type="text" name="clave">
//<br><br>
echo "<h2>Vigenère:</h2>";
echo "Clave Utilizada: ";
echo $clave;
echo "<br>";
echo "Mensaje original: ";
echo $descifrado;
echo "<br>";
echo "El mensaje encriptado es: ";
echo $cifrado;
echo "<br>";
?>
</body>
</html>