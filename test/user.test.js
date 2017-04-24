/**
 * 用户部分模块测试
 */

var request = require('request');
var chai = require('chai');
var User = require('./User');
var util = require('util');
var EventProxy = require('eventproxy');

var user = new User({account:'384113872@qq.com',password:'mxd6980k9'},{remote:false});
describe('用户部分模块测试',function(){
    it('注册api',function(done){
        done();
    });

        
    it('登陆的api',function(done){
        user.done(function(err){
            if(err){
                console.error(err);
                throw Error('登陆失败');
            }   
            done();
        });
    });

    // it('获取相互发过消息的用户API',function(done){
    //     user.getMsgUser(function(err,body){
    //         if(err)
    //             throw Error(err);
    //         done();
    //     });
    // });

    // it('获取与某用户的聊天信息API',function(done){
    //     user.getMsg(function(err,body){
    //         if(err)
    //             throw Error(err);
    //         body = JSON.parse(body);
    //         done();
    //     });
    // });


    // it('获取与用户有关的文章API',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/user/GetUserArchives',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         }).form({Type:0})
    //     }) 
    // });

    // it('获取session api',function(done){
    //     user.done(function(err,request){
    //         request('http://localhost:6070/index.php/api/user/GetSession',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         })
    //     })
    // });

    // it('根据session获取当前用户的个人信息',function(done){
    //     user.done(function(err,request){
    //         request('http://localhost:6070/index.php/api/user/GetUserInfoBySession',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             //console.log(body);
    //             done();
    //         })
    //     })
    // });

    // it('根据UserID获取某一个用户的基本信息',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/user/GetUserBaseInfo',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         }).form({UserID:'540857906f006fa05d54'})
    //     })
    // });

    // it('添加文章API',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/archive/add',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         }).form({Title:'test100',Source:'LALAALALA'})
    //     })
    // });

    // it('删除文章API',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/Archive/del',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         }).form({Title:'test100',ID:'d2709a000015af87870a'})
    //     })
    // });

    // it('编辑文章API',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/Archive/edit',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //                 console.log(body);
    //             done();
    //         }).form({ID:'2b83a2e538feb64c5441',OldTitle:'程序员逼格提升完全指南',OldSource:'',OldRedirectUrl:'',OldLitPic:'',NewTitle:'程序员逼格提升'})
    //     })
    // });

    // it('查找文章API',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/Archive/find',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             console.log(body);
    //             done();
    //         }).form({ID:'0057e6228c02fde4c2a5'})
    //     })
    // });
    // it('根据用户id获取用户的所有发布的文章',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/archive/findUserPubArc',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             //console.log(body);
    //             done();
    //         }).form({UserID:'540857906f006fa05d54'})
    //     })
    // });

    // it('获取推荐的文章列表',function(done){
    //     user.done(function(err,request){
    //         request('http://localhost:6070/index.php/api/archive/getComArc/0',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         })
    //     })
    // });
    
    // it('根据字符串搜索文章列表',function(done){
    //     user.done(function(err,request){
    //         request.post('http://localhost:6070/index.php/api/archive/search',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             done();
    //         }).form({keyword:'程序员'})
    //     })
    // });

    // it('获取我的所有的文章（session）',function(done){
    //     user.done(function(err,request){
    //         request('http://localhost:6070/index.php/api/archive/findMyArc',function(err,req,body){
    //             if(err)
    //                 throw Error(err);
    //             // console.log(body);
    //             done();
    //         })
    //     })

    // });


    it('测试上传至qiniu的api',function(done){
        user.done(function(err,request){
            //console.log(request);
            request('http://localhost:6070/index.php/api/uploadtest/upload',function(err,req,body){
                if(err)
                    throw Error(err);
                console.log(body);
                done();
            })
        })
    });

});

