<?php
class dString
{
	static function SpecialCharXchange($pValor)
	{
		$from = array("$", "%", "<", ">", "&", "'");
		$to   = array("^36^", "^37^", "^38^", "^39^", "^40^", "^41^");
		return str_replace($from, $to, $pValor);
	}
	
	static function SpecialCharUnXchange($pValor)
	{
		$from = array("^36^", "^37^", "^38^", "^39^", "^40^", "^41^");
		$to   = array("$", "%", "<", ">", "&", "'");
		return str_replace($from, $to, $pValor);
	}
	
	static function SpecialCharHtml($pValor)
	{
		$from = array("á", "é", "í", "ó", "ú",
					  "ã", "õ", "ç"
					  );
		
		$to   = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;",
					  "&atilde;", "&otilde;", "&ccedil;"
					  );
		return str_replace($from, $to, $pValor);
	}
}
?>