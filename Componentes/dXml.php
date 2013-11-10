<?php
class dXml extends SimpleXMLElement
{
	 public function GetXmlItemById($dx, $id)
	 {
		 if ($dx['id'] == $id) {
			 return this;
		 }
		 else if (count($dx->Children())>0)
		 {
			 //pesquisa nivel atual
			 foreach ($dx->Children() as $child)
			 {
			   if($child['id']==$id)
				 return $child;
			 }
			 //pesquisa no nivel seguinte
			 foreach ($dx->Children() as $child)
			 {
				 if (count($child->Children())>0)
					 return GetXmlItemById($child, $id);
			 }
		 }
		 return null;
	 }
	 
	 public function getAttributeArray()
	 {
		$x = array();
        foreach($this->attributes() as $key=>$val)
		{
			$x[$key] = $val;
        }
		return $x;
    }
	 
	 public function getAttribute($name){
        foreach($this->attributes() as $key=>$val){
            if($key == $name){
                return (string)$val;
            }// end if
        }// end foreach
    }// end function getAttribute
   
    public function getAttributeNames(){
        $cnt = 0;
        $arrTemp = array();
        foreach($this->attributes() as $a => $b) {
            $arrTemp[$cnt] = (string)$a;
            $cnt++;
        }// end foreach
        return (array)$arrTemp;
    }// end function getAttributeNames
   
    public function getChildrenCount(){
        $cnt = 0;
        foreach($this->children() as $node){
            $cnt++;
        }// end foreach
        return (int)$cnt;
    }// end function getChildrenCount
   
    public function getAttributeCount(){
        $cnt = 0;
        foreach($this->attributes() as $key=>$val){
            $cnt++;
        }// end foreach
        return (int)$cnt;
    }// end function getAttributeCount
   
    public function getAttributesArray($names){
        $len = count($names);
        $arrTemp = array();
        for($i = 0; $i < $len; $i++){
            $arrTemp[$names[$i]] = $this->getAttribute((string)$names[$i]);
        }// end for
        return (array)$arrTemp;
    }// end function getAttributesArray
} ?>