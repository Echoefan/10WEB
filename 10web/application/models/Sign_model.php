
<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Sign_model extends CI_Model{
	public function __construct(){
		$this->load->database();
		$this->load->model('Archives_model');
		$id=0;
	}
	
	//增
	public function add($tablename,$data){
		$this->db->insert($tablename,$data);
	}
	//删
	public function delete($tablename,$key){
		$this->db->delete($tablename,$key);
	}
	//查
	public function select($selectsql){
		$query = $this->db->query($selectsql);
		return $query;
	}
	//改
	public function update($tablename,$data,$updatepair){
		$this->db->update($tablename,$data,$updatepair);
	}
	/**
	*	根据账号返回用户信息作为session
	*	@param Account varchar(40)
	*/
	public function GetUserInfo($account){
		$sql = "SELECT * FROM e0_user WHERE Account = ".$this->db->escape($account);
		return $this->db->query($sql)->result_array();
	}
	/**
	*  检查账号：传入账号，返回数据库中是否已经存在该账号
	*
	*	@param account varcahr(40) 
	*	@return true->账号已经存在， false->账号不存在
	*/
	public function AccountExist($account=0){
		$query = $this->db->get_where("e0_user",array("Account" => $account));
		//数据库中有记录表示该账号已经存在
		if($query->num_rows()){
			return true;
		}
		else{
			return false;
		}
	}
	/**
	*	添加文档：传入账号邮箱，在数据库中插入信息
	*	 @param account varchar(40)
	*	 @param password varchar(20)
	*/
	public function InsertAccount($account,$password,$nickname){
		$signuptime=date("Y-m-d H:i:s");//注册时间，放到profile中去
		//$id = md5($signuptime);
		$id = uniqid();
		$icon = '/assets/i/default_head_icon/'.['uh_1.gif','uh_2.gif','uh_3.gif','uh_4.gif','uh_5.gif','uh_6.gif','uh_7.gif','uh_8.gif','uh_9.gif'][rand(0,8)];
		$data = array(
			'id' => $id,
			'account' => $account,
			'password' => md5($password),
			'profile' => json_encode(array(
				// "signuptime" => $signuptime,
				// "nickname" => $nickname
			)),
			'logintime' => $signuptime,
			'permission' => 0,
			'nickname' => $nickname,
			'signuptime' => $signuptime,
			'headicon' => $icon
		);
		$this->db->insert('e0_user',$data);
	}
	/**
	*	检查文档：登陆时查找数据库中是否有该账号和密码，以及检查该账号是否可用
	*	Permission: 0->未激活，1->激活， 2->账号被封，	３->管理员
	*	@param account varchar(40)
	*	@param password varchar(20)
	*	@return 1->未激活，2->激活， 3->账号被封， 4->密码错误， 5->账号不存在
	*/
	public function CheckAccount($account,$password){	
		$password = md5($password);
		//账号存在,检查密码是否正确
		$query = $this->db->query("select * from e0_user where Account = '$account' ");
		//echo $query->num_rows();
		if($query->num_rows() <> 0){
			//有该账号，检查密码是否正确
			foreach($query->result() as $row){
				//密码正确
				if($row->Password === $password){
					//检查该账号状态
					if($row->Permission === "0"){
						return 1;//未激活
					}
					else if($row->Permission === "1"|| $row->Permission === "3"){
						return 2;//激活状态
					}
					else if($row->Permission === "2"){
						return 3;//账号被封
					}
				}
			}
			return 4;//密码不正确
		}
		//账号不存在
		else{
			return 5;
		}
	}
	/**
	*	检查账号是否已激活文档
	*	@param account varchar(40)
	*	@return 已激活返回1，未激活先激活然后返回0
	*/
	public function CheckActivate($account=0){
		$query = $this->db->get_where('e0_user',array("Account" => $account));
		//检查是否已经被激活
		//如果之前未激活先激活再返回
		$row = $query->row();
		if($row->Permission === "0"){
			$this->db->update('e0_user',array("Permission" => "1"),array("Account" => $account));
			return 0;//
		}
		else{
			return 1;//已激活
		}
	}

	
}
	
?>
