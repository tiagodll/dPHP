<?php
require_once('./dPHP/dBanco.php');

class dTabela
{
	var $id;
	var $linhas;
	var $header;
	var $MostraRodape;
	var $NLinhas;
	
	var $arrColunas;
	
	
	function dTabela($pid, $pMostraRodape=false, $pNLinhas=50)
	{
		$this->id = $pid;
		$this->linhas = array();
		$this->MostraRodape = $pMostraRodape;
		$this->NLinhas = $pNLinhas;
	}
	
	function AddLinha($linha, $RowId="")
	{
		$l = count($this->linhas);
		$this->linhas[$l] = "<tr class='linha". $l%2 . "' OnMouseOver=\"dLinhaOnMouseOver(this, 'linha2');\" "
			. "OnMouseOut=\"dLinhaOnMouseOut(this, 'linha". $l%2 ."');\">";
		foreach($linha as $c)
		{
			$this->linhas[$l] .= "<td";
			if($RowId!="")
				$this->linhas[$l] .= " onClick=\"Click('" . $RowId . "')\"";
			$this->linhas[$l] .= ">$c</td>";
		}
		$this->linhas[$l] .= "</tr>";
	}

	function AddLinhaEditar($linha, $RowId)
	{
		$l = count($this->linhas);
		$this->linhas[$l] = "<tr class='linha". $l%2 . "' OnMouseOver=\"dLinhaOnMouseOver(this, 'linha2');\" "
			. "OnMouseOut=\"dLinhaOnMouseOut(this, 'linha". $l%2 ."');\">";
		foreach($linha as $c)
			$this->linhas[$l] .= "<td>$c</td>";
		
		$this->linhas[$l] .= "<td class='Link' onClick=\"Editar('" . $RowId . "')\">Editar</td>";
		$this->linhas[$l] .= "<td class='Link' onClick=\"Excluir('" . $RowId . "')\">Excluir</td>";
		$this->linhas[$l] .= "</tr>";
	}

	function AddHeader($linha)
	{
		$this->header = "<tr class='header'>";
		foreach($linha as $c)
			$this->header .= "<td>$c</td>";
		$this->header .= "</tr>";
	}
	
	function Render()
	{
		$s = "<table id='$this->id' class='tabela'>";
		$s .= $this->header;
		foreach($this->linhas as $l)
			$s .= $l;
		
		if($this->MostraRodape)
			$s .= "<tr><td class='header' align='center' colspan='" . (count($this->arrColunas)+2) . "'>Exibindo registros 1-".count($this->linhas) . "</td></tr>";
		$s .= "</table>";
		return $s;
	}

	function RenderSql($query, $editar=false, $RowId="")
	{
		$resp = "";
		$dbc = new dBanco();
        $dbc->Conecta();
		$query .= " LIMIT 100";
		echo $query;
        if ($result = mysql_query($query))
        {
            while ($row = mysql_fetch_array($result))
            {
				$arrVal = array();
				$i=0;
				foreach($this->arrColunas as $col)
					$arrVal[$i++] = $row[$col];
				
				if($editar)			$this->AddLinhaEditar($arrVal, $row[$RowId]);
				else if($RowId!="")	$this->AddLinha($arrVal, $row[$RowId]);
				else				$this->AddLinha($arrVal);
            }
            $resp = $this->Render();
        }
        $dbc->Desconecta();
		return $resp;
	}
	function AddColunas($linha)
	{
		$this->arrColunas = $linha;
	}
}
?>