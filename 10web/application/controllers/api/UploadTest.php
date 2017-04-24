<?php
require 'tools.php';

class UploadTest extends CI_Controller {
    public function __constructor() {
        parent::__constructor();
        $this->load->helper('url_helper');
        
    }

    public function index() {
        echo "api/uploadtest";
    }

    public function upload() {
        $filePath = 'tools.php';
        $key = 'tools_php';
        fileUpload($filePath,$key);
    }
}
