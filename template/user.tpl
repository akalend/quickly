<div>
{{BEGIN page}}
<div>
	<b>{{name}}</b> {{IF years}}{{years}}{{END}}<br> 
	<b>{{city}}</b><br>
	{{IF interes}}interest:	{{interes}}{{END}}
</div>
	{{IF is_avatar}}
	<div style="block: float;">
		<img  src="/img/avatar/{{user_id}}.jpg"/>
	</div>	
	{{END}}


	{{IF access}}
	<div style="block: float;"><a href="http://{{server}}/user/edit/{{user_id}}">edit</a></div>
	{{END}}
{{END}}
</div>
