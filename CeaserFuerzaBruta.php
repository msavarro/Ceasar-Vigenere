<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php
// define variables and set to empty values
$abc = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
$mensaje = $descifrado = "";
$claveBuena = 0;
$exitosMaximos = -1;
$exitosActuales = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mensaje = test_input($_POST["mensaje"]);
}

$mensaje = strtolower($mensaje);
$cadena = str_split($mensaje);

//Abrir el archivo
$file = "palabras.txt";
if (!$fp = fopen($file, "r")){
  echo "No se ha podido abrir el archivo";
}

//Leer el archivo
$contents = fread($fp,filesize("palabras.txt"));
//echo($contents);
//echo("<br>");
$palabras = explode("\n",$contents);
fclose($fp);



for($clave = 0; $clave < sizeof($abc); $clave++){
  $aux = descifrar($clave,$cadena);
  $aux2 = explode(' ',implode($aux));
  $exitosActuales = comparar($aux2, $palabras);
  if($exitosMaximos < $exitosActuales){
    $exitosMaximos = $exitosActuales;
    $descifrado = implode($aux);
    $claveBuena = $clave;
  }
}

function comparar($msj, $palabras){
  $hits=0;
  foreach($palabras as $p){
    //echo($p);
    //echo "<br>";
    foreach($msj as $s){
      if(strcmp($s,$p) == 0){
        $hits++;
      }
    }
  }
  return $hits;
}

function descifrar($clave,$cadena){
  global $abc;
  $descifrado = array();
  foreach($cadena as $caracter){
    $ascii = ord($caracter); 
    if($ascii > 96 && $ascii < 123){
      $offset = (($ascii - 97) - $clave) % 26;
      if($offset < 0){
        $offset = $offset + 26;
      }
      $char_descifrado = $abc[$offset];
    }else{
      $char_descifrado = $caracter;
    }
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

<h2>Decodificador Ceasar fuerza bruta</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <br><br>  
  Mensaje: <textarea name="mensaje" rows="5" cols="40"></textarea>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<h2>Ceasar:</h2>";
echo "Clave Utilizada: ";
echo $claveBuena;
echo "<br>";
echo "Hits: ";
echo $exitosMaximos;
echo "<br>";
echo "Mensaje original estimado: ";
echo $descifrado;
echo "<br>";
?>
</body>
</html>