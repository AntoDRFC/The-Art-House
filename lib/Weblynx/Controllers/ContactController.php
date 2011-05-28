<?php

/**
 * Contact Controller
 *
 * @author Anto Heley <anto@antodev.com>
 * @version 1.0
 */

class ContactController extends Weblynx_Controllers_Base {
    
    public function senddetailsAction() {
        $name       = htmlentities($this->req->getParam('name', null), ENT_QUOTES, 'utf-8');
        $email      = htmlentities($this->req->getParam('email', null), ENT_QUOTES, 'utf-8');
        $company    = htmlentities($this->req->getParam('company', null), ENT_QUOTES, 'utf-8');
        $telephone  = htmlentities($this->req->getParam('telephone', null), ENT_QUOTES, 'utf-8');
        $enquiry    = htmlentities($this->req->getParam('enquiry', null), ENT_QUOTES, 'utf-8');
        
        // which files are required
        $required_fields = array('name'      => 'Please enter a name',
                                 'email'     => 'Please enter your email address',
                                 'telephone' => 'Please enter a phone number',);
        
        // check the required fields have been filled in
        $errors = array();
        foreach($required_fields as $required_field=>$error) {
            if($$required_field == '') {
                $errors[] = $error;
            }
        }
        
        if(!count($errors)) {
            $email_company = ($company) ? sprintf('Company: %s<br>', $company) : '';
            $email_enquiry = ($enquiry) ? sprintf('<p>Enquiry:<br />%s</p>', $enquiry) : '';
            
            $customfields = '';
            
            $tr = new Zend_Mail_Transport_Sendmail('-f' . $this->config->settings->email->from);
            Zend_Mail::setDefaultTransport($tr);
            
            $htmlmessage  = sprintf('<p>The following enquiry has been submitted from the %s website:,</p>
                                     <p>Name: %s<br />
                                     Email: %s<br />
                                     %s
                                     Telephone: %s</p>
                                     %s', $this->config->settings->email->company, $name, $email, $email_company, $telephone, $email_enquiry);
            
            $mail = new Zend_Mail();
            $mail->setSubject($this->config->settings->email->subject);
            $mail->setBodyHtml($htmlmessage);
            $mail->setFrom($this->config->settings->email->from);
            $mail->addTo($this->config->settings->email->to);
            $mail->send();
            
            $this->_redirect('/view/thankscontactus/');
        } else {
            $this->session->formdata['data']   = $this->req->getParams();
            $this->session->formdata['errors'] = $errors;
            $this->_redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
}