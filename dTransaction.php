<?php
require_once('dBanco.php');

class dTransaction
{
  var $dbh;

  function dTransaction()
  {
    $this->dbh = dBanco::Conecta();
  }

  function _dTransaction()
  {
     dBanco::Desconecta();
  }

  function begin()
  {
    mysql_query("BEGIN", $this->dbh);
  }

  function rollback()
  {
     mysql_query("ROLLBACK", $this->dbh);
  }

  function commit()
  {
    mysql_query("COMMIT", $this->dbh);
  }
  
  function dQuery($query)
  {
	return mysql_query($query, $this->dbh);
  }
} 
?>