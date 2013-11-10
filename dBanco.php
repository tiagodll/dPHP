<?php
class dBanco
{
	static function Conecta()
	{
		$wc = simplexml_load_file("dPHP/WebConfig.xml");
		$conexao = mysql_connect ($wc->Banco[0]->Server,$wc->Banco[0]->Usuario,$wc->Banco[0]->Senha)
		or die ('Erro na conexão: ' . mysql_error());
		
		$db = mysql_select_db($wc->Banco[0]->Base)
		or die ("Erro na escolha do banco");
		return $db;
	}
	static function Desconecta()
	{
		mysql_close();
	}
	
	
	static function XmlFromDB($mysql_result,$row_name="row",$doc_name="root")
    {
        $xml= new dXml("<?xml version='1.0' encoding='ISO-8859-1' standalone='yes'?>\n<$doc_name></$doc_name>");
        while($line=mysql_fetch_assoc($mysql_result))
        {
            $row = $xml->addChild($row_name);
            foreach($line as $column => $value)
            {
                $row->addAttribute($column, $value);
            }
        }
        return $xml;
    }
	
	static function dNonQuery($query, $param=array())
	{
		if(count($param)>0)
			$query = dBanco::dBindParam($query, $param);
		//echo $query;
		$dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . $_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		if ($result = mysql_query($query))
        {
			$dx->addChild("Alert", "Atualiza��o executada com sucesso.");
        }
		else
		{
			$dx->addChild("Alert", "Erro ao executar a atualiza��o.");
			$dx->addChild("Erro", mysql_error());
			$dx->addChild("SQL", $query);
		}		
		dBanco::Desconecta();
		return $dx;
	}
	
	static function dSelectScalar($query)
	{
		$resp="";
        dBanco::Conecta();
		if ($result = mysql_query($query))
        {
            if($row = mysql_fetch_array($result))
            {
				$resp = $row[0];
            }
        }
		dBanco::Desconecta();
		return $resp;
	}
	static function dBindParam($query, $param)
	{
		foreach($param as $key => $val)
		{
			$query = str_replace($key, $val, $query);
		}		
		return $query;
	}
	
	static function dSelect($query, $param=array())
	{
		$table = array();
		if(count($param)>0)
			$query = dBanco::dBindParam($query, $param);
        dBanco::Conecta();
		$i=0;
		if ($result = mysql_query($query))
        {
            while ($table[$i++] = @mysql_fetch_array($result))
            {
				//adiciona a linha como array logo acima
            }
			unset($table[$i-1]);
        }
		dBanco::Desconecta();
		return $table;
	}
	
	///Retorna 1 registro em xml
	static function dSelectSingleRow($query)
	{
		$dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . $_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		if ($result = mysql_query($query))
        {
            if ($row = mysql_fetch_array($result))
            {
				$dx->addChild("Count", 1);
				foreach($row as $key => $val)
				{
					$dx->addChild(dString::SpecialCharHtml($key), dString::SpecialCharHtml($val));
				}
            }
			else
				$dx->addChild("Count", 0);
        }
		else
		{
			$dx->addChild("Erro", mysql_error());
			$dx->addChild("Count", 0);
		}		
		dBanco::Desconecta();
		return $dx;
	}

    static function dMakeSelectById($tabela, $arr)
	{
		$dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . $_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		$query = "SELECT * FROM $tabela  WHERE 1=1 ";
        foreach($arr as $key=>$val)
                $query .= " AND $key='$val' ";
		if ($result = mysql_query($query))
        {
            if ($row = mysql_fetch_array($result))
            {
				$dx->addChild("Count", 1);
				foreach($row as $key => $val)
				{
					$dx->addChild(dString::SpecialCharHtml($key), dString::SpecialCharHtml($val));
				}
            }
			else
				$dx->addChild("Count", 0);
        }
		else
		{
			$dx->addChild("Erro", mysql_error());
			$dx->addChild("Count", 0);
		}		
		dBanco::Desconecta();
		return $dx;
	}


