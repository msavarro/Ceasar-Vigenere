<!DOCTYPE HTML>  
<html>
<head>
</head>
<body>  

<?php
// define variables and set to empty values
$abc = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
$mensaje = $cifrar = $cifrado = $descifrado = "";
$clave = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $clave = test_input($_POST["clave"]);
  $mensaje = test_input($_POST["mensaje"]);
  $cifrar = test_input($_POST["cifrar"]);
}

$mensaje = strtolower($mensaje);
$cadena = str_split($mensaje);

if ($cifrar == "on"){
  $descifrado = $mensaje;
  $aux = cifrar($clave,$cadena);
  $cifrado = implode($aux);
} else{
  $cifrado = $mensaje;
  $aux = descifrar($clave,$cadena);
  $descifrado = implode($aux);
}

function cifrar($clave,$cadena){
  global $abc;
  $cifrado = array();
  foreach($cadena as $caracter){
    $ascii = ord($caracter); 
    if($ascii > 96 && $ascii < 123){
      $char_cifrado = $abc[(($ascii - 97) + $clave) % 26];
    }else{
      $char_cifrado = $caracter;
    }
    array_push($cifrado, $char_cifrado);
  }
  return $cifrado;
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

<h2>Codificador Ceasar</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Clave: <select id="clave" name="clave" size="1">
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option> 
    <option value="25">25</option>
</select>
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
echo "<h2>Ceasar:</h2>";
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