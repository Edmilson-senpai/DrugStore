<?php
    include_once '../modelo/Usuario.php';
    $usuario = new Usuario();
    if($_POST['funcion']=='buscar_usuario'){
        $json=array();
        $usuario->obtener_datos($_POST['dato']);
        foreach($usuario->objetos as $objeto) {
        $json[]=array(
            'nombre'=>$objeto->nombre_us,
            'apellidos'=>$objeto->apellidos_us,
            'edad'=>$objeto->edad,
            'dni'=>$objeto->dni_us,
            'tipo'=>$objeto->nombre_tipo,
            'telefono'=>$objeto->telefono_us,
            'direccion'=>$objeto->direccion_us,
            'correo'=>$objeto->correo_us,
            'sexo'=>$objeto->sexo_us,
            'extra'=>$objeto->extra_us
        );
    }
    //codifica y transforma en string
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
if($_POST['funcion']=='tomar_datos'){
    $json=array();
    $id_usuario=$_POST['id_usuario'];
    $usuario->obtener_datos($id_usuario);
    foreach($usuario->objetos as $objeto) {
    $json[]=array(
        'telefono'=>$objeto->telefono_us,
        'direccion'=>$objeto->direccion_us,
        'correo'=>$objeto->correo_us,
        'sexo'=>$objeto->sexo_us,
        'extra'=>$objeto->extra_us
    );
}
//codifica y transforma en string
$jsonstring = json_encode($json[0]);
echo $jsonstring;
}
if($_POST['funcion']=='editar_usuario'){
    $id_usuario=$_POST['id_usuario'];
    $telefono=$_POST['telefono'];
    $direccion=$_POST['direccion'];
    $correo=$_POST['correo'];
    $sexo=$_POST['sexo'];
    $extra=$_POST['extra'];
    $usuario->editar($id_usuario, $telefono, $direccion,$correo , $sexo, $extra);
    echo 'editado';
}

?>