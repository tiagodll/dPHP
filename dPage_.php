<?php
    require_once('Componentes/dXml.php');
    require_once('dBanco.php');
    require_once('Classes/Util.php');

	class dPage_
    {
		var $UsuId;
		var $EmpId;
		var $WebConfig;
		var $param;
		
        function dPage_()
        {
			
			@$this->UsuId = ($_GET["UsuId"]==null ? $_POST["UsuId"] : $_GET["UsuId"]);
			@$this->EmpId = ($_GET["EmpId"]==null ? $_POST["EmpId"] : $_GET["EmpId"]);
			$this->WebConfig = simplexml_load_file("dPHP/WebConfig.xml");
			
			$param = array();
			foreach($_POST as $key => $val)
			{
				if(substr($key, 0,2)=="d_")
					$param[substr($key,2)] = $val;
			}
        }
		
		function using($arq)
		{
			$wc = simplexml_load_file("dPHP/WebConfig.xml");
			require_once($wc->Caminho . $arq);
		}
		
		function GetQueryString()
		{
			return "&UsuId=" . $this->UsuId
				. "&EmpId=" . $this->EmpId;
		}
		function GetUsuId()
		{
			return $this->UsuId;
		}
		
		function Conecta()
		{
			$dbanco = new dBanco();
			$dbanco->Conecta();
		}
		function Desconecta()
		{
			$dbanco = new dBanco();
			$dbanco->Desconecta();
		}
		function Debug($val)
		{
			if($this->WebConfig->Modo == "Debug")
			{
				if(count($val)>1)
				{
					echo "DEBUG # ";
					print_r($val);
				}
				else
				{
					echo "DEBUG # ", $val;
				}
			}
		}
    }	
?>