<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity extends CI_Controller {
    public function __construct(){
      parent::__construct();
      $this->load->model('sign_model');
      $this->load->helper('url');
    }

    public function index()
    {
       $this->load->view('welcome');
    }
}

?>
