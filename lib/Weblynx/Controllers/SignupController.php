<?php

/**
 * Signup Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class SignupController extends Weblynx_Controllers_Base {
    
    public function indexAction() {
//        $name = $this->getRequest()->getParam('name');
//        $age  = $this->getRequest()->getParam('age');
//        'Hi my name is ' . $name . ' and i am ' . $age . ' years young';
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';
        $this->view->headJs[]    = '/js/signup.js';
        $this->view->contentView = '/signup/index.phtml';
        
        $this->renderView();
    }
    
    public function senddetailsAction() {
        // do the saving to db in here and mail the person their stuff
        
        // Last thing redirect to a CMS page
         $this->_redirect('/view/signupthanks');
    }
    
}