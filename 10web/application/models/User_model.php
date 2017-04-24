<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	/**
     *　根据传入的用户id返回用户的个人信息(不包括密码)
     *
     * @param $user_id
	 */
	public function get_by_id($user_id = null){
		if(!$user_id)
			throw new Exception("函数缺少参数：用户id");
		$sql_format = <<<STR
		SELECT
		ID,Account,Profile,Permission,TokenID,LoginTime,LoginIP,HeadIcon,NickName,SignupTime
		FROM e0_user
		WHERE ID = '%s'
STR;
		$sql = sprintf($sql_format,$user_id);
		return $this->db->query($sql)->result_array();
	}

	/**
	*	传入日期获取那天注册的用户数目
	*	@param $signup_time 注册日期
	*	@return 注册人数
	*/
	public function get_number_of_user($signup_time = null){
		$sql_format = <<<STR
		SELECT
		Account
		FROM e0_user
		WHERE SignupTime LIKE '%s%s'
STR;
		$sql = "SELECT Account FROM e0_user";
		if(isset($signup_time)){
			$sql = sprintf($sql_format,$signup_time,'%');
			return $this->db->query($sql)->num_rows();
		}
		return $this->db->query($sql)->num_rows();
	}

	/**
	*	修改用户信息
	*	@param newNickName   新昵称
	*	@param newProfile	新简介
	*	@param newHeadIcon	新头像
	*/
	public function EditInfo($userID=null,$newNickName=null,$newProfile=null,$newHeadIcon=null){
		$sql1_format = <<<STR
		SELECT *
		FROM e0_user
		WHERE ID = '%s'
STR;
		$sql1 = sprintf($sql1_format,$userID);
		$oldInfo = $this->db->query($sql1);
		$oldNickName = null;
		$oldProfile = null;
		$oldHeadIcon = null;
		foreach ($oldInfo->result() as $row) {
			$oldNickName = $row->NickName;
			$oldProfile = $row->Profile;
			$oldHeadIcon = $row->HeadIcon;
		}
		if($newNickName == null){
			$newNickName = $oldNickName;
		}
		if($newProfile == null){
			$newProfile = $oldProfile;
		}
		if($newHeadIcon == null){
			$newHeadIcon = $oldHeadIcon;
		}
		$sql_format = <<<STR
		UPDATE e0_user
		SET NickName = '%s',
			Profile =  '%s',
			HeadIcon = '%s'
		WHERE ID = '%s' 
STR;
		$sql = sprintf($sql_format,$newNickName,$newProfile,$newHeadIcon,$userID);
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
}
?>
