        <!-- Bread Crumb Navigation -->
        <div class="span<?php if(isset($spans_arr['center'])) echo $spans_arr['center'];?>">

        <?php
            if(isset($bread_crumb) && !empty($bread_crumb))
                breadcrumb($bread_crumb);

            if(isset($load_file) && strlen($load_file)>0)
                //include_once $load_file.'.php';
                $this->content->element($load_file,array('spans_arr' => $spans_arr)); 
        ?>
        </div>
        
    

