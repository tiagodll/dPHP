<?php
require_once('./dPHP/dBanco.php');

class dCombo
{
	var $id;
	var $linhas;
	
	function dCombo($pid)
	{
		$this->id = $pid;
		$this->linhas = array();
	}
	
	function AddLinha($Valor, $Texto)
	{
		$l = count($this->linhas);
		$this->linhas[$l]  = "<option class='linha". $l%2 . "' value='" . $Valor . "'>";
		$this->linhas[$l] .= $Texto;
		$this->linhas[$l] .= "</option>";
	}
	
	function Render()
	{
		$s = "<select id='$this->id' class='input'>";
		foreach($this->linhas as $l) $s .= $l;
		$s .= "</select>";
		return $s;
	}
	
	function RenderSql($valor, $texto, $query, $ItemZero="")
	{
		$resp = "";
		$dbc = new dBanco();
        $dbc->Conecta();
		if ($result = mysql_query($query))
        {
			if($ItemZero!="")
				$this->AddLinha("0", $ItemZero);
            while ($row = mysql_fetch_array($result))
            {
                $this->AddLinha($row[$valor], $row[$texto]);
            }
            $resp = $this->Render();
        }
		$dbc->Desconecta();
		return $resp;
	}
}
?>