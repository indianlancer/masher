<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 *
 *   this code is refered from https://github.com/EllisLab/CodeIgniter/wiki/Acicrud-library
 *   Some new modification done in this to make more compatible.
 *  
 */
/**
 * @name ACICRUD
 * @author Samuel Sanchez <samuel.sanchez.work@gmail.com> - http://www.kromack.com/acicrud/
 * @package CodeIgniter
 * @copyright ACICRUD by Samuel Sanchez est mis Ã  disposition selon les termes de la licence Creative Commons PaternitÃ©-Pas dâ€™Utilisation Commerciale-Partage des Conditions Initiales Ã  lâ€™Identique 2.0 France. Les autorisations au-delÃ  du champ de cette licence peuvent Ãªtre obtenues Ã  http://www.kromack.com/acicrud/.
 * @license http://creativecommons.org/licenses/by-nc-sa/2.0/fr/
 * @tutorial http://www.kromack.com/acicrud/
 * @see http://www.kromack.com/acicrud/
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 */
class RT_Model extends CI_Model {

    //DATABASE PROPERTIES
   
        //Table name
        protected $table = null;
		
        //Version
        private static $version = 'b6602b8889da7f18519a07678a5c935a4b118371';

        //Database object name
        private $o_db = NULL;
        
        private $create_update="";
        
        
        private $obj="";
       
    //ATTRIBUTES
       
        //Leave empty or set it to override the constructor routine. Your table must be at least 1NF.
        public $key = '';
       
        //Leave empty or set it to override the constructor function
        public $fields = array();
        
        //Useful to call another model inside a model via $this->CI
       	public $CI = NULL;   
       	
        //Last inserted ID by Acicrud
        public $last_id = FALSE;       	    
     
   
    public function __construct($database = null) {
        //Setting the CodeIgniter instance
        $this->CI = & get_instance();
        
        $load_table = $this->CI->router->fetch_class();
        // Setting the database instance
        
        if( !is_null($database) && is_object($database)) {
        	
        	$this->o_db = $database; // Database object provided, we are using it.
        	
        } elseif( !is_null($database) && is_string($database) ) {  
        	  	
        	$this->o_db = $this->CI->load->database($database, TRUE); // Database group name provided, loading it.
        	
        } else { 
        	   	
        	$this->o_db = $this->db; // Nothing provided, we are loading the default database  	
        }
        if($this->CI->load_model)
        {       
            if(is_null($this->table)) 
            {
                $this->table = $load_table;
            }
            //Setting the array of SQL fields
            $fields = $this->o_db->list_fields($this->table);

            //If $this->fields isn't overrided by the user
            if(count($this->fields) == 0) {

                foreach($fields as $row)
                {
                    $this->fields[$row] = null;       
                }        	
            }

            //Checking for the primary key
            $fields = $this->o_db->field_data($this->table);
        

            //TODO: Add support for multi-dimensionnal primary keys
            foreach ($fields as $row)
            {
                if($row->primary_key)
                {
                    $this->key = $row->name;
                }
            }
        }
        if(!empty ($this->tables) && is_array($this->tables)) 
        {
        	
            foreach ($this->tables as $table)
            {
                $this->CI->load->model($table."_model");
                
            }
        }
    		
    }

	/**
	 * 
	 * Original PHP4 constructor. 
	 * 
	 * $table must be the table name to load.
	 * $database could be an instancied database object or the database group name to load. If none of both is provided, Acicrud will use the default database. 
	 * 
	 * @param string $table
	 * @param mixed $database
	 * @return Acicrud
	 */
       
    //CRUD
   
