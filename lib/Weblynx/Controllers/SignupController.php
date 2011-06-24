<?php

/**
 * Signup Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class SignupController extends Weblynx_Controllers_Base {        
    
    public function indexAction() {
        $this->view->headJs[]    = '/js/jquery-1.4.4.js';
        $this->view->headJs[]    = '/js/signup.js';
        $this->view->contentView = '/signup/index.phtml';
        
        $this->renderView();
    }
    
    public function senddetailsAction() {                        
        // generic inputted data        
        
        $address['lineOne']    = $this->req->getParam('addressOne');
        $address['lineTwo']    = $this->req->getParam('addressTwo');
        $address['city']       = $this->req->getParam('city');
        $address['county']     = $this->req->getParam('county');
        $address['country']    = $this->req->getParam('country');
        
        // get saved id and pass that into $userDataAddress
        $addressId = $this->dbMapper->saveRecord($address, 'addresses', 'id');
        
        //$test = htmlentities($this->getRequest()->getParam('name'));
        $userData['name']             = htmlentities($this->req->getParam('name'));
        $userData['telephone']        = htmlentities($this->req->getParam('telephone'));
        $userData['mobile']           = htmlentities($this->req->getParam('mobile'));
        $userData['email']            = htmlentities($this->req->getParam('email'));
        $userData['website']          = htmlentities($this->req->getParam('website'));
        //$hear       = $this->getRequest()->getParam('hear');
        
        // find out which type of user they are to add more details
        if($this->req->getParam('type') == 'patron') {
            // hmm
        } elseif($this->req->getParam('type') == 'artist') {
            // hmmmm 
        } elseif($this->req->getParam('type') == 'pair') {
            $userDataTwo['name']        = htmlentities($this->req->getParam('nameSecond'));
            $userDataTwo['mobile']      = htmlentities($this->req->getParam('mobileSecond'));
            $userDataTwo['telephone']   = htmlentities($this->req->getParam('emailSecond'));
            $userDataTwo['website']     = htmlentities($this->req->getParam('websiteSecond'));
            
            // save artist two 
            $artistId = $this->dbMapper->saveRecord($userDataTwo, 'artists', 'id');
            
            $linkAddress['artist_id']  = $artistId;
            $linkAddress['address_id'] = $addressId;
            $this->dbMapper->saveRecord($linkAddress, 'artists_addresses', '');           
        } else {
            $groupName = htmlentities($this->req->getParam('groupName'));
        }          
 
        // redirect               
        
        // save artist
        $artistId = $this->dbMapper->saveRecord($userData, 'artists', 'id');
        
        $linkAddress['artist_id']  = $artistId;
        $linkAddress['address_id'] = $addressId;
        $this->dbMapper->saveRecord($linkAddress, 'artists_addresses', '');
    }
    
}