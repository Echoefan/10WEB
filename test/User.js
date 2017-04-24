/**
 * 用于创建一个已经登陆的用户
 */
var md5 = require('md5');
var request = require('request');
var util = require('util');


//配置信息
var config = {
    remote:true//是否检测远程接口
};

/**
 * 获取路径
 * 
 * @param {string} path 路径
 */
var getUrl = function(path){
    var host = 'www.jyonline.cc';
    if(!config.remote)
        host = 'localhost';
    return util.format('http://%s:6070%s',host,path);
}

/**
 * 构造函数
 * 
 * @param {object} param0 接受用户账号和密码
 * @param {*} option 是否远程调试的选项等
 */
var User = function({account,password},option){
    this.option = option;
    config = option
    var jar = request.jar();
    this.request = request.defaults({jar:jar});
    //保存done的回调函数
    this._callback = [];
    this.login_state = false;
    this.login({account,password});
}

User.fn = User.prototype;

/**
 * 登陆成功之后调用的函数
 * 
 * @param {function} fn 调用函数
 */
User.fn.done = function(fn){
    if(this.login_state){
        return fn(null,this.request);
    }
    if(typeof fn !== 'function')
        throw Error("done 参数错误");
    this._callback.push(fn);
}

/**
 * 登陆成功后调用改函数
 */
User.fn.fire = function(){
    var _callback = this._callback;
    for(var i in _callback){
        _callback[i](arguments[0],arguments[1]);
    }
}

/**
 * 用于用户的登陆
 * 
 * @param {object} 用户的信息
 */
User.fn.login = function({account,password}){
    var self = this;
    this.request.post(getUrl('/index.php/api/user/Signin'),function(err,req,body){
        //传递request参数
        try{
            console.log(body);
            body = JSON.parse(body);
        }catch(e){
            return self.fire("登陆失败"+e);
        }
        self.login_state = true;
        self.fire(err,request);
    }).form({
        Account:account,
        Password:password
    });
}

/**
 * 根据seesion获取和用户聊天的用户列表
 * 
 * @param {function} cb 回调函数
 */
User.fn.getMsgUser = function(cb){
    this.done(function(err,request){
        request(getUrl('/index.php/api/message/getcommunicatedusers'),function(err,req,body){
            cb(err,body,request);
        });
    });
}

/**
 * 获取与某一个用户的聊天的详细内容
 */
User.fn.getMsg = function(cb){
    this.getMsgUser(function(err,body,request){
        body = JSON.parse(body);
        if(body.Content.length == 0)
            cb(err,null);
        var url = getUrl('/index.php/api/message/GetMessage');
        var relater = body.Content[0].Relater;
        request.post(url,function(err,req,body){
            cb(err,body);
        }).form({
            MesUserID:relater
        });
    });
}

/**
 * 获取与用户有关的文章
 * @
 */


exports = module.exports = User;