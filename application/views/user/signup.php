
    <label>输入注册邮箱</label><input type="text"></input>
    <label>密码</label><input type="password"></input>
    <label>重复密码</label><input type="password"></input>
    <label>拖动滑块完成验证</label>
    <button id="signup">点我注册</button>
    
<script src="http://cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $("#signup").click(function(event) {
        /* Act on the event */
        $.ajax({
            url:'api/signup',
            type:'post',
            data:{
                UserAccount:"1304272317@qq.com",
                password:"HelloWorld"
            },
            success:function(data){
                alert(data);
                data=JSON.parse(data);
                if(data['Flag'] == 100)
                    alert("我们已经给你发了一封邮件到你的邮箱里，查收完成注册");
                else if(data['Flag'] == -101)
                    alert("账号已存在");
                else 
                    alert("ERROR");
            }
        });
    });
</script>
