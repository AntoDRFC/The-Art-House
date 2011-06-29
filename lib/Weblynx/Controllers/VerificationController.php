<?php

/**
 * Verification Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class VerificationController extends Weblynx_Controllers_Base {
    
    protected $table = 'artist';
    protected $artist = '';
    protected $primary_key = 'id';
    
    public function indexAction() {
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';                
        $this->view->contentView = '/verification/index.phtml';
        
        $this->view->univerifiedArtist = $this->dbMapper->getAdminVerification();
        
        $this->renderView();
    }
    
    public function activateArtist() {                
        
        return $this->dbMapper->setAdminVerificationActive($this->table,
                                                           "SET active = '1'",
                                                           $this->primary_key, 
                                                           $this->artist);
        
        // redirect 
    }
    
    public function deactivateArtist() {                
        
        return $this->dbMapper->setAdminVerificationNotActive($this->table,
                                                              "SET active = '0'",
                                                              $this->primary_key,
                                                              $this->artist);
        
        // redirect 
    } 
    
}