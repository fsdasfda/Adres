<?php  

/**
* 
*/
class ContactSet extends AppModel
{
	public $useTable =false;
	
	public $records = null;

	
	/**
	 * Generates the datagrid
	 *	
	 * @return array recordset of one contactype
	 * @author rajib ahmed
	 **/
	public function getContactSet($contact_type_id,$options=array())
	{
		$defaults = array(
			'searchKeyword'=>null,
			'filters'=>null,
			'plugins'=>null,
			'page'=>1,	
			'sort'=>'id',
			'order'=>'asc'
		);
		
		$options = am($defaults,$options);
		
		$sql = $this->build_query($contact_type_id,$options	);
		return $this->query($sql);
	}


	private function build_query($contact_type_id,$options)
	{
		/**
		* this one is important
		*/
		extract($options); # generates variables like $searchKeyword , $plugins, $filter,$page ,$sort , $order
			
			
			
		$select = 'SELECT DISTINCT (Contact.id) AS id ';
		
		$from = ' FROM contacts AS Contact 
			LEFT JOIN contacts_groups AS ContactGroup 
			ON Contact.id = ContactGroup.contact_id '; 
		
		$where =' WHERE Contact.contact_type_id = '.$contact_type_id .' ';
		
		$keyword = "";		
		
		if(empty($plugins)){
			return "SELECT (Contact.id) AS id  FROM contacts as Contact
			LEFT JOIN contacts_groups as ContactGroup 
			ON (Contact.id = ContactGroup.contact_id )
			WHERE Contact.contact_type_id = ".$contact_type_id ." ".$filters;		
		}
			

		
		$models =array();
		foreach ($plugins as $field) {
			$models[]=$field['Field']['field_type_class_name'];
		}

		$this->bindModel(array('belongsTo'=>$models));
		
		//Custom fields
		$i=0;
		$orders['id'] = 'id';
		foreach($plugins as $field){
			
			$pluginName = $field['Field']['field_type_class_name'];
			
			$plugin = $this->$pluginName;
			
			$select .= ' , '.$pluginName.'_'.$field['Field']['id'].'.'. $plugin->getDisplayFieldName() ;
			$select .= '  AS "'.$field['Field']['name'].'"';
			
			$from.= ' LEFT JOIN '.$plugin->useTable .' AS ';
			$from.= $plugin->name.'_'.$field['Field']['id'];
			
			#change it to a func
			$from.= ' ON (Contact.id ='.$plugin->name.'_'.$field['Field']['id'].'.contact_id';
			#change it to a func
			$from.= ' AND '.$plugin->name.'_'.$field['Field']['id'].'.field_id = '.$field['Field']['id'] .' )';
			
			
			//stores the Types undersore name and data column to the field name association
			//ie $order['name'] = 'TypeString_4.data'
			$orders[$field['Field']['name']] = $pluginName.'_'.$field['Field']['id'].'.'. $plugin->getDisplayFieldName(); 
			
			if($searchKeyword!=null){
				#change it to session key word
				if($i != 0)	$keyword = $keyword." OR ";
				$keyword = $keyword.$pluginName.'_'.$field['Field']['id'].'.'.$plugin->getDisplayFieldName();
				//$pluginName.'_'.$field['Field']['id'].'.'. $plugin->getDisplayFieldName();
				$keyword = $keyword." LIKE \"%".$searchKeyword."%\" ";
			}
			
			$i++;
		}
		
		$where = $where.$filters;
		
		if($keyword != "")
			$where = $where." AND ( ".$keyword." ) ";
		
		//sorting options
		$ordering  = " order by ".$orders[$sort]." ".$order;
		
		//paging options 
		$limit  = '  limit ' .($page - 1) * $this->page_size	.',' . $this->page_size; 		
		
		
		//Build the SQL query that can display the contacts
		$sql = $select.$from.$where.$ordering.$limit;
		
		//echo $sql;
		return $sql;
	
	}	
		
}


?>