<?php

/**
 * Artist Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ArtistController extends Weblynx_Controllers_Base {
    
    public function indexAction() {
        $filterChar = $this->req->getParam('filter-char');
        $this->view->artistsList = $this->dbMapper->getArtists($filterChar);
        $this->view->showall = $filterChar ? $filterChar : false;
        
        $this->view->metaTitle   = 'Find an Artist';
        $this->view->contentView = '/artist/index.phtml';
        $this->renderView();
    }
    
}