template=goods.tpl
{{BEGIN page}}
<div style="border: doted 1 black">

<h1>{{title}}</h1>
<br/>
{{BEGIN goods}}
<div style="padding-top:3px;">
	<h6>{{spec_name}}</h6>
	{{IF spec_description}}{{spec_description}}{{END}}
	
	{{BEGIN offers}}
		<div  style="font-size: -2;">{{title}} 
		<br><font color="Navy">{{good_price}}</font>руб</div><br>		
		{{IF description}}++<div style="color: blue; font-size: 8pt; font: italic;">{{description}}</div>{{end}}
	{{END }}
	
	</div>	
</div>
<hr size="1" width="100%">
{{END}}

{{END}}
</div>


