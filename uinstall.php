<?php
/**
 * 
 * @package ClientManager
 */


 if(!defined('WP_UINSTALL_PLUGIN')){
    die;
 }

 //clear database

 $tarefas=get_posts(array('post_type'=>'tarefas','numberposts'=>-1));

 foreach($tarefas as $tarefa){
   wp_delete_post($tarefa->ID,false);
 } 

