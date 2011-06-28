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
    
    public function viewartistAction() {
        
        $artistId = $this->req->getParam('id');
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';                       
        $this->view->contentView = '/artist/moreinfo.phtml';
        
        $this->view->artist = $this->dbMapper->getArtist($artistId);                                
        
        $this->renderView();
    }
    
    public function homeAction() {
        
        $this->view->artistId = $this->req->getParam('id');
        
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';                       
        $this->view->contentView = '/artist/home.phtml';
        
        $this->view->artist  = $this->dbMapper->getArtist($this->view->artistId);
        $this->view->address = $this->dbMapper->getAddress($this->view->artistId);                
        
        $this->renderView();
    }
    
    public function updateAction() {                
        
        $userData['id']                          = $_SESSION['id'];
        $userData['first_name']                  = htmlentities($this->req->getParam('first_name'));
        $userData['surname']                     = htmlentities($this->req->getParam('surname'));
        $userData['telephone']                   = htmlentities($this->req->getParam('telephone'));
        $userData['mobile']                      = htmlentities($this->req->getParam('mobile'));
        $userData['email']                       = htmlentities($this->req->getParam('email'));
        $userData['website']                     = htmlentities($this->req->getParam('website'));
        $userData['password']                    = htmlentities($this->req->getParam('password'));
        $userData['organisation']                = htmlentities($this->req->getParam('organisation'));
        
        $address['artistId']    = $_SESSION['id'];
        $address['lineOne']    = $this->req->getParam('addressOne');
        $address['lineTwo']    = $this->req->getParam('addressTwo');
        $address['city']       = $this->req->getParam('city');
        $address['county']     = $this->req->getParam('county');
        $address['country']    = $this->req->getParam('country');
        
        $this->dbMapper->saveRecord($userData, 'artists', 'id',  $_SESSION['id']);           
        $this->dbMapper->saveRecord($address, 'addresses', 'artistId', $_SESSION['id']);           
        //$this->dbMapper->updateAddress($address);                                         
        $this->_redirect('/artist/home/artistId/' . $_SESSION['id']);
    }
    
}