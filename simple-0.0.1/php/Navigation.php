<?php
class Model_Navigation
{
    /** Model_File_Navigation */
	public $navigation;
    
    function __construct ($config, $model_data) {
		$this -> config['level-start'] = $config -> level -> start;
		$this -> config['level-end'] =  $config -> level -> depth;
		$this -> config['attributes']['filter'] = $config -> filter;
		#	$this -> config['attributes']['filter'] = array('status' => 'online');

		#show( $config -> filter);
		#show( $config -> selection);
		$this -> config['attributes']['selection'] = $config -> selection;
		$this -> config['modus'] =  $config -> modus;
		
		
		if ($this -> config['modus'] == 'sitemap') {
			 #$this -> config['root'] -> $init['directories']['root'];
			 $this -> config['webhost'] =  $config -> webhost;
			$test = $this -> walkSitemap ($model_data);
		}else {                
			#show($model_data);
			$test = $this -> walk ($model_data);
		}
		
		return $this -> navigation;
    }
	   function __toString() {
	   		return (string) $this -> navigation;
	   	
	   }
   
     	
       function walk ($item, $level = 0) {
           $i = -1;
           foreach ($item as $key => $val) {
				$li_close = '';
               	if ($val -> children()) {
                   $test = $this -> testItem ($val -> singleElement(),$level);
                   #show($val -> getChildrenCount());
                 
                   
                   if ($test) {
                       $i++;
                       if ($i == 0) {
                       		if ($this -> config['modus'] == 'nested' ||
                       		($this -> config['modus'] == 'linear' && $level == $this -> config['level-start'])) {
                           		$this -> navigation .= $this -> stringReturn ('<ul>');
                           		$make = 1;
                       		}
                       }
                       $class = '';
                       if ($css= $this -> getCSS($val,$level)) {
                           $class = ' class="'.implode(' ',$css).'"';
                       }
                       $link = $this -> makeLink($val -> singleElement());
                       $this -> navigation .= $this -> stringReturn ('<li'.$class.'>');
                       $this -> navigation .= $link;
                       $li_close =  $this -> stringReturn ('</li>');
                       
	                   if ($this -> config['modus'] == 'linear') {
	                   		 $this -> navigation .=  $li_close;
	                   		 $li_close = '';
	                   }
                   }
	                   $array[$key][$i] = $this -> walk ($val, $level +1);
	               if ($test) {
	                   $this -> navigation .=  $li_close;
                   }
               }else {
                  
                   $array[$key][] = (string) $val;
                  
               }
             
           }
           if ($make) $this -> navigation .=$this -> stringReturn ('</ul>');
           #echo memory_get_usage() . "\n";
           return $array;
       }
       
       function walkSitemap ($item, $level = 0) {
           $i = -1;
           foreach ($item as $key => $val) {
				$li_close = '';
               	if ($val -> children()) {
                   $test = $this -> testItem ($val -> singleElement(),$level);
              
                   if ($test) {
                       $i++;
                      
                    
                       $link = $this -> makeLink($val -> singleElement());
                      
                       $this -> navigation .= $link;
                   		$array[$key][$i] = $this -> walkSitemap ($val, $level +1);
	                   
                   }
               }else {
                   $array[$key][] = (string) $val;
               }
              
               
           }

           return $array;
       }
       function getCSS ($object,$level) {
           $css = array();
           if ($object -> getAttribute['current']) {
               $css[] = 'current';
                   #$class=' class="cur"';
                   #show($val -> getParents());
           #}elseif($object['parent']) {
           }elseif($object -> getAttribute('parent')) {
               $css[] = 'parent';
           }elseif($object -> getAttribute('brother')) {
               $css[] = 'brother';
           }elseif($object -> getAttribute('child')) {
               $css[] = 'child';
           }elseif($object -> getAttribute('uncle')) {
               $css[] = 'uncle';
           }
         
           $css[] = 'level-'.$level;
           $css[] = 'id-'.$object['id']; 
           return $css;
       }
       public function makeLink($single){
       		
              if (!$single -> name) return false;
              $title = '';
              
              
              $path =  $single -> path;
              
              if ($single -> link) $path = $single -> link;
              
              if ($this -> config['modus'] == 'sitemap') {
              	 #show($single);
              	 $content = IndexController::getContentFilename($single -> getAttribute('id'));
              	 if (file_exists($content)) {
              	 	$lastmod_timestamp = filectime($content);
              	 	$lastmod = date('Y-m-d\TH:m:s+00:00',$lastmod_timestamp);
              	 	$lastmod_xml = '<lastmod>'.$lastmod.'</lastmod>';
              	 }
              	 
              	 $return[] = '<url>';
              	 $return[] = '<loc>http://'.$this->config ['webhost'].$path.'</loc>';
              	 $return[] = $lastmod_xml;
              	 $return[] = '</url>';

              	 return $this -> stringReturn($return);
			  }
               if ($single -> dfn) $dfn = ' <dfn>'.$single -> dfn.'</dfn>';
              if ($single -> linktitle) {
              		if ($single -> dfn) {
              	$title = ' title="'.$single -> linktitle.': '.$single -> dfn.'" ';
              		}else {
              			$title = ' title="'.$single -> linktitle.'" ';

              		}
              
			}
             
              $name = htmlspecialchars($single -> name); 
              $return[] = '<a href="'.$path.'"'.$title.'>';
              #if (REQUEST_URI == $this ->path) {
              if ($single['current']) {
                  $name = '<strong>'.$name.'</strong>';
              }elseif ($single['parent']) {
                  $name = '<em>'.$name.'</em>';
              }else {
                  $name = '<span>'.$name.'</span>';
              }
              $return[] =  $name;
              $return[] =  $dfn;
              $return[] = '</a>';  
              
              
              return $this -> stringReturn($return);
      }
      function stringReturn ($mixed) {
              if (is_array($mixed)) {
                  return implode("\n",$mixed);
              }else {
                  return "\n".$mixed."\n";
              }
          
      }
      function testItem ($item, $level) {
          $test = true;
          if (!$item -> name) return false;
          if ($level < $this -> config['level-start'] ) return false;
          if ($level > $this -> config['level-end'] ) return false;
          if (!$this -> filterAttributes($item, 'filter')) return false;
          if (!$this -> testAttributes($item, 'selection')) return false;
         
          
          return $test;
          
      }
      function filterAttributes ($item, $modus) {
      	if (($selection = $this -> config['attributes'][$modus])) {
      		       
      		foreach ($selection as $key => $value) {
				#echo $key;
      			if ($item -> getAttribute($key) != $value) {
      				#show($item );
      				return false;
      			}
      		}
      		return true;
      		
      	}
      	return true;
      }
      function testAttributes ($item, $modus) {
      	if (($selection = $this -> config['attributes'][$modus])) {
      		       
      		foreach ($selection as $key => $value) {
				#echo $key;
      			if ($item -> getAttribute($key) == $value) {
      				#show($item );
      				return true;
      			}
      		}
      		return false;
      		
      	}
      	return true;
      }
  
}