	/**
	* Load a database row as an object.
	*
	* @param mixed $id
	*/
    private function _load($id)
    {
    	
    	$this->o_db->select()->from($this->table);
    	
    	// There is two ways to read a row.
    	// By its primary key or by another field. 
    	
    	if(is_array($id)) {
    		
    		// $id is an array, you want to read the row by another field that its primary key
    		
    		// Let's check if fields exist
    		foreach($id as $k => $v) {

    			if(!in_array($k, array_keys($this->fields))) {
    				throw new Exception('TRYING_TO_READ_A_ROW_BY_UN_UNKNOW_FIELD_' . $this->table . '_ERROR');
    			} else {
    				$this->o_db->where($k, $v);
    			}
    		}

    		
    	} else {
    		        		
        	// $id is not an array, we are reading the by its primary key. This is the classic and legacy way.
        	$this->o_db->where($this->key, $id);
    	}
    	
        $query = $this->o_db->get();

        // No result ?
        if($query->num_rows() == 0) {
        	throw new Exception('ID_' . $this->table . '_ERROR');
        }
        
        // Many results ?!?
        if($query->num_rows() > 1) {
        	throw new Exception('ICORRECT_TABLE_SCHEMA' . $this->table . '_READ_FOUND_MANY_ROWS_ERROR');
        }            

        $result = $query->row_array();

        foreach($result as $k => $v)
        {
            $this->fields[$k] = $v;
        }
    }
   
	/**
	* Read a database row and return an object
	* 
	* Two ways exist to read a row :
	* $id could be the numric id of the row or an associative array that would contain the fields to use for identify the row.
	* 
	* Example : read(1) will read the row identified by the primary key value 1.
	* 			read(array('user_id' => '1', 'country_id' => '5')) will make the appropriate WHERE CLAUSES. Be carefull, the query MUST return one unique row
	* 			(use getAll() instead to read much than one row).
	* 			
	*
	* @param mixed $id
	* @return object
	*/
    public function read($id)
    {
        try {
           
        	// If $id is a primary key value, let's check it.
        	if(!is_array($id)) {
        		$this->checkId($id);
        	}
           
            $this->_load($id);
           
            foreach($this->fields as $k => $v)
            {
                $o->$k = $v;
            }       
               
            return $o;
        }
        catch(Exception $e)
        {
            throw $e;
        }
       
    }
    
    public function set_database($o_db) {
    	
    	$this->o_db = $o_db;
    	$this->o_db->test = 'oui';
    }
    
	/**
	* Try to read the latest entry in the table.
	*
	* @return object
	*/
    public function readLast() {
    	
    	if($this->getMaxId() == 0) {

    		 throw new Exception($this->table . '_IS_EMPTY');
    		
    	} else {

    		return $this->read($this->getMaxId());    		
    	}
    }     
   
	/**
	* Check if a specific primary key value exist in database
	*
	* @param unknown_type $id
	*/
    public function checkId($id)
    {
        //TODO: May be add support to arrays ?
        if(is_array($id))
        {
            throw new Exception('CHECK_ID_' . $this->table . '_FAILURE_BECAUSE_ID_IS_AN_ARRAY');
        }
               
        $this->o_db->where($this->key, $id);
		$this->o_db->from($this->table);
		$nb = $this->o_db->count_all_results();
				
        if($nb != 1)
        {
            throw new Exception('CHECK_ID_' . $this->table . '_FAILURE');
        } else {
        	return TRUE;	
        }
    }
   
