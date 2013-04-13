<?php
//Load PAGE header_right modules (If any)
if(!empty($modules)){
    //if($page_modules[0] != ""){
        foreach($modules as $module){
            
            //If the module is enabled for this page but not global
            if(@in_array($module->id,$page_modules) 
                    && $module->module_position == 'header_right' 
                    && $module->is_global == 0 
                ){
                echo '<div class="module_' . $module->module_position . ' ' . $module->class_suffix . '">';
                //If "show_name" is enabled then display the module name heading
                 if($module->show_name == 1) 
                    echo '<h3>'.$module->name.'</h3>';
                //If it is a straight html module with no php
                if($module->is_editable){
                    echo $module->content;
                } else {
                    //Get the view name from the module name
                    $mod_view = strtolower(str_replace(' ','_',$module->name));
                    //Load the modules view file
                    $this->load->view("public/modules/mod_$mod_view"); 
                }
               echo '</div>';
            //If the module is global
            } elseif($module->module_position == 'header_right' 
                    && $module->is_global == 1 
                    ){
                echo '<div class="module_' . $module->module_position . ' ' . $module->class_suffix . '">';
                //If "show_name" is enabled then display the module name heading
                 if($module->show_name == 1) 
                    echo '<h3>'.$module->name.'</h3>';
                //If it is a straight html module with no php
                 if($module->is_editable){
                    echo $module->content;
                } else {
                    //Get the view name from the module name
                     $mod_view = strtolower(str_replace(' ','_',$module->name));
                    //Load the modules view file
                    $this->load->view("public/modules/mod_$mod_view"); 
                }
                echo '</div>';
            }
        }
    //}
} 
?>