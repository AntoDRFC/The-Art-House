<?php/** * BlogAdmin Controller * * @author Anto Heley <anto@antodev.com> * @version */class MembersController extends Weblynx_Controllers_Base {        public function indexAction() {        $filterChar = $this->req->getParam('filter-char');        $this->view->membersList = $this->dbMapper->getMembers($filterChar);        $this->view->showall = $filterChar ? $filterChar : false;                                      $this->view->css[]       = '/css/pagebuilder.css';        $this->view->contentView = '/members/index.phtml';                $this->renderView();    }            public function deleteAction() {        $id = $this->req->getParam('id');                if($this->dbMapper->deleteRecord('artists', 'id', $id)) {            $redir = $_SERVER['HTTP_REFERER'];            $this->_redirect($redir);        } else {            throw new Exception('Failed to delete member, please go back and try again.');        }    }        public function memberinfoAction() {        $this->view->artistId = $this->req->getParam('id');                $this->view->link = '/members/update/';                $this->view->headJs[]    = '/js/jquery-1.4.4.js';                               $this->view->contentView = '/members/home.phtml';                $this->view->artist  = $this->dbMapper->getArtist($this->view->artistId);                                     $this->renderView();    }        public function updateAction() {        $id = $this->req->getParam('id');                $userData['id']                          = $id;        $userData['first_name']                  = htmlentities($this->req->getParam('first_name'));        $userData['surname']                     = htmlentities($this->req->getParam('surname'));        $userData['telephone']                   = htmlentities($this->req->getParam('telephone'));        $userData['mobile']                      = htmlentities($this->req->getParam('mobile'));        $userData['email']                       = htmlentities($this->req->getParam('email'));        $userData['website']                     = htmlentities($this->req->getParam('website'));        $userData['password']                    = htmlentities($this->req->getParam('password'));        $userData['organisation']                = htmlentities($this->req->getParam('organisation'));                $addressId = $this->dbMapper->getArtist($userData['id']);                  // Address        $address['address_id'] = $addressId['address_id'];        $address['line_one']   = $this->req->getParam('addressOne');        $address['line_two']   = $this->req->getParam('addressTwo');        $address['line_three'] = $this->req->getParam('addressThree');        $address['city']       = $this->req->getParam('city');        $address['postcode']   = $this->req->getParam('postcode');        $address['county']     = $this->req->getParam('county');        $address['country']    = $this->req->getParam('country');                                              // get saved id and pass that into $userDataAddress        $this->dbMapper->saveRecord($address, 'addresses', 'address_id');                $this->dbMapper->saveRecord($userData, 'artists', 'id');                                        $this->_redirect('artists/viewartist/id/' . $userData['id'] . '');                }        public function approveAction() {        $id = $this->req->getParam('id');                $userData['id']     = $id;        $userData['status'] = 'approved';                $this->dbMapper->saveRecord($userData, 'artists', 'id');                                        $this->_redirect('artists/viewartist/id/' . $id . '');            }        public function rejectAction() {        $id = $this->req->getParam('id');                $userData['id']     = $id;        $userData['status'] = 'reject';                $this->dbMapper->saveRecord($userData, 'artists', 'id');                                        $this->_redirect('artists/viewartist/id/' . $id . '');            }        }