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
        $this->view->page_title  = 'Get Involved';
        $this->view->contentView = '/signup/index.phtml';
        
        $this->renderView();
    }
    
    public function patronAction() {
        $this->view->page_title  = 'Patron Signup';
        $this->view->contentView = '/signup/patron.phtml';
        
        $this->renderView();
    }
    
    public function senddetailsAction() {                        
        // Shared input data
        
        // Personal info
        $userData['first_name'] = htmlentities($this->req->getParam('firstName'));
        $userData['surname']    = htmlentities($this->req->getParam('surname'));
        $userData['email']      = htmlentities($this->req->getParam('email'));
        $userData['mobile']     = htmlentities($this->req->getParam('mobile'));
        $userData['telephone']  = htmlentities($this->req->getParam('phone'));
        $userData['website']    = htmlentities($this->req->getParam('website'));
        
        // Address
        $address['line_one']   = $this->req->getParam('addressOne');
        $address['line_two']   = $this->req->getParam('addressTwo');
        $address['line_three'] = $this->req->getParam('addressThree');
        $address['city']       = $this->req->getParam('city');
        $address['postcode']   = $this->req->getParam('postcode');
        $address['county']     = $this->req->getParam('county');
        $address['country']    = $this->req->getParam('country');
        
        // get saved id and pass that into $userDataAddress
        $addressId = $this->dbMapper->saveRecord($address, 'addresses', 'id');
//var_dump($address); echo '<br><br>';
        
        // other fields
        $userData['how_hear'] = $this->req->getParam('hear');
        $accept_communication = $this->req->getParam('accept_communication');
        if($accept_communication == 'nocomms') {
            $userData['accept_communication'] = 'N';
        }
        
        $userData['how_pay'] = $this->req->getParam('verification');
        $userData['date_joined'] = date('Y-m-d');
        
        $memberType = $this->req->getParam('type');
        switch($memberType) {
            case 'patron':
                $userData['member_type'] = 'Supporter';
                break;
        }
        
        // find out which type of user they are to add more details
        if($this->req->getParam('type') == 'patron') {
            
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
        //var_dump($userData);
        
        $linkAddress['artist_id']  = $artistId;
        $linkAddress['address_id'] = $addressId;
        $this->dbMapper->saveRecord($linkAddress, 'artists_addresses', '');
        
        $this->_redirect('/view/signupthanks');
    }
    
}