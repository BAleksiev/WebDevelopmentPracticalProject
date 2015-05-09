<?php

class View {

    public static function make($view, $data) {

        $smarty = new Smarty();
        
        $smarty->debugging = false;
        $smarty->caching = false;
//        $smarty->cache_lifetime = 120;
        
        $smarty->setCompileDir('cache/smarty/templates_c/');
        
        $smarty->assign($data);
        $smarty->assign('layout', $view);
        
        $smarty->display('views/base.tpl');
    }

}
