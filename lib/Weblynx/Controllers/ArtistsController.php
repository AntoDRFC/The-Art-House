<?php

/**
 * Artists Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ArtistsController extends Weblynx_Controllers_Base {
    
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
        $this->view->artist = $this->dbMapper->getArtist($artistId);
        
        $this->view->work   = $this->dbMapper->getArtistWork($artistId);
        
        $this->view->metaTitle   = 'Artists Artwork';
        
        $this->view->contentView = '/artist/artwork.phtml';
        $this->renderView();
    }
    
    public function biographyAction() {
        $artistId = $this->req->getParam('id');
        $this->view->artist = $this->dbMapper->getArtist($artistId);
        
        $this->view->metaTitle   = 'Artists Biography';
        
        $this->view->contentView = '/artist/biography.phtml';
        $this->renderView();
    }
    
    public function homeAction() {
        $this->view->artistId = $this->req->getParam('id');
        
        $this->view->artist  = $this->dbMapper->getArtist($this->view->artistId);
        /* $this->view->address = $this->dbMapper->getAddress($this->view->artistId);                 */

        $this->view->contentView = '/artist/home.phtml';        
        $this->renderView();
    }
    
    public function newsAction() {
        $this->view->artistId = $this->req->getParam('id');
        
        $this->view->artist  = $this->dbMapper->getArtist($this->view->artistId);
        $this->view->artistNews  = $this->dbMapper->getArtistNews($this->view->artistId);
        
        $this->view->contentView = '/artist/news.phtml';        
        $this->renderView();
    }    
    
    public function updateAction() {                
        
        $userData['id']                          = $_SESSION['id'];;
        $userData['first_name']                  = htmlentities($this->req->getParam('first_name'));
        $userData['surname']                     = htmlentities($this->req->getParam('surname'));
        $userData['telephone']                   = htmlentities($this->req->getParam('telephone'));
        $userData['mobile']                      = htmlentities($this->req->getParam('mobile'));
        $userData['email']                       = htmlentities($this->req->getParam('email'));
        $userData['website']                     = htmlentities($this->req->getParam('website'));
        $userData['password']                    = htmlentities($this->req->getParam('password'));
        $userData['organisation']                = htmlentities($this->req->getParam('organisation'));
        
        $addressId = $this->dbMapper->getArtist($userData['id']);  
        
        // Address
        $address['address_id'] = $addressId['address_id'];
        $address['line_one']   = $this->req->getParam('addressOne');
        $address['line_two']   = $this->req->getParam('addressTwo');
        $address['line_three'] = $this->req->getParam('addressThree');
        $address['city']       = $this->req->getParam('city');
        $address['postcode']   = $this->req->getParam('postcode');
        $address['county']     = $this->req->getParam('county');
        $address['country']    = $this->req->getParam('country');                              
        
        // get saved id and pass that into $userDataAddress
        $this->dbMapper->saveRecord($address, 'addresses', 'address_id');        
        $this->dbMapper->saveRecord($userData, 'artists', 'id');  
        
        $this->_redirect('/artist/home/artistId/' . $_SESSION['id']);
    }
    
}