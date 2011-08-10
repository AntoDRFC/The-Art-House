<?php

class Weblynx_DataMappers_General extends Weblynx_DataMappers_Abstract {
    
    public function getPages($parent = '', $published = '') {
        $sql = "SELECT page_id, page_title, menu_text, permalink, type, published, parent FROM pages WHERE %s ORDER BY parent, ordering ASC";
        
        $where = array();
        if($parent == '0') {
            $where[] = sprintf('parent = %d', $parent);
        }
        
        if($published) {
            $where[] = sprintf('published = %d', $published);
        }
        
        $whereClaus = count($where) ? implode(' AND ', $where) : '1';
        $sql = sprintf($sql, $whereClaus);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getPage($page_id) {
        $sql = sprintf("SELECT * FROM pages WHERE page_id = %d", $page_id);
        
        return $this->db->fetchRow($sql);
    }
    
    public function getPagesByParentId($parent) {
        $sql = sprintf("SELECT * FROM pages WHERE parent = %d ORDER BY ordering ASC", $parent);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getPageByPermalink($permalink, $published='') {
        $sql = sprintf("SELECT * FROM pages WHERE permalink = '%s'", $permalink);
        
        if($published != '') {
            $sql .= ' AND published = 1';
        }
        
        return $this->db->fetchRow($sql);
    }
    
    public function getLastPage($parent) {
        $sql = sprintf("SELECT * FROM pages WHERE parent = %d ORDER BY ordering DESC LIMIT 0,1", $parent);
        
        return $this->db->fetchRow($sql);
    }
    
    public function updatePageOrder($page_id, $page_order, $page_parent) {
        $sql = sprintf("UPDATE pages SET ordering = %d, parent = %d WHERE page_id = %d", $page_order, $page_parent, $page_id);
        
        $this->db->query($sql);
    }
    
    public function getPagesMetaData($page_id='') {
        $sql = sprintf("SELECT * FROM metadata WHERE page_id = %d", $page_id);
        $metadata = $this->db->fetchRow($sql);
        
        if(!$metadata) {
            $sql = "SELECT * FROM cms_settings WHERE setting_title LIKE 'meta_%'";
            $metaArray = $this->db->fetchAll($sql);
            
            $metadata = array();
            foreach($metaArray as $metatag) {
                $metadata[$metatag['setting_title']] = $metatag['setting_value'];
            }
        }
        
        return $metadata;
    }
    
    public function getPagesHeader($page_id='') {
        $sql = sprintf("SELECT * FROM page_headers WHERE page_id = %d", $page_id);
        $header = $this->db->fetchRow($sql);
        
        if(!$header) {
            $sql = "SELECT * FROM cms_settings WHERE setting_title LIKE 'page_header%'";
            $headerArray = $this->db->fetchAll($sql);
            
            $header = array();
            foreach($headerArray as $headerVar) {
                $field = ($headerVar['setting_title'] == 'page_header') ? 'picture' : 'caption';
                $header[$field] = $headerVar['setting_value'];
            }
        }
        
        return $header;
    }
    
    public function getBlogInfo($blog_id) {
        $sql = "SELECT * FROM blogs WHERE blog_id = " . $blog_id;
        
        return $this->db->fetchRow($sql);
    }
    
    public function getBlogPosts($options) {
        $sql = "SELECT * FROM blogposts WHERE %s ORDER BY date_added %s";
        
        $order = isset($options['order']) ? $options['order'] : 'DESC';
        
        $where = array();
        if(isset($options['filter']['approved'])) {
            $where[] = "published = '" . $options['filter']['approved'] . "'";
        }
        
        if(isset($options['filter']['blog_id'])) {
            $where[] = "blog_id = '" . $options['filter']['blog_id'] . "'";
        }
        
        $limit = '';
        if(!isset($options['admin'])) {
            $sql  .= ' LIMIT 0,%d';
            $limit = isset($options['filter']['limit']) ? $options['filter']['limit'] : 15;
        }
        
        $whereClaus = count($where) ? implode(' AND ', $where) : '1';
        $sql = sprintf($sql, $whereClaus, $order, $limit);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getBlogPost($post_id) {
        $sql = sprintf("SELECT * FROM blogposts WHERE post_id = %d", $post_id);
        
        return $this->db->fetchRow($sql);
    }
    
    public function getPostComments($post_id) {
        $sql = sprintf("SELECT * FROM blogcomments WHERE post_id = %d AND approved = 'Y'", $post_id);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getAllPostComments($post_id) {
        $sql = sprintf("SELECT * FROM blogcomments WHERE post_id = %d", $post_id);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getArtformsByArtistId($artistId) {
        $sql = sprintf("SELECT artforms.artform
                        FROM artists_artforms
                        INNER JOIN artforms ON artists_artforms.artform_id = artforms.artform_id
                        WHERE artists_artforms.artist_id = %d", $artistId);
        
        return $this->db->fetchAll($sql);
    }
    
    /*
     * Save a record, pass in the data to be saved, the table to save to, and the primary key
     */
    public function saveRecord($data, $table, $primary_key) {
        $pk_id = '';
        if(isset($data[$primary_key])) {
            $pk_id = $data[$primary_key];
            unset($data[$primary_key]);
        }
        
        if(!$pk_id) {
            $insert = $this->db->insert($table, $data);
            return $this->db->lastInsertId();
        } else {
            $this->db->update($table, $data, $primary_key . ' = ' . $pk_id);
            return $pk_id;
        }
    }
    
    /*
     * Delete a record from the database
     */
    public function deleteRecord($table, $key, $value) {
        $removeSyntax = sprintf('%s = %d', $key, $value);
        
        return $this->db->delete($table, $removeSyntax);
    }
    
    /*
     * Delete children rows from a database
     */
    public function deleteChildren($table, $field, $value) {
        $removeSyntax = sprintf('%s = %d', $field, $value);
        
        return $this->db->delete($table, $removeSyntax);
    }
    
    public function getArtists($filter) {
        $sql = "SELECT DISTINCT
                    artists.*
                FROM
                    artists
                %s
                WHERE %s
                ORDER BY first_name ASC";
        
        $joins = array();
        $where = array();
        if(!empty($filter['filterChar'])) {
            $where[] = "first_name LIKE '" . $filter['filterChar'] . "%'";
        }
        
        if(!empty($filter['name'])) {
            $where[] = "(first_name LIKE '%" . $filter['name'] . "%' OR surname LIKE '%" . $filter['name'] . "%')";
        }
        
        if(!empty($filter['artform'])) {
            $joins[] = "INNER JOIN artists_artforms ON artists.id = artists_artforms.artist_id";
            $where[] = "artists_artforms.artform_id = " . $filter['artform'];
        }
        
        if(!empty($filter['activity'])) {
            $joins[] = "INNER JOIN artists_activities ON artists.id = artists_activities.artist_id";
            $where[] = "artists_activities.activity_id = " . $filter['activity'];
        }
        
        if(!empty($filter['approved'])) {
             $where[] = "status = 'approved'";
        }
        
        $joinClaus  = count($joins) ? implode(' ', $joins) : '';
        $whereClaus = count($where) ? implode(' AND ', $where) : '1';
        $sql = sprintf($sql, $joinClaus, $whereClaus);
        
        return $this->db->fetchAll($sql);                 
    }
    
    public function getArtForms() {
        $sql = "SELECT * FROM artforms ORDER BY artform ASC";
        
        $rows = $this->db->fetchAll($sql);
        
        $artforms = array();
        foreach($rows as $row) {
            $artforms[$row['artform_id']] = $row['artform'];
        }
        
        return $artforms;
    }
    
    public function getActivities() {
        $sql = "SELECT * FROM activities ORDER BY activity ASC";
        
        $rows = $this->db->fetchAll($sql);
        
        $activities = array();
        foreach($rows as $row) {
            $activities[$row['activity_id']] = $row['activity'];
        }
        
        return $activities;
    }
    
    public function getMembers($filterChar) {
        $sql = "SELECT * FROM artists WHERE first_name LIKE '" . $filterChar . "%' ORDER BY first_name ASC";
        return $this->db->fetchAll($sql);                 
    }
    
    public function deleteMember($table, $key, $value) {
        $removeSyntax = sprintf('%s = %d', $key, $value);
        
        return $this->db->delete($table, $removeSyntax);
    }
    
    public function getArtist($artistId) {
        $sql = "SELECT
                    artists.*,
                    addresses.*
                FROM
                    artists
                LEFT JOIN artists_addresses ON artists.id = artists_addresses.artist_id
                LEFT JOIN addresses ON artists_addresses.address_id = addresses.address_id
                WHERE artists.id = '" . $artistId . "'";
        
        return $this->db->fetchRow($sql);
    }
    
    public function getArtistWork($artistId) {
        $sql = sprintf("SELECT * FROM artists_work WHERE artist_id = %d AND approved = 'Y' ORDER BY title ASC ", $artistId);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getWorkById($artworkId) {
        $sql = sprintf("SELECT * FROM artists_work WHERE work_id = %d", $artworkId);
        
        return $this->db->fetchRow($sql);
    }
    
    public function getArtistNews($artistId) {
        $sql = sprintf("SELECT * FROM artists_news WHERE artist_id = %d AND approved = 'Y'", $artistId);
        
        return $this->db->fetchAll($sql);
    }
    
    public function getNewdById($newsId) {
        $sql = sprintf("SELECT * FROM artists_news WHERE news_id = %d", $artworkId);
        
        return $this->db->fetchRow($sql);
    }
    
    public function getAddress($artistId) {
       //$sql = "SELECT * FROM addresses WHERE artistId = '" . $artistId . "' OR artistIdTwo = '" . $artistId . "' ";    
       //return $this->db->fetchRow($sql); 
    }
    
    public function getAdminVerification() {
        $sql = "SELECT * FROM artists WHERE status = 'pending'";       
        return $this->db->fetchRow($sql);
    }
    
    public function getAristLoginCheck($email, $password) {
        $sql = "SELECT * FROM artists WHERE email = '" . $email . "' AND password = '" . $password . "' AND status = 'approved'";       
        return $this->db->fetchRow($sql);
    }
    
    public function getUnApprovedNews() {
        $sql = "SELECT * FROM artists_news WHERE approved = '0'";       
        return $this->db->fetchAll($sql);
    }    
    
    public function getUnApprovedWork() {
        $sql = "SELECT * FROM artists_work WHERE approved = 'N'";       
        return $this->db->fetchAll($sql);
    }   
    
    /*public function setAdminVerificationActive($artistId) {
        $this->db->update($table, $data, $primary_key . ' = ' . $pk_id);
        return $this->db->update($sql);
    }
    
    public function setAdminVerificationNotActive($artistId) {
        $this->db->update($table, $data, $primary_key . ' = ' . $pk_id);
        return $this->db->update($sql);
    }*/
}