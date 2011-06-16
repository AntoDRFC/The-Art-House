<?php

/**
 * Signup Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ArtistController extends Weblynx_Controllers_Base {
    
    public function indexAction() {
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';        
        $this->view->headJs[]    = '/js/jquery.tablesorter.js';        
        $this->view->contentView = '/artist/index.phtml';
        
        $this->view->artistsList = $this->dbMapper->getArtists();
        
        $this->renderView();
    }
    
    public function viewArtist() {
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';        
        $this->view->contentView = '/artist/index.phtml';
        
        // artist id
        $artistId = $this->getRequest()->getParam('id');
        
        $this->view->artistsList = $this->dbMapper->getArtist($artistId);
        
        $this->renderView();
    }
    
}