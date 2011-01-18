{{BEGIN block}}
<div id="loginForm"  style="display:{{IF showLoginForm}}block{{END}}{{UNLESS showLoginForm}}none{{END}};height : 90px; border : 1px dotted; width : 190px; float: left;">
        <input id="loginInput" onfocus="clean(this)" style="height: 20px; width: 90px;" value="login" type="text"  value="">
        <span id="err_msg" style="color: red; display: none; float: right;">ошибка авторизации</span> <br>
        <input id="passwordInput" onfocus="clean(this)" style="height: 20px; width: 90px;" value="password" type="text"  value=""> 
        
        <input type="submit" onclick="logining()" value=">>"><br/>
        <input type="checkbox" name="memory" id="memory"> Запомнить
        <a href="/signup">Зарегистрироваться</a>
</div>    
<div id="logoutDiv" style="display:{{IF showLoginForm}}none{{END}}{{UNLESS showLoginForm}}block{{END}}; height : 90px; border : 1px dotted; width : 190px; float: left;"> Добрый день <span id="userNameSpan" style="color: blue">{{name}}</span>
    <br><a href="#" onclick="signout()">выйти</a><br/>
    <br><a href="/news/me/" >мои новости</a>
    <br><a href="/news/onlynew/"  title="только для администарторов">все новые</a>
</div>
{{END}}