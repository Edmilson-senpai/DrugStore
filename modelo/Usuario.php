<?php
include_once 'Conexion.php';
class Usuario{
    var $objetos;
    var $acceso;
    public function __construct(){
        $db = new Conexion();
        $this->acceso = $db->pdo;
    }
    function Loguearse($dni,$pass){
        $sql="SELECT * FROM usuario inner join tipo_us on us_tipo=id_tipo_us where dni_us=:dni";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni' => $dni));
        $objetos = $query->fetchAll();
        foreach($objetos as $objeto){
            $contrasena_actual = $objeto->contrasena_us;
        }
        if(strpos($contrasena_actual,'$2y$10$')===0){
            if(password_verify($pass,$contrasena_actual)){
                return "logueado";
            }
        }else{
            if($pass==$contrasena_actual){
                return "logueado";
            }
        }
    }

    function obtener_dato_logueo($dni){
        $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us and dni_us=:dni";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni' => $dni));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
    function obtener_datos($id){
        $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us and id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id' => $id));
        $this->objetos = $query->fetchAll();
        return $this->objetos;
    }
    function editar($id_usuario, $telefono, $direccion,$correo, $sexo, $extra){
        $sql="UPDATE usuario SET telefono_us=:telefono, direccion_us=:direccion,correo_us=:correo,sexo_us=:sexo, extra_us=:extra WHERE id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        //colocar variables
        $query->execute(array(':id'=> $id_usuario, ':telefono'=>$telefono,':direccion'=> $direccion,':correo'=> $correo,':sexo'=> $sexo,':extra'=> $extra));
    }
    function cambiar_contra($id_usuario,$oldpass,$newpass){
        $sql="SELECT * FROM usuario where id_usuario=:id";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id'=> $id_usuario));
        $this->objetos = $query->fetchAll();
        foreach($this->objetos as $objeto){
            $contrasena_actual = $objeto->contrasena_us;
        }
        if(strpos($contrasena_actual,'$2y$10$')===0){
            if(password_verify($oldpass,$contrasena_actual)){
                $pass = password_hash($newpass,PASSWORD_BCRYPT,['cost'=>10]);
                $sql="UPDATE usuario SET contrasena_us=:newpass where id_usuario=:id";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_usuario,':newpass'=>$pass));
                echo 'update';
            }else{
                echo 'noupdate';
            }
        }else{
            if($oldpass==$contrasena_actual){
                $pass = password_hash($newpass,PASSWORD_BCRYPT,['cost'=>10]);
                $sql="UPDATE usuario SET contrasena_us=:newpass where id_usuario=:id";
                $query=$this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_usuario,':newpass'=>$pass));
                echo 'update';
            }else{
                echo 'noupdate';
            }
        }

    }
    function buscar(){
        if(!empty($_POST['consulta'])){
            $consulta=$_POST['consulta'];
            $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us where dni_us LIKE :consulta OR nombre_us LIKE :consulta";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':consulta'=>"%$consulta%"));
            $this->objetos=$query->fetchAll();
            return $this->objetos;
        }else{
            $sql="SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us where dni_us  NOT LIKE '' ORDER BY id_usuario LIMIT 25";
            $query = $this->acceso->prepare($sql);
            $query->execute();
            $this->objetos=$query->fetchAll();
            return $this->objetos;
        } 
    }
    function crear($nombre,$apellido,$edad,$dni,$pass,$tipo,$avatar){
        $sql="SELECT id_usuario FROM usuario where dni_us=:dni";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':dni'=>$dni));
        $this->objetos=$query->fetchAll();
        if(!empty($this->objetos)){
            echo 'noadd';
        }else{
            $sql="INSERT INTO usuario(nombre_us, apellidos_us, edad,dni_us, contrasena_us, us_tipo,avatar) VALUES (:nombre,:apellido,:edad,:dni,:pass,:tipo,:avatar);";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':nombre'=>$nombre,':apellido'=>$apellido,':edad'=>$edad,':dni'=>$dni,':pass'=>$pass,':tipo'=>$tipo,':avatar'=>$avatar));
            echo 'add';
        }
    }

    
    function promover($pass,$id_prom,$id_usuario){
        $sql="SELECT id_usuario FROM usuario where id_usuario=:id_usuario";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario));
        $this->objetos=$query->fetchAll();
        foreach($this->objetos as $objeto){
            $contrasena_actual=$objeto->contrasena_us;
        }
        if(strpos($contrasena_actual,'$2y$10$')===0){
            if(password_verify($pass,$contrasena_actual)){
                $tipo=1;
                $sql="UPDATE usuario SET us_tipo=:tipo where id_usuario=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_prom, ':tipo'=>$tipo));
                echo 'promovido';
            }else{
                echo 'promovido';
            }
        }if(!empty($this->objetos)){
            $tipo=1;
            $sql="UPDATE usuario SET us_tipo=:tipo where id_usuario=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_prom, ':tipo'=>$tipo));
            echo 'promovido';
        }else{
            echo 'promovido';
        }
    }
    function degradar($pass,$id_degr,$id_usuario){
        $sql="SELECT id_usuario FROM usuario where id_usuario=:id_usuario";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario));
        $this->objetos=$query->fetchAll();
        if(!empty($this->objetos)){
            $tipo=2;
            $sql="UPDATE usuario SET us_tipo=:tipo where id_usuario=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_degr, ':tipo'=>$tipo));
            echo 'degradado';
        }else{
            echo 'nodegradado';
        }
    }
    function borrar($pass,$id_eliminado,$id_usuario){
        $sql="SELECT * FROM usuario where id_usuario=:id_usuario";
        $query = $this->acceso->prepare($sql);
        $query->execute(array(':id_usuario'=>$id_usuario));
        $this->objetos=$query->fetchAll();
        foreach($this->objetos as $objeto){
            $contrasena_actual = $objeto->contrasena_us;
        }
        if(strpos($contrasena_actual,'$2y$10$')===0){
            if(password_verify($pass,$contrasena_actual)){
                $sql="DELETE FROM usuario where id_usuario=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_eliminado));
                echo 'eliminado';
            }else{
                echo 'noeliminado';
            }
        }else{
            if($pass==$contrasena_actual){
                $sql="DELETE FROM usuario where id_usuario=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_eliminado));
                echo 'eliminado';
            }else{
                echo 'noeliminado';
            }
        }
    }
}
?>