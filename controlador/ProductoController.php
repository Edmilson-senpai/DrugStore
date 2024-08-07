<?php
include '../modelo/Producto.php';
$producto = new producto();
if($_POST['funcion']=='crear'){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    $avatar = 'prod_default.jpg';
    $producto ->crear($nombre,$descripcion,$adicional,$precio,$laboratorio,$tipo,$presentacion,$avatar);
}

if($_POST['funcion']=='editar'){
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $adicional = $_POST['adicional'];
    $precio = $_POST['precio'];
    $laboratorio = $_POST['laboratorio'];
    $tipo = $_POST['tipo'];
    $presentacion = $_POST['presentacion'];
    $producto ->editar($id,$nombre,$descripcion,$adicional,$precio,$laboratorio,$tipo,$presentacion);
}

if($_POST['funcion']=='buscar'){
    $producto->buscar();
    $json=array();
    foreach ($producto->objetos as $objeto){
        $producto->obtener_stock($objeto->id_producto);
        foreach($producto->objetos as $obj){
            $total = $obj->total;
        }
        $json[]=array(
            'id' =>$objeto->id_producto,
            'nombre' =>$objeto->nombre,
            'descripcion' =>$objeto->descripcion,
            'adicional' =>$objeto->adicional,
            'precio' =>$objeto->precio,
            'stock' =>$total,
            'laboratorio' =>$objeto->laboratorio,
            'tipo' =>$objeto->tipo,
            'presentacion' =>$objeto->presentacion,
            'laboratorio_id' =>$objeto->prod_lab,
            'tipo_id' =>$objeto->prod_tip_prod,
            'presentacion_id' =>$objeto->prod_present,
            'avatar' =>'../img/prod/'.$objeto->avatar
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

if ($_POST['funcion']=='cambiar_avatar'){
    $id=$_POST['id_logo_prod'];
    $avatar=$_POST['avatar'];
    if(($_FILES['photo']['type']=='image/jpeg')||($_FILES['photo']['type']=='image/png')||($_FILES['photo']['type']=='image/gif')){
        $nombre=uniqid().'_'.$_FILES['photo']['name'];
        $rute='../img/Prod/'.$nombre;
        move_uploaded_file($_FILES['photo']['tmp_name'],$ruta);
        $producto->cambiar_logo($id,$nombre);
        if($avatar!='../img/Prod/prod_default.jpg'){
            unlink($avatar);
        }
        $json=array();
        $json[]=array(
            'ruta'=>$ruta,
            'alert'=>'edit'
        );
        $jsonstring=json_encode($json[0]);
        echo $jsonstring;
    }else{
        $json=array();
        $json[]=array(
            'ruta'=>$ruta,
            'alert'=>'noedit'
        );
        $jsonstring=json_encode($json[0]);
        echo $jsonstring;
    }
}

if ($_POST['funcion']=='borrar'){
    $id=$_POST['id'];
    $producto->borrar($id);
}

if($_POST['funcion']=='buscar_id'){
    $id=$_POST['id_producto'];
    $producto->buscar_id($id);
    $json=array();
    foreach ($producto->objetos as $objeto){
        $producto->obtener_stock($objeto->id_producto);
        foreach($producto->objetos as $obj){
            $total = $obj->total;
        }
        $json[]=array(
            'id' =>$objeto->id_producto,
            'nombre' =>$objeto->nombre,
            'descripcion' =>$objeto->descripcion,
            'adicional' =>$objeto->adicional,
            'precio' =>$objeto->precio,
            'stock' =>$total,
            'laboratorio' =>$objeto->laboratorio,
            'tipo' =>$objeto->tipo,
            'presentacion' =>$objeto->presentacion,
            'laboratorio_id' =>$objeto->prod_lab,
            'tipo_id' =>$objeto->prod_tip_prod,
            'presentacion_id' =>$objeto->prod_present,
            'avatar' =>'../img/prod/'.$objeto->avatar
        );
    }
    $jsonstring = json_encode($json[0]);
    echo $jsonstring;
}
if($_POST['funcion']=='verificar_stock'){
    $error=0;
    $productos=json_decode($_POST['productos']);
    foreach($productos as $objeto){
        $producto->obtener_stock($objeto->id);
        foreach($producto->objetos as $obj){
            $total=$obj->total;
        }
        if($total>=$objeto->cantidad && $objeto->cantidad>0){
            $error=$error+0;
        }else{
            $error=$error+1;
        }
    }
    echo $error;
}


?>