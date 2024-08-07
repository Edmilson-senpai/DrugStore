<?php
include_once 'Conexion.php';

class Venta {
    var $objetos;
    var $acceso;
    public function __construct() {
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function Crear($nombre, $dni, $total, $fecha, $vendedor) {
        $sql = "INSERT INTO venta (fecha, cliente, dni, total, vendedor) VALUES (:fecha, :cliente, :dni, :total, :vendedor)";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':fecha' => $fecha, ':cliente' => $nombre, ':dni' => $dni, ':total' => $total, ':vendedor' => $vendedor));
    }

    function ultima_venta(){
        $sql="SELECT MAX(id_venta) as ultima_venta FROM venta";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }

    function borrar($id_venta){
        $sql = "DELETE FROM venta where id_venta=:id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_venta' => $id_venta));
        echo 'delete';
    }

    function buscar(){
        $sql="SELECT id_venta,fecha,cliente,dni,total, CONCAT(usuario.nombre_us,' ',usuario.apellidos_us) AS vendedor FROM venta JOIN usuario ON vendedor=id_usuario";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }
    function verificar($id_venta,$id_usuario){
        $sql="SELECT * FROM venta WHERE vendedor=:id_usuario and id_venta=:id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario' =>$id_usuario, ':id_venta'=>$id_venta));
        $this->objetos=$query->fetchAll();
        if(!empty($this->objetos)){
            return 1;
        }else{
            return 0;
        }
    }
    function recuperar_vendedor($id_venta){
        $sql="SELECT us_tipo FROM venta join usuario on id_usuario=vendedor where id_venta=:id_venta";
        $query = $this->acceso->prepare($sql);
        $query->execute(array('id_venta'=>$id_venta));
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }

    function venta_dia_vendedor($id_usuario){
        $sql="SELECT sum(total) as venta_dia_vendedor from `venta` where vendedor=:id_usuario and date(fecha) = date(curdate())";
        $query = $this->acceso->prepare($sql);
        $query->execute(array('id_usuario'=>$id_usuario));
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }

    function venta_diaria(){
        $sql="SELECT sum(total) as venta_diaria from `venta` where date(fecha)=date(curdate())";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }

    function venta_mensual(){
        $sql="SELECT sum(total) as venta_mensual from `venta` where date(fecha)=year(curdate()) and month(fecha)=month(curdate())";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }

    function venta_anual(){
        $sql="SELECT sum(total) as venta_anual from `venta` where year(fecha)=year(curdate())";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos=$query->fetchAll();
        return $this->objetos;
    }
}

?>