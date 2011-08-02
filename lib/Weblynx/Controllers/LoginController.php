<?php

/**
 * Signup Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class LoginController extends Weblynx_Controllers_Base {        
    
    public function indexAction() {
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';        
        $this->view->contentView = '/login/index.phtml';
        
        $this->renderView();
    }    
    
    public function verifyAction() {
        
        $this->view->emailAddress = $this->req->getParam('email');
        $this->view->password     = $this->req->getParam('password');
        
        if(!$this->view->emailAddress):
            // no email 
            $this->view->emailBlank = 'No Email Address!';
        endif;
        
        if(!$this->view->password):
            // no email 
            $this->view->passwordBlank = 'No Password!';
        endif;
        
        $this->view->contentView = '/login/error.phtml';
        
         $this->view->artist = $this->dbMapper->getAristLoginCheck($this->view->emailAddress, $this->view->password);
        
         if($this->view->artist['id'] >= '1'):
            // start session 
            $_SESSION['id'] = $this->view->artist['id'];
            // redirect to artist page
            $this->_redirect('/artists/biography/id/' . $this->view->artist['id']);
            echo $_SESSION['id']; 
         else :
             $this->view->wrong = 'Your Login Details Are Wrong!';
             $this->view->contentView = '/login/error.phtml';
         endif;
        
        $this->renderView();
    }    
    
}