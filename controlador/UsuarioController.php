<?php
    include_once '../modelo/Usuario.php';
    $usuario = new Usuario();
    session_start();
    $id_usuario=$_SESSION['usuario'];
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

    if($_POST['funcion']=='cambiar_contra'){
        $id_usuario=$_POST['id_usuario'];
        $oldpass=$_POST['oldpass'];
        $newpass=$_POST['newpass'];
        $usuario->cambiar_contra($id_usuario, $oldpass, $newpass);
    }

    if($_POST['funcion']=='buscar_usuarios_adm'){
        $json=array();
        $usuario->buscar();
        foreach($usuario->objetos as $objeto) {
        $json[]=array(
            'id'=>$objeto->id_usuario,
            'nombre'=>$objeto->nombre_us,
            'apellidos'=>$objeto->apellidos_us,
            'edad'=>$objeto->edad,
            'dni'=>$objeto->dni_us,
            'tipo'=>$objeto->nombre_tipo,
            'telefono'=>$objeto->telefono_us,
            'direccion'=>$objeto->direccion_us,
            'correo'=>$objeto->correo_us,
            'sexo'=>$objeto->sexo_us,
            'extra'=>$objeto->extra_us,
            'avatar'=>'../img/'.$objeto->avatar,
            'tipo_usuario'=>$objeto->us_tipo
        );
    }
    //codifica y transforma en string
    $jsonstring = json_encode($json);
    echo $jsonstring;
    }

    if($_POST['funcion']=='crear_usuario'){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $dni = $_POST['dni'];
        $pass = $_POST['pass'];
        $tipo=2;
        $avatar='default.jpg';
        $usuario->crear($nombre,$apellido,$edad,$dni,$pass,$tipo,$avatar);
    }
    if($_POST['funcion']=='promover'){
        $pass=$_POST['pass'];
        $id_prom=$_POST['id_usuario'];
        $usuario->promover($pass,$id_prom,$id_usuario);
    }
    if($_POST['funcion']=='degradar'){
        $pass=$_POST['pass'];
        $id_degr=$_POST['id_usuario'];
        $usuario->degradar($pass,$id_degr,$id_usuario);
    }
    if($_POST['funcion']=='borrar_usuario'){
        $pass=$_POST['pass'];
        $id_eliminado=$_POST['id_usuario'];
        $usuario->borrar($pass,$id_eliminado,$id_usuario);
    }
?>