template=goods.tpl
{{BEGIN page}}
<div style="border: doted 1 black">

<h1>{{title}}</h1>
<br/>

{{BEGIN goods}}
<div style="padding-top:3px;">{{name}}</div>	
</div>
{{END}}

{{BEGIN pages}}
{{IF currentPage}}<span style="padding-top:3px; padding-left: 2px;  background-color: silver;">{{page}}</span>{{END}}	
{{UNLESS currentPage}}<span style="padding-top:3px; padding-left: 2px; background-color: white;"><a href="{{url}}">{{page}}</a></span>{{END}}	

{{END}}

{{END}}
</div>


