<?php
class Model_NavigationElement extends SimpleXMLElement {
	
	const Container = 'item';
	static public $Current = null;
	static $_filter = array('@status !="offline"');
	static $_single = array(); // $_single['id'] = object;
   	
	 public static function _new($xml, $url, $ns=NULL, $prefix=TRUE) {
        // allows you to set certain option parameters to new default values,
        // or automatically decide whether input data is a file or not
        // optionally, you can save the object in an intermediate variable
        // and peform other actions on/with it before returning it
       
        $_model = new Model_NavigationElement($xml, LIBXML_NOCDATA);
        #$_model -> init($url);
        
        $xpath = $_model -> xpath_filter('//'.self::Container);
		
		/*show($xpath );
		echo '<hr />';
		*/
		foreach ($xpath as $element) {
			#echo $element->getAttribute('name');
			$element -> _getURI();
			#show($element);
		}
        /*$xpath = $_model -> xpath_filter('//'.self::Container);
		foreach ($xpath as $element) {
			#echo $element->getAttribute('name');
			$element -> singleElement();
			#show($element);
		}*/
        return $_model;
    }
   	public  function init($url) {
   		#show($url);
   		self::$Current = $this -> setCurrent($url);
	#	show(self::$Current);

   		$this -> getParents();
   		$this -> getUncles();

		$this -> getBrothers();
		$this -> getChildren();
		$this -> getLanguage();
   		
   		
		$xpath = $this -> xpath_filter('//'.self::Container);
		foreach ($xpath as $element) {
			#echo $element->getAttribute('name');
			$element -> singleElement();
			#show($element);
		}
		#show(self::$_single);
	}
	
	protected function setCurrent($url) {
		$filter[] = 'url="'.$url.'"';
		$element = current($this ->xpath_filter('//'.self::Container,$filter));
		if (empty($element)) {
			$element = current($this ->xpath_filter('//'.self::Container));	
		} 
		
		$element -> _addAttribute('current', 1);
		return $element;
		#return $this -> getElementbyID($xpath->getAttribute('id'));
	}
	
	public function getCurrent() {
		
		return self::$Current -> singleElement();
	}
	
	protected static function getParents(){
         $path = '..';
       
         while ($object = self::$Current -> xpath($path)) {
              if (!empty($object[0])) {
                  $object[0]->  _addAttribute('parent',1);
	               $path .= '/..';

               $return[] = $object[0] -> singleElement();
              }
          }
         return $return;
    }
	
	protected static function getLanguage(){
		if (!self::$Current -> getAttribute('language')) {
			 $path = '..';

			while ($object = self::$Current -> xpath($path)) {
				$language = $object[0] -> getAttribute('language');
              if (!$language) {
               	 $path .= '/..';
              }else {
              	self::$Current -> _addAttribute('language',$object[0] -> getAttribute('language'));
                # show ($object[0] -> getAttribute('language'));
				return true;
              }
         	 }
	         return $return;
			
			
		}
      }
      
      protected static function getBrothers(){
         $path = '..';
         $object = self::$Current -> xpath($path);
         $children = $object[0] -> children();
         foreach ($children as $child) {
                 $child -> _addAttribute('brother',1);
          }
      }
      
    protected static function getUncles(){
         $path = '../../'.self::Container;
         $xpath = self::$Current -> xpath($path);
        foreach ($xpath as $i => $object) {
          	  	$object ->  _addAttribute('uncle',1);
         	
         }
         return $return;
      }
      
	protected static function getChildren(){
         $children = self::$Current -> children();
         foreach ($children as $child) {
                 $child -> _addAttribute('child',1);
         }
      }
	
   	public function getLinear() {
		return self::$_single;
	}
	
   	public function getElementbyID ($id) {
   		return self::$_single[$id];
	}
	
	public function singleElement () {
		$id = $this -> getAttribute('id');
		
		if (isset(self::$_single[(string)$id])) {
			# cache
			#echo 'CACHE';
			return self::$_single[(string)$id];
		}
		# no cache
	   	$return = self::$_single[(string)$id] = &$this -> _deleteChild();
	   	return $return;
	  
	}
	
	
   	protected function _getURI() {
   		 #echo $this -> getAttribute('path').' /:'.strpos($this -> getAttribute('path'),'/').'<br />';
   		 if (strpos($this -> getAttribute('path'),'/') === 0 ) {
   		 	return $this -> url = $this -> getAttribute('path');
   		 }

   		 $path = '..';
		 
		 $return[] = $this -> getAttribute('path');
       	 #show($this);
         while ($object = $this -> xpath($path)) {
         	 //show($object[0]-> _deleteChild());
         	
            if (!empty($object[0])) {
            		$path .= '/..';
               		$return[] = $object[0] -> getAttribute('path').'/';
               #show($object[0]-> _deleteChild());
               /*if (strpos($this -> getAttribute('path'),'/') != 0) {
	           		$path .= '/..';
               		$return[] = '/'.$object[0] -> getAttribute('path');
			    } elseif (strpos($this -> getAttribute('path'),'/') ===0) {
            		$return[] = ''.$object[0] -> getAttribute('path').'/';
             		break;
            	}elseif(empty($object[0])) {
            		break;
            	}
            	*/
            }
         }
		 $return = array_filter($return);
		
		 
		 $return = array_reverse($return);
		 #show ($return);
		  if  ($return[0] == '/' && sizeof($return) > 1) array_shift($return);
		 
		 $this -> url = implode('',$return);
         return $return;
   	}
	
	
	public function xpath_filter($path, $filter = array()) {
		#show($path.$this -> _getFilter($filter));
		$xpath = parent::xpath($path.$this -> _getFilter($filter));
		return $xpath;
	}
	
	public function getAttribute($name){
		 if (!$this || !$name) {
		 	#show ($this -> attributes());
		 	return null;
		 }
		 if (isset($this -> $name)) return (string) $this ->$name;
		 if(($this -> attributes() -> $name)) return (string) $this -> attributes() -> $name;
		 return null;
     }
	
    protected function _addAttribute ($attribute, $value) {
         $this[$attribute] = $value;
    }
  
   	protected function _getFilter($temporary_filter = array()) { // Example _getFilter(array('@id="de"')
   		$filter_array = self::$_filter;
   		if (!empty($temporary_filter)) {
   			$filter_array= array_merge($filter_array , $temporary_filter); 
   		}
   		
   		if (!empty($filter_array)) {
   			$filter = implode (' and ', $filter_array);
   			$filter = '['.$filter.']';
   			#show($filter);
   		}
   		return $filter;
   	}
	
	
   	protected function _setFilter() {
   		
   		
   	}
	
	protected function _deleteChild ($child=self::Container) {
	  if (isset($this -> $child)) {
	      $clone = clone ($this);
	      unset ($clone -> $child);
	      return $clone;
	  }
	  return $this;
	}
	
	
	
   	
}

?>