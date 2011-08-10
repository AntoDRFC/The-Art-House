<?php

/**
 * Artists Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ArtistsController extends Weblynx_Controllers_Base {
    
    public function preDispatch() {
        $this->view->artforms   = $this->dbMapper->getArtForms();
        $this->view->activities = $this->dbMapper->getActivities();
    }
    
    public function indexAction() {
        $filter['filterChar'] = $this->req->getParam('filter-char');
        $filter['name']       = $this->req->getParam('name');
        $filter['artform']    = $this->req->getParam('artform');
        $filter['activity']   = $this->req->getParam('activity');
        $filter['approved']   = 1;
        
        $this->view->artistsList = $this->dbMapper->getArtists($filter);
        $this->view->showall = $filter['filterChar'] ? $filter['filterChar'] : false;
        
        $this->view->filter = $filter;
        
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
        
        if(isset($_SESSION['id']) && ($_SESSION['id'] == $this->view->artist["id"])) {
            $this->view->showLinks = true;
        }
        
        $this->renderView('artists.phtml');
    }
    
    public function biographyAction() {
        $artistId = $this->req->getParam('id');
        $this->view->artist = $this->dbMapper->getArtist($artistId);
        
        $artforms = $this->dbMapper->getArtformsByArtistId($artistId);
        $this->view->artforms = $artforms;
        
        // get 1 piece of work
        $work = $this->dbMapper->getArtistWork($artistId);
        $this->view->work = array_pop($work);
        
        if(isset($_SESSION['id']) && ($_SESSION['id'] == $this->view->artist["id"])) {
            $this->view->profileOwner = true;
        }
        
        $this->view->metaTitle   = 'Artists Biography';
        
        $this->view->contentView = '/artist/biography.phtml';
        $this->renderView('artists.phtml');
    }
    
    public function editprofileAction() {
        $this->view->artistId = $this->req->getParam('id');
        
        if($this->view->artistId != $_SESSION['id']) {
            throw new Exception('Error: This is not your profile to edit');
        }
        
        $this->view->artist  = $this->dbMapper->getArtist($this->view->artistId);
        /* $this->view->address = $this->dbMapper->getAddress($this->view->artistId);                 */

        $this->view->contentView = '/artist/editprofile.phtml';        
        $this->renderView();
    }
    
    public function newsAction() {
        $this->view->artistId    = $this->req->getParam('id');
        
        $this->view->artist      = $this->dbMapper->getArtist($this->view->artistId);
        $this->view->artistNews  = $this->dbMapper->getArtistNews($this->view->artistId);
        
        $this->view->contentView = '/artist/news.phtml';        
        
        if(isset($_SESSION['id']) && ($_SESSION['id'] == $this->view->artist["id"])) {
            $this->view->showLinks = true;
        }
        
        $this->renderView('artists.phtml');
    }
    
    public function addnewsAction() {  
        
        $this->view->artist      = $this->dbMapper->getArtist($_SESSION['id']);
        
        $this->view->contentView = '/artist/addnews.phtml';        
        $this->renderView('artists.phtml');
    }
    
    public function updatenewsAction() {
        $newsId = $this->req->getParam('newsId');
        
        $this->view->artist      = $this->dbMapper->getArtist($_SESSION['id']);
        $this->view->artistNews  = $this->dbMapper->getArtistNews($newsId);                

        $this->view->contentView = '/artist/updatenews.phtml';        
        $this->renderView();
    }
    
    public function updateartworkAction() {  
        $artworkId = $this->req->getParam('artworkid');

        $this->view->artist      = $this->dbMapper->getArtist($_SESSION['id']);
        $this->view->artistWork  = $this->dbMapper->getWorkById($artworkId);                       
        
        $this->view->contentView = '/artist/updateartwork.phtml';        
        $this->renderView();
    }
    
    public function savenewsAction() {               
        
        $userData['title']      = htmlentities($this->req->getParam('title'));
        $userData['artist_id']  = $_SESSION['id'];
        $userData['content']    = htmlentities($this->req->getParam('content'));        
        $userData['newsdate']   = date('Y-m-d');
        $userData['news_id']    = htmlentities($this->req->getParam('news_id'));        
        
        if(!$userData['news_id']) {
            $this->dbMapper->saveRecord($userData, 'artists_news');
        }
        
        $this->dbMapper->saveRecord($userData, 'artists_news', 'news_id');
        
        $this->_redirect('/artists/news/id/' . $_SESSION['id']);
                
    }
    
    public function updateAction() {                
        $userData['id']           = $_SESSION['id'];
        $userData['first_name']   = htmlentities($this->req->getParam('first_name'));
        $userData['surname']      = htmlentities($this->req->getParam('surname'));
        $userData['telephone']    = htmlentities($this->req->getParam('telephone'));
        $userData['mobile']       = htmlentities($this->req->getParam('mobile'));
        $userData['email']        = htmlentities($this->req->getParam('email'));
        $userData['website']      = htmlentities($this->req->getParam('website'));
        $userData['organisation'] = htmlentities($this->req->getParam('organisation'));
        
        $password = htmlentities($this->req->getParam('password'));
        if($password) {
            $userData['password'] = $password;
        }
        
        $addressId = $this->dbMapper->getArtist($userData['id']);  
        
        // Address
        $address['address_id'] = $addressId['address_id'];
        $address['line_one']   = $this->req->getParam('line_one');
        $address['line_two']   = $this->req->getParam('line_two');
        $address['line_three'] = $this->req->getParam('line_three');
        $address['city']       = $this->req->getParam('city');
        $address['postcode']   = $this->req->getParam('postcode');
        $address['county']     = $this->req->getParam('county');
        $address['country']    = $this->req->getParam('country');                              
        
        // get saved id and pass that into $userDataAddress
        $this->dbMapper->saveRecord($address, 'addresses', 'address_id');        
        $this->dbMapper->saveRecord($userData, 'artists', 'id');  
        
        $this->_redirect('/artists/biography/id/' . $_SESSION['id']);
    }
    
    public function addartworkAction() {    
        
        $this->view->artist      = $this->dbMapper->getArtist($_SESSION['id']);
        
        $this->view->contentView = '/artist/addartwork.phtml';        
        $this->renderView('artists.phtml');
    }
    
    public function saveartworkAction() {               

        $upload = new Zend_File_Transfer_Adapter_Http();
        $dest_dir = $this->config->paths->base . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'artist_uploads' . DIRECTORY_SEPARATOR . $_SESSION['id'];
        
        if(!file_exists($dest_dir)){
            if(!mkdir($dest_dir)){
                throw new Exception("Could not upload image it already excisits.");
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
//        $userData['artist_id']  = '1284'; //$_SESSION['id'];
        $userData['artist_id']  = $_SESSION['id'];
        $userData['about_artwork']      = htmlentities($this->req->getParam('about_artwork'));
        $userData['picture']    = $info['name'];
        $userData['credits']    = htmlentities($this->req->getParam('credits'));
        $userData['work_id']    = htmlentities($this->req->getParam('work_id'));
        
        if(!$userData['work_id']) {
            $this->dbMapper->saveRecord($userData, 'artists_work');
        }
        
        $this->dbMapper->saveRecord($userData, 'artists_work', 'work_id');
        
        $this->_redirect('/artists/viewartist/id/' . $_SESSION['id']);
                
    }
    
}