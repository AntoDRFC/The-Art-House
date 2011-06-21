<?php

/**
 * Verification Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class VerificationController extends Weblynx_Controllers_Base {
    
    public function indexAction() {
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';        
        $this->view->headJs[]    = '/js/jquery.tablesorter.js';        
        $this->view->contentView = '/admin/verification.phtml';
        
        $this->view->artistsList = $this->dbMapper->getAdminVerification();
        
        $this->renderView();
    }
    
    public function activateArtist() {                
        
        return $this->dbMapper->setAdminVerificationActive();
        
        // redirect 
    }
    
    public function deactivateArtist() {                
        
        return $this->dbMapper->setAdminVerificationNotActive();
        
        // redirect 
    } 
    
}