	/**
	* Insert a row in the database
	*
	* @param object $o
	*/
    public function save()
    {
        if($this->create_update == "create")
        {
            if($this->o_db->insert($this->table) === TRUE) {

                    $this->last_id = $this->o_db->insert_id();
                    return $this->last_id;

            } else {

                if(!$this->o_db->affected_rows() == 1)
                    {
                        throw new Exception('SAVE_' . $this->table . '_ERROR');
                    }        	
            }
        }
        
        elseif($this->create_update == "update")
        {
            //Allow to call update() after read() without storing the $this->key value.
            if(!isset($o->{$this->key})) {
                    $o->{$this->key} = $this->fields[$this->key];
            }
            

            $this->o_db->where($this->key, $o->{$this->key});   

            $this->o_db->update($this->table) or die($this->o_db->last_query());
        }
        else
        {
            throw new Exception('SAVE_' . $this->table . '_ERROR: no type defined');
        }
   
    }
    
    
    public function create()
    {
        $this->create_update = "create";
        foreach($this->fields as $k => $v)
        {
            if(isset($_POST[$k])) // Prevent emptys id's
            {
                $this->o_db->set($k, $this->input->post($k));    
            }
            if(isset($this->request->data[$k]))
            {
                $this->o_db->set($k, $this->request->data[$k]);    
            }
        }
        
        
    }   
   
    
    /**
	* Update a specific row in the database by copying the local object
	*
	* @param object $o
	*/
    public function update($id)
    {   
        $this->create_update = "update";
        foreach($this->fields as $k => $v)
        {
            if(isset($_POST[$k]) && !isset($this->request->data[$k])) // Prevent emptys id's
            {
                if(strpos("image", $k) === false)
                $this->o_db->set($k, $this->input->post($k));    
            }
            elseif(isset($this->request->data[$k]))
            {
                $this->o_db->set($k, $this->request->data[$k]);    
            }
        }
        
        $this->read($id);
       
    }
	/**
	 * Delete rows.
	 * 
	 * Legacy compatibility : $where could be the numeric id of the row to delete.
	 * 
	 * @param array $where An associative array of field => value to use in the WHERE clause
	 * @return int
	 */ 
    public function delete($where)
    {	
    	try {
    		
    		if(is_numeric($where)) { 
    		
    			//Legacy compatibility
    			 $this->o_db->delete($this->table, array($this->key => $where));
    			
    		} else if (is_array($where)) {
    			
    			 $this->o_db->delete($this->table,$where);
    			
    		}

    	} catch(Exception$e) {
    		
    		throw new Exception('DELETE_' . $this->table . '_ERROR');
    		
    	}  		 		
    }
   
	
   
   
	/**
	* Basic getter, return the $what value of the current object.
	*
	* @param string $what
	* @return string
	*/   
    public function getter($what) {
    	
    	return $this->fields[$what];     	
    	
    }  
   
	/**
	* Get the $what field value identified by the orilary key $id value
	*
	* @param string $what
	* @param string $id
	* @return mixed
	*/
    public function get($what, $id)
    {   
        //Get all $what
        if(is_null($id))
        {
            $this->o_db->select($what)->from($this->table);
            $query = $this->o_db->get();       
            return $query->result();
        }   
        else {
           
            //Get the specified $what for the specified $id
            try {
                $this->read($id);
                return $this->fields[$what];
            }
            catch(Exception $e)
            {
                throw $e;
            }   
        }
    }
    
    //CORE METHODS
	
	
	/**
	* Run the Active Record Query an return an array of objects
	*
	* @return array
	*/
    public function result() {
        $query = $this->o_db->get();       
        return $query->result();
    }
    
	/**
	* Run the Active Record Query an return one result object
	*
	* @return object
	*/
    public function row() {
        $query = $this->o_db->get();       
        return $query->row();
    }
    
    public function row_array() {
        $query = $this->o_db->get();       
        return $query->row_array();
    } 
    
	/**
	* toString magic method
	*
	* @return string
	*/
    function __toString()
    {
    	$str = 'ACICRUD said :' . '<br /><br />Table : ' . $this->table . '<br />Key : ' . $this->key . '<br /><br /><pre>';
    	
    	ob_start();
    	
        echo var_dump($this->fields);
		
        $str .= ob_get_contents();
        
		ob_end_clean();
		
		$str .= '</pre>';
        
    	return $str;
    }

	/**
	* Stop the script execution in displaying the last query done by the database class.
	* Breaking of execution script can be prevent by givin false to the second parameter.
	* 
	* @tutorial Replace $this->result() by $this->debug() in your custom method.
	* @param boolean $executeQuery
	* @param boolean $die
	*/
    public function debug($executeQuery = true, $die = true) {
    	
    	if($executeQuery) {
    		$this->result();
    	}    	
    	
    	if($die) {
    		die($this->o_db->last_query());
    	} else {
    		echo($this->o_db->last_query());
    	}   	
    }
      
    /**
     * Perform WHERE CLAUSE
     * 
     * Usage : array(field, value)
     *
     * @param array $where
     */    
    protected function _where($where) {
    			
		foreach($where as $k=>$v) {
			$this->o_db->where($k, $v);		
		}
    }        
    
