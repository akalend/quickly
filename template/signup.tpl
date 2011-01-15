<style>
table tr td {
	vertical-align: top;
	padding: 10px;
}
div.error {
	font-size: 80%;
	font-weight: bold;
	color: red;
}
</style>

<b>signup.tpl</b>

<div>
{{BEGIN page}}

{{IF ok}}

<form method="POST" >
<table cellpadding="0" cellspacing="0" border="1">
	<tr>
		<td>email</td><td>
			<input type="text" name="email" value="{{email}}">
			{{IF error_email}}<div class="error">{{error_email}}</div>{{END}}
		</td>
	</tr>
	<tr>
		<td>Пароль</td><td>
			<input type="text" name="psw" value="{{psw}}">
			{{IF error_psw}}<div class="error">{{error_psw}}</div>{{END}}
		</td>
	</tr>
	<tr>
		<td>Подтверждение пароля</td><td>
			<input type="text" name="psw2" value="{{psw2}}">
			{{IF error_psw2}}<div class="error">{{error_psw2}}</div>{{END}}
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			{{$captcha}}
			{{IF error_captcha}}<div class="error">{{error_captcha}}</div>{{END}}
		</td>
	</tr>
</table>

<div ><input type="submit"  value="register"> </div>

</form>


{{END ok}}

{{UNLESS ok}}
    на указанный Вами email выслан код подтверждения<br>
    
    ******************<br>
    {{mail}}    
{{END ok}}

{{END}}
</div>
