<?php

require("tools.php");
require("Archive.php");

class User extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('sign_model');
        $this->load->model('usermessage_model');
        $this->load->model('archives_model');
        $this->load->model('user_model');
        $this->load->helper('url_helper');
        $this->load->library('session');
    }

    public function index()
    {
       echo "api/User";
    }

    /**
     * use to make a info
     *
     * @param int $Flag - the flag
     * @param string $Content -the content
     * @param string $Extra -the extra info
     * @return array
     */
    private function getInfo($Flag = 100,$Content = "",$Extra = ""){
      $info = array("Flag" => $Flag,"Content" => $Content,"Extra" => $Extra);
      return $info;
    }

    /**
     *   used to signup and send a auth email to user
     */
    public function signUp(){
        $info = null;

        //check the post argument
        if(!isset($_POST['Account'])&&!isset($_POST['Password'])&&!isset($_POST['Usernick'])){
          $info = $this->getInfo(-1,"too few arguments","");
          echo urldecode(json_encode($info));
          return ;
        }

        //read the arguments
        $account = $this->input->post('Account');
        $password = $this->input->post('Password');
        $nickname = $this->input->post('Usernick');

        //先检查密码长度是否为32以及是否全是小写
        // if(!(strlen($password) === 32 && preg_match('/^[a-z0-9]+$/',$password))){
        //     $info = $this->getInfo(-14,"wrong password format","");
        //     echo urldecode(json_encode($info));
        //     return ;
        // }

        //先检查账号是否存在
        if($this->sign_model->AccountExist($account)){
            $info = $this->getInfo(-2,"account already exists","");
            echo urldecode(json_encode($info));
            return ;
        }

        //在数据库中插入一条记录，状态设置为未激活，同时发送邮件给用户
        $this->sign_model->InsertAccount($account,$password,$nickname);
        $info = $this->getInfo(100,"signup success","");
        $email_info =$this->config->item('email');//获取email配置信息
        //发送邮件给用户
        if(!sendMail($account,$email_info,$this->config->item('base_url'))){
          $info = $this->getInfo(-3,"signup fail","");
        }

        echo urldecode(json_encode($info));
    }


    /**
     * used to signIn
     */
    public function signIn(){
      $account = $_POST['Account'];
      $password = $_POST['Password'];
      //在数据库中查找是否有该账号以及检查该账号是否可用
      $state = $this->sign_model->CheckAccount($account,$password);

      $info = null;

      //未激活状态
      if($state === 1){
          $info = $this->getInfo(-4,"account has not been activated","");
      }
      //已经激活，可以登陆
      else if($state === 2){
         $userinfomation = $this->sign_model->GetUserInfo($account);
         //$this->session->set_userdata($userinfomation);
         $this->session->userdata['info'] = $userinfomation;
         $info = $this->getInfo(100,"sign in success",json_encode($this->session->userdata['info'][0]));
         //print_r($this->session->userdata['info'][0]);
      }
      //账号被封
      else if($state === 3){
          $info = $this->getInfo(-5,"the account has been closed","");
      }
      //密码不正确
      else if($state === 4){
          $info = $this->getInfo(-6,"wrong password","");
      }
      //没有该账号
      else if($state === 5){
          $info = $this->getInfo(-7,"account not exists","");
      }
      echo urldecode(json_encode($info));
    }

    /**
    * 返回session
    */
    public function GetSession(){
      $info = null;
      if($this->session->userdata['info'][0]){
        $info = $this->getInfo(100,"success",json_encode($this->session->userdata['info'][0]));
      }
      echo urldecode(json_encode($info));
    }

    /*用户api*/
    /**
     * 管理与自己相关的文章
     * 用户文章关系 type：0->收藏，1->自己已经发布的文章， 2->自己尚未发布的文章
     * 如果要获取以上三种中的某种直接传入参数0，1，2即可，但是如果要获取所有自己写的文章，即要获取类型1和类型2的文章，传入参数3(但是3不是用户和文章的关系)
     */
    public function GetUserArchives(){
        $user_id = $userid = $this->session->userdata['info'][0]['ID'];
        $type = $_POST['Type'];
        $archives = $this->archives_model->findArcByUserID($user_id,$type);//传入
        print_r($archives);
    }

    /**
     * 根据session获取用户的个人信息，以及未读的私信数目
     */
    public function GetUserInfoBySession(){
      //判断
      if(!isset($this->session->userdata['info'])){
        $info = $this->getInfo(-8,"you have not logged in","");
        echo json_encode($info);
        return ;
      }
      $user_id = $this->session->userdata['info'][0]['ID'];
      try{
        $result = $this->user_model-> get_by_id($user_id);
        echo json_encode($this->getInfo(100,$result[0]));
      }catch(Exception $e){
        echo $this->getInfo('-1',$e);
      }
    }

    /**
     * 根据传来的UserID返回用户的NickName,Account,HeadIcon,Profile
     */
    public function GetUserBaseInfo(){
      if(!isset($_POST['UserID'])){
        $info = $this->getInfo(-1,"缺少参数","");
        echo json_encode($info);
        return ;
      }

      $user_id = $_POST['UserID'];
      $result = $this->user_model->get_by_id($user_id);
      $info = $this->getInfo(100,$result[0],"");
      echo json_encode($info);
    }

    /**
    * 修改用户信息
    */
    public function EditInfo(){
      $newNickName = $_POST['newNickName'];
      $newProfile = $_POST['newProfile'];
      $newHeadIcon = $_POST['newHeadIcon'];
      if(!isset($this->session->userdata['info'])){
        $info = $this->getInfo(-8,"you have not logged in","");
        echo json_encode($info);
        return ;
      }
      $user_id = $this->session->userdata['info'][0]['ID'];
      $affected = $this->user_model->EditInfo($user_id,$newNickName,$newProfile,$newHeadIcon);
      if($affected == 0){
          $info = $this->getInfo(-15,"edit fail","");
          echo json_encode($info);
      }else{
        $info = $this->getInfo(100,"edit successfully","");
        echo json_encode($info);
      }

    }
}

?>
