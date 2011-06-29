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
        $userData['first_name'] = htmlentities($this->req->getParam('first_name'));
        $userData['surname']    = htmlentities($this->req->getParam('surname'));        
        $userData['email']      = htmlentities($this->req->getParam('email'));
        $userData['mobile']     = htmlentities($this->req->getParam('mobile'));
        $userData['telephone']  = htmlentities($this->req->getParam('telephone'));
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
            /*
            $userDataOne['first_name']        = htmlentities($this->req->getParam('first_nameFirst'));
            $userDataOne['surname']           = htmlentities($this->req->getParam('surnameFirst'));            
            $userDataOne['mobile']            = htmlentities($this->req->getParam('mobileFirst'));
            $userDataOne['telephone']         = htmlentities($this->req->getParam('emailFirst'));
            $userDataOne['website']           = htmlentities($this->req->getParam('websiteFirst'));
            
            $userDataTwo['first_name']        = htmlentities($this->req->getParam('first_nameSecond'));
            $userDataTwo['surname']           = htmlentities($this->req->getParam('surnameSecond'));
            $userDataTwo['surname']           = htmlentities($this->req->getParam('passwordSecond'));
            $userDataTwo['mobile']            = htmlentities($this->req->getParam('mobileSecond'));
            $userDataTwo['telephone']         = htmlentities($this->req->getParam('emailSecond'));
            $userDataTwo['website']           = htmlentities($this->req->getParam('websiteSecond'));                  
            
            // save artist one 
            $artistIdOne = $this->dbMapper->saveRecord($userDataOne, 'artists', 'id');
            
            // save artist two 
            $artistIdTwo = $this->dbMapper->saveRecord($userDataTwo, 'artists', 'id');
            
            $linkAddressOne['artistId']  = $artistIdOne;        
            $linkAddressOne['lineOne']   = htmlentities($this->req->getParam('addressOne'));
            $linkAddressOne['lineTwo']   = htmlentities($this->req->getParam('addressTwo'));
            $linkAddressOne['city']      = htmlentities($this->req->getParam('city'));
            $linkAddressOne['county']    = htmlentities($this->req->getParam('county'));
            $linkAddressOne['postcode']  = htmlentities($this->req->getParam('postcode'));
            $linkAddressOne['country']   = htmlentities($this->req->getParam('country')); 
            
            $linkAddressTwo['artistId']  = $artistIdTwo;        
            $linkAddressTwo['lineOne']   = htmlentities($this->req->getParam('addressOne'));
            $linkAddressTwo['lineTwo']   = htmlentities($this->req->getParam('addressTwo'));
            $linkAddressTwo['city']      = htmlentities($this->req->getParam('city'));
            $linkAddressTwo['county']    = htmlentities($this->req->getParam('county'));
            $linkAddressTwo['postcode']  = htmlentities($this->req->getParam('postcode'));
            $linkAddressTwo['country']   = htmlentities($this->req->getParam('country'));  
            
            // create a artist folder for the images
            mkdir('/images/' . $artistId, 0777);
            
            $linkAddressOne['artist_id']  = $artistIdOne;
            $linkAddressTwo['artist_id']  = $artistIdTwo;
            $linkAddress['address_id'] = $addressId;
            $this->dbMapper->saveRecord($linkAddress, 'artists_addresses', '');
            
            $this->dbMapper->saveRecord($linkAddressOne, 'addresses', 'id');
            $this->dbMapper->saveRecord($linkAddressTwo, 'addresses', 'id');
            */
        } else {
            /* $groupName = htmlentities($this->req->getParam('groupName')); */
        }          
 
        // save artist
        $artistId = $this->dbMapper->saveRecord($userData, 'artists', 'id');
        
        $linkAddress['artist_id']  = $artistId;
        $linkAddress['address_id'] = $addressId;
        $this->dbMapper->saveRecord($linkAddress, 'artists_addresses', '');
        
        // send the email
        $tr = new Zend_Mail_Transport_Sendmail('-f' . 'info@thearthouse.org.uk');
            Zend_Mail::setDefaultTransport($tr);
            
            $htmlmessage  = sprintf('<p>Dear %s %s,

                Thanks for your application to be a %s, here is a copy of the details you provided:

                First Name: %1s
                <br/>
                Surname: %2s
                <br/>
                Email: %s
                <br/>
                Mobile: %s
                <br/>
                Telephone: %s
                <br/>
                Website: %s
                <br/>
                <br/>                
                Address Line One: %s
                <br/>
                Address Line Two: %s
                <br/>
                Address Line Three: %s
                <br/>
                City: %s
                <br/>
                Postcode: %s
                <br/>
                County: %s
                <br/>
                Country: %s                
                <br/>
                <br/>

                Once again, thank you for your application
                The Art House</p>',
                $userData['first_name'],
                $userData['surname'],
                $memberType,
                $userData['email'],
                $userData['mobile'],
                $userData['telephone'],
                $userData['website'],
                $address['line_one'],
                $address['line_two'],
                $address['line_three'],
                $address['city'],
                $address['postcode'],
                $address['county'],
                $address['country']
            );
            
            $mail = new Zend_Mail();
            $mail->setSubject('Patron signup');
            $mail->setBodyHtml('test');
            $mail->setFrom('info@thearthouse.org.uk');
            $mail->addTo('bayesshelton.oliver@gmail.com');
            $mail->send();
        
        
        // redirect
        $this->_redirect('/view/signupthanks');

        /*
        // create a artist folder for the images
        mkdir('/images/' . $artistId, 0777);
        */
    }
    
}