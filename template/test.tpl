<div>
<div style="color: blue; font-family: Arial; font-size: 12pt">context:{{context}}</blockquote></div>

dump context: {{dump(context)}}<br>

<!-- 

dump page: {{dump( page)}}<br> 
-->


{{BEGIN page}}
	<div>
		<b>{{name}}</b> {{IF years}}{{years}}{{END}}<br> 
		<b>{{city}}</b><br>
		{{IF interes}}interest:	{{interes}}{{END}}
	</div>
	
	
	{{IF access}}
	<div style="block: float;"><a href="http://{{server}}/user/edit/{{user_id}}">edit</a></div>
	{{END}}
	
	{{BottomBanner()}}
	
{{END}}
</div>

