{{BEGIN login}}<div style="">
{{IF error}}
<div style="color: red; font: bold" >input error</div>
{{end if}}
<form action="/signin"  method="POST" >
<div style="" ><div  style="float: left; width: 60px;" >name</div><div style="float: left;" ><input name="login" type="text" value="{{login}}" /> </div> <div style="float: left;" ><input type="submit" value=">>" /> </div> </div>
<div style="padding-top: 25px; "><div style="float: left; width: 60px;">password</div><div style="float: left;"><input type="text" value="{{psw}}" name="psw" /> </div>  <a href="/signup">registration</a> </div>
</form>
</div>
{{END}}

{{BEGIN page}}
<div id="content" style="padding-top: 15px; width: 75%;">
{{BEGIN item}}
<a href="/user/{{user_id}}"  style="background-image: url( img/48/{{user_id}}.jpg); height:48px; width:48px; float: right;" > </a>
<!-- img src="img/{{user_id}}.jpg" -->
{{END}}
</div>
{{END}}