<?php

/**
 * Artists Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ArtistsController extends Weblynx_Controllers_Base {
    
    public function indexAction() {
        $filter['filterChar'] = $this->req->getParam('filter-char');
        $filter['name']       = $this->req->getParam('name');
        $filter['artform']    = $this->req->getParam('artform');
        $filter['activity']   = $this->req->getParam('activity');
        $filter['approved']   = 1;
        
        $this->view->artistsList = $this->dbMapper->getArtists($filter);
        $this->view->showall = $filter['filterChar'] ? $filter['filterChar'] : false;
        
        $this->view->metaTitle   = 'Find an Artist';
        $this->view->contentView = '/artist/index.phtml';
        $this->renderView('artists.phtml');
    }
    
    public function viewartistAction() {
        $artistId = $this->req->getParam('id');
        $this->view->artist = $this->dbMapper->getArtist($artistId);
        
        $this->view->work   = $this->dbMapper->getArtistWork($artistId);
        
        $this->view->metaTitle   = 'Artists Artwork';
        
        $this->view->contentView = '/artist/artwork.phtml';
        
        //if($_SESSION['id'] == $this->view->artist["artist_id"]) {
            $this->view->showLinks = true;
       // }
        
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
        $this->view->artistId    = $this->req->getParam('id');
        
        $this->view->artist      = $this->dbMapper->getArtist($this->view->artistId);
        $this->view->artistNews  = $this->dbMapper->getArtistNews($this->view->artistId);
        
        $this->view->contentView = '/artist/news.phtml';        
        $this->renderView();
    }
    
    public function addnewsAction() {               
        $this->view->contentView = '/artist/addnews.phtml';        
        $this->renderView();
    }
    
    public function savenewsAction() {               
        
        $userData['title']      = htmlentities($this->req->getParam('title'));
        $userData['artist_id']  = $_SESSION['id'];
        $userData['content']    = htmlentities($this->req->getParam('content'));        
        $userData['newsdate']   = date('Y-m-d');
        
        $this->dbMapper->saveRecord($userData, 'artists_news', 'news_id');
        
        $this->_redirect('/artists/news/id/' . $_SESSION['id']);
                
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
        
        $this->_redirect('/artists/home/artistId/' . $_SESSION['id']);
    }
    
    public function addartworkAction() {               
        $this->view->contentView = '/artist/addartwork.phtml';        
        $this->renderView();
    }
    
    public function saveartworkAction() {               

        $upload = new Zend_File_Transfer_Adapter_Http();
        $dest_dir = $this->config->paths->base . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'artist_uploads' . DIRECTORY_SEPARATOR . '1284';
        
        if(!file_exists($dest_dir)){
            if(!mkdir($dest_dir)){
                throw new Exception("Could not create upload folder for the header images to go into.");
            }
        }
        $upload->setDestination($dest_dir);

        $allowed_extensions = 'jpg,jpeg,bmp,gif,png,tiff';
        $upload->addValidator('Extension', false, array('extension' => $allowed_extensions, 'messages' => array(Zend_Validate_File_Extension::FALSE_EXTENSION => 'Invalid extension for file %value%')));

        $files = $upload->getFileInfo();
        foreach ($files as $file => $info) {
            if($upload->isUploaded($info['name']) && $upload->isValid($info['name'])) {
                $upload->receive($info['name']);
                $save['picture'] = $info['name'];
            } else {
                throw new Exception('Error Reading Uploaded File.');
            }
        }

        $userData['title']      = htmlentities($this->req->getParam('artists_work'));
        $userData['artist_id']  = '1284'; //$_SESSION['id'];
        $userData['about_artwork']      = htmlentities($this->req->getParam('about_artwork'));
        $userData['picture']    = $info['name'];
        $userData['credits']    = htmlentities($this->req->getParam('credits'));
        
        $this->dbMapper->saveRecord($userData, 'artists_work', 'news_id');
        
        $this->_redirect('/artists/viewartist/id/' . '1284');
                
    }
    
}