<?php
include_once '../modelo/lote.php';
$lote = new Lote();

if($_POST['funcion']=='crear'){
    $id_producto = $_POST['id_producto'];
    $proveedor=$_POST['proveedor'];
    $stock = $_POST['stock'];
    $vencimiento = $_POST['vencimiento'];
    $lote->crear($id_producto,$proveedor,$stock,$vencimiento);
}

if($_POST['funcion']=='editar'){
    $id_lote = $_POST['id'];
    $stock = $_POST['stock'];
    $lote->editar($id_lote,$stock);
}

if($_POST['funcion']=='borrar'){
    $id = $_POST['id'];
    $lote->borrar($id);
}

if($_POST['funcion']=='buscar'){
    $lote->buscar();
    $json=array();
    $fecha_actual = new DateTime();
    
    foreach ($lote->objetos as $objeto){
        $vencimiento = new DateTime($objeto->vencimiento);
        $diferencia = $vencimiento->diff($fecha_actual);
        $mes = $diferencia->m;
        $dia = $diferencia->d;
        $verifi = $diferencia->invert;

        if($verifi==0){
            $estado = 'danger';
            $mes=$mes*(-1);
            $dia=$dia*(-1);
        }else{
            if($mes>3){
                $estado='light';
            }if($mes<=3){
                $estado='warning';
            }
        }
        
        $json[]=array(
            'id' =>$objeto->id_lote,
            'nombre' =>$objeto->prod_nom,
            'descripcion' =>$objeto->descripcion,
            'adicional' =>$objeto->adicional,
            'vencimiento' =>$objeto->vencimiento,
            'proveedor' =>$objeto->proveedor,
            'stock' =>$objeto->stock,
            'laboratorio' =>$objeto->lab_nom,
            'tipo' =>$objeto->tip_nom,
            'presentacion' =>$objeto->pre_nom,
            'avatar' =>'../img/prod/prod_default.png'.$objeto->logo,
            'mes'=>$mes,
            'dia'=>$dia,
            'estado'=>$estado
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
}

?>
