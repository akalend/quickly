<b>signup.tpl</b>

<div>
{{BEGIN page}}

{{IF ok}}

<form method="GET" action="/signup" >
<div >
    <div style="width: 630px;">
        <div style="float: left; width: 120px; ">login</div>
            <span><input type="text" name="login" value="{{login}}"> </span>
            {{IF error_login}}<span style="color: red">{{error_login}}</span>{{END}}
        </div>
        <div>
            <div style="float: left; width: 120px; ">password</div>
            <span><input type="text" name="psw" value="{{psw}}"> </span>
            {{IF error_psw}}<span style="color: red">{{error_psw}}</span>{{END}}
        </div>
        <div>
            <div style="float: left; width: 120px; ">password</div>
            <span><input type="text" name="psw2" value="{{psw2}}"> </span>
            {{IF error_psw2}}<span style="color: red">{{error_psw2}}</span>{{END}}
        </div>
        <div>
            <div style="float: left; width: 120px; ">email</div>
            <span><input type="text" name="email" value="{{email}}"> </span>
            {{IF error_email}}<span style="color: red">{{error_email}}</span>{{END}}
        </div>
    </div>

    <div ><input type="submit"  value="register"> </div>
   </div> 
</form>
{{END ok}}
{{UNLESS ok}}
    на указанный Вами email выслан код подтверждения<br>
    
    ******************<br>
    {{mail}}    
{{END ok}}

{{END}}
</div>

{{BEGIN mail}}<pre>
<div style="color: blue;">example email:</div>
Dear User,
For activate your accaunt You must walk to link : <a href="http://{{server}}/activate/{{code}}">http://{{server}}/activate/{{code}}</a>
Your  login <span style="color: blue">{{login}}</span>
Your password <span style="color: blue">{{psw}}</span>
the link will active one day/24 h 
</pre>
{{end}}

