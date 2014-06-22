<?php

class Blog_model extends RT_Model {
    
        public function __construct()
	{
            $this->tables = array("home");
            parent::__construct();
	}
}