    /**
     * Perform the LIMIT SQL
     * 
     * if $limit is array, produces LIMIT $limit[1], 1$limit[0]
     * if $limit is int, produces LIMIT $limit
     * 
     * @param mixed $limit
     */
    protected function _limit($limit) {
    	
    	if(is_array($limit)) {
    		$this->o_db->limit($limit[1], $limit[0]);
    	} else {
    		$this->o_db->limit($limit);
    	}	
    }
    
    /**
     * Perform the ORDER BY SQL
     * 
     * Produces n times ORDER BY key => way
     * way MUST be 'DESC' or 'ASC'
     *
     * @param array $order
     */
    protected function _order_by($order) {
    	
		/** Legacy Compatibility **/

		if(!is_null($order)) {

			if(!is_array($order)) {			

				$way = $order;
				unset($order);
				$order = array($this->key => $way);
				
			} elseif((isset($order[0])) && (isset($order[1]))) {

				$key = $order[0];
				$way = $order[1];
				
				$order = array($key => $way);
			}
		}
		
		/** END Legacy Compatibility **/
		
		foreach($order as $k=>$v) {
			$this->o_db->order_by($k, $v);		
		}
    }  
   
    //COMMON METHODS 
	
	/**
	* Return a collection of $this->table rows. $limit can be used to LIMIT the query. 
	* $order can be used to ORDER BY results: $order[0] set the field and $order[1] set the way (ASC or DESC).
	*
	* @param mixed $limit
	* @param array $order
	* @return collection
	*/
	public function getAllBy($limit = null, $order = null, $where = null)

	{		
		$this->o_db->from($this->table);
		
		if(!is_null($limit)) {
			
			$this->_limit($limit);
		} 
		
		if(!is_null($order)) {

			$this->_order_by($order);              
		}	 
		
		//FIXME: $where devrait Ãªtre le premier paramÃ¨tre de la fonction getAll
		if(!is_null($where)) {
			
			$this->_where($where);
		} 				
		
		return $this->result();  
		
	}
	
	/**
	 * 
	 * Return row(s) having the $by field to $value
	 * $by accepts the "Custom key/value method" described in the CodeIgniter's active record user guide.
	 * 
	 * @param string $by
	 * @param mixed $value
	 * @return collection
	 */
	public function getBy($by = null, $value = '',$obj_arr='arr') {
		
		if(is_null($by)) {
			throw new Exception('GET_BY_NULL_' . $this->table . '_ERROR');	
		}
		
		$this->o_db->select()->from($this->table)->where($by, $value);
		if($obj_arr=="arr")
		return $this->row_array();
                else
		return $this->row();
		
	}		
	
    
	/**
	 * Return the number of rows of the table
	 * @param Array $where
	 * @return integer
	 */   
    public function countAll($where = null)   
    {
    	if(!is_null($where)) {
    		$this->o_db->where($where);
    	}
    	
    	$this->o_db->from($this->table);
    	
        return $this->o_db->count_all_results();
    } 
    
    /**
     * Return the last inserted ID by Acicrud or by the DBMS if the first one doesn't exist.
     * @return integer
     */
    public function lastId() {
    	
     	if($this->last_id !== FALSE) {
    		
    		//It's more safe to return the last_id retrivied by $this->create() if it's exists.
    		return $this->last_id;
    		
    	} else {
    		
    		//Else we're returning the last inserted id given by the DBMS
    		return $this->o_db->insert_id();
    	}     	
    }
     
    /**
	* This method is an alias of $this->lastId keeped for legacy compatibility.
	* @return integer
	*/
    public function insertId() {
    	return $this->lastId();
    }  
     
    /**
     * Returns the largest currently used ID in the table or 0 if the table is empty.
     * 
     * @return integer
     */
    public function getMaxId() {
    	
            $this->o_db->select_max($this->key);

            $query = $this->o_db->get($this->table);

            $result = $query->row();

            $max_id  = $result->{$this->key};

            //Returns 0 instead of NULL if the table is empty.
            return((is_null($max_id)) ? 0 : $max_id);
    	
    }
    
}

?>