	static function dMakeSelect($tabela, $arr)
	{
		$dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . @$_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		$query = "SELECT * FROM $tabela  WHERE 1=1 ";
        foreach($arr as $key=>$val)
                $query .= " AND $key='$val' ";
		$i=0;
		if ($result = mysql_query($query))
        {
            while ($row = mysql_fetch_array($result))
            {
				$dx->addChild("Row");
				foreach($row as $key => $val)
					$dx->Row[$i].addChild($key, $val);
            }
        }
		else
		{
			$dx->addChild("Erro", mysql_error());
			$dx->addChild("Count", 0);
		}
        
		$dx->addChild("Count", count($resp));
		dBanco::Desconecta();
		return $dx;
	}


	static function dMakeDelete($tabela, $arr)
	{
		$dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . $_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		$query = "DELETE FROM $tabela  WHERE 1=1 ";
        foreach($arr as $key=>$val)
                $query .= " AND $key='$val' ";
		if ($result = mysql_query($query))
        {
			$dx->addChild("Alert", "Excluão executada com sucesso.");
        }
		else
		{
			$dx->addChild("Alert", "Erro ao executar a exclusão.");
			$dx->addChild("Erro", mysql_error());
		}		
		dBanco::Desconecta();
		return $dx;
	}
    
    static function dMakeSave($tabela, $arrChave, $arrValores)
    {
        $arv = array_values($arrChave);
		if(count($arrChave)==0 || $arv[0]=="")
                return dBanco::dMakeInsert($tabela, $arrChave, $arrValores);
        else
                return dBanco::dMakeUpdate($tabela, $arrChave, $arrValores);
    }

	static function dMakeUpdate($tabela, $arrChave, $arrValores)
	{
        $dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . $_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		$query = "UPDATE $tabela SET ";
		foreach($arrValores as $key=>$val)
                $query .= " $key='$val',";
        $query = substr($query, 0, strlen($query)-1);        
		$query .= " WHERE ";
		$arv = array_values($arrChave);
		$arc = array_keys($arrChave);
		$query .= $arc[0]."=".$arv[0];
		$dx->addChild("Id", $arv[0]);
		echo $query;
		if ($result = mysql_query($query))
        {
			$dx->addChild("Alert", "Atualização executada com sucesso.");
        }
		else
		{
			$dx->addChild("Alert", "Erro ao executar a atualização.");
			$dx->addChild("Erro", mysql_error());
		}		
		dBanco::Desconecta();
		return $dx;
	}
    static function dMakeInsert($tabela, $arrChave, $arrValores)
	{
		$dx = new dXml("<?xml version='1.0' standalone='yes'?>\n<dPHP>\n<dAcao>" . $_POST["dAcao"] . "</dAcao>\n</dPHP>");
        dBanco::Conecta();
		
		$arv = array_values($arrChave);
		$arc = array_keys($arrChave);
		$id = $arv[0];
		$campoId = $arc[0];
		if($id=="")
		{
				$result = mysql_query("SELECT IFNULL(MAX($campoId),0)+1 AS N FROM $tabela");
				if ($row = mysql_fetch_array($result))
				{
					$id = $row["N"];
				}
		}
		$dx->addChild("Id", $id);
		$query = "";
        $query2 = "";
		foreach($arrValores as $key=>$val)
        {
                $query .= ", $key";
                $query2 .= ", '$val'";
        }
        $query = "INSERT INTO $tabela ($campoId " . $query . ")VALUES($id ". $query2 . ")";
        if ($result = mysql_query($query))
        {
			$dx->addChild("Alert", "Registro inserido com sucesso.");
        }
		else
		{
			$dx->addChild("Alert", "Erro ao inserir registro.");
			$dx->addChild("Erro", mysql_error());
		}		
		dBanco::Desconecta();
		return $dx;
	}
}
?>