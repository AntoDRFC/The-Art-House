<?php

/**
 * Signup Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ArtistController extends Weblynx_Controllers_Base {
    
    public function indexAction() {
        
        $filterChar = $this->req->getParam('filter-char');
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';                       
        $this->view->contentView = '/artist/index.phtml';
        
        $this->view->artistsList = $this->dbMapper->getArtists($filterChar);
        
        $this->renderView();
    }    
    
}