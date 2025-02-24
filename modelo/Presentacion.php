<?php
include 'Conexion.php';
class Presentacion{
    var $objetos;
    var $acceso;
    public function __construct(){
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }

    function crear($nombre){
        $sql="SELECT id_presentacion FROM presentacion where nombre=:nombre";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':nombre'=>$nombre));
        $this->objetos=$query->fetchAll();
        if(!empty($this->objetos)){
            echo 'noadd';
        }
        else{
            $sql="INSERT INTO presentacion(nombre) values (:nombre);";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre));
            echo 'add';
        }
    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM presentacion where nombre LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchAll();
            return $this->objetos;
        }else{
            $sql="SELECT * FROM presentacion where nombre NOT LIKE '' ORDER BY id_presentacion LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchAll();
            return $this->objetos;
        }
    }
    function borrar($id){
        $sql="DELETE FROM presentacion where id_presentacion=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id));
        echo 'borrado';
        if(!empty($query->execute(array(':id'=>$id)))){
            echo 'borrado';
        }else{
            echo 'noborrado';
        }
    }
    function editar($nombre,$id_editado){
        $sql="UPDATE presentacion SET nombre=:nombre where id_presentacion=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=>$id_editado,':nombre'=>$nombre)); 
        echo 'edit';
    }
    function rellenar_presentaciones(){
        $sql="SELECT * FROM presentacion order by nombre asc";
        $query = $this->acceso->prepare($sql);
        $query->execute();
        $this->objetos = $query->fetchALL();
        return $this->objetos;
    }
}
?>