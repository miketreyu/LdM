<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Conecta a la base de datos  con usuario, contraseña y nombre de la BD
$server = "localhost"; $user = "root"; $password = ""; $DataBaseName = "employees";
$connectionDB = new mysqli($server, $user, $password, $DataBaseName);


// Consulta datos y recepciona una clave para consultar dichos datos con dicha clave
if (isset($_GET["consult"])){
    $sqlEmployees = mysqli_query($connectionDB,"SELECT * FROM employees WHERE id=".$_GET["consult"]);
    if(mysqli_num_rows($sqlEmployees) > 0){
        $employees = mysqli_fetch_all($sqlEmployees,MYSQLI_ASSOC);
        echo json_encode($employees);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//borrar pero se le debe de enviar una clave ( para borrado )
if (isset($_GET["borrar"])){
    $sqlEmployees = mysqli_query($connectionDB,"DELETE FROM employees WHERE id=".$_GET["delete"]);
    if($sqlEmployees){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}
//Inserta un nuevo registro y recepciona en método post los datos de nombre y correo
if(isset($_GET["insert"])){
    $data = json_decode(file_get_contents("php://input"));
    $name=$data->name;
    $email=$data->email;
        if(($email!="")&&($name!="")){
            
    $sqlEmployees = mysqli_query($connectionDB,"INSERT INTO employee (name, email) VALUES('$name','$email') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}
// Actualiza datos pero recepciona datos de nombre, correo y una clave para realizar la actualización
if(isset($_GET["update"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["update"];
    $name=$data->name;
    $email=$data->email;
    
    $sqlEmployees = mysqli_query($connectionDB,"UPDATE employees SET name='$name',email='$email' WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}
// Consulta todos los registros de la tabla empleados
$sqlEmployees = mysqli_query($connectionDB,"SELECT * FROM employees ");
if(mysqli_num_rows($sqlEmployees) > 0){
    $employees = mysqli_fetch_all($sqlEmployees,MYSQLI_ASSOC);
    echo json_encode($employees);
}
else{ echo json_encode([["success"=>0]]); }


