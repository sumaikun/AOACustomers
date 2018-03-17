<?php
namespace Containers;

use Core\ModeloBase;

class EntidadesAseguradoras extends ModeloBase{ 
     
    public function __construct($adapter){        
        parent::__construct(null,$adapter,null);
    }


     public function query($condition)
    {       
        $query = "select * from (select distinct(ent.nombre),ent.id as id, 'entidad' as tipo  from aoacol_aoacars.aseguradora as aseg inner join aoa_clientes.Entidad as ent on aseg.entidad = ent.id UNION select CAST(nombre as CHAR) as nombre, id , 'aseguradora' as tipo from aoacol_aoacars.aseguradora where entidad is null) as composed  ".$condition." order by nombre";
        //echo $query;
        $registers = $this->executeSql($query);
        return $registers;
    }

    

}

?>