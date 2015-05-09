<?php

class HomeController extends Controller {
    
    public function index() {
        
        $categories = (new Category())->find();
        
        $this->data['categories'] = $categories;
        View::make('index', $this->data);
    }
    
}