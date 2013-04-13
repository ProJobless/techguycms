<?php
if(!empty($modules)){
        foreach($modules as $module){
            //If the module is enabled for this page but not global
            if(@in_array($module->id,$page_modules) 
                    && $module->module_position == 'right' 
                    && $module->is_global == 0 
                ){

                echo '<div class="module_' . $module->module_position  . ' ' . $module->class_suffix . '">';
                //If the frontend login is disabled
                if($module->id == 1 && $activate_frontend_login->value == 0){
                    //Do Nothing
                } else {
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
                }
               echo '</div>';
            //If the module is global
            } elseif($module->module_position == 'right' 
                    && $module->is_global == 1 
                    ){
                echo '<div class="module_' . $module->module_position . ' ' . $module->class_suffix . '">';
                //If the frontend login is disabled
                 if($module->id == 1 && $activate_frontend_login->value == 0){
                    //Do Nothing
                } else {
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
                }
                echo '</div>';
            }
        }
} 
?>
	
<?php
if(!empty($menus)){
    foreach($menus as $menu){ 
        if($menu->module_position == 'right'){
            $menu_items = $this->Menu_model->get_parent_items($menu->id);
            echo '<div class="module_' . $menu->module_position  . ' ' . $menu->class_suffix . '">';
            echo '<h3>' . $menu->name . '</h3>';
            echo '<ul>';
            foreach($menu_items as $item){
                echo '<li><a href="'. base_url() .''.$item->alias.'">' .$item->anchor . '</a></li>';
            }
            echo '</ul>';
            echo '</div>';
        }
    }
   
}
?>

