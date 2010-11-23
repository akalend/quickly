template=search.tpl
{{BEGIN page}}
<div style="border: doted 1 black">

<h1>{{title}}</h1>
<br/>

<div style="color: blue;">всего найдено {{founded}}</div>
{{BEGIN goods}}
<div style="padding-top:3px;">{{name}}  <span style="color: blue; padding-right: 10px;">{{class}}</span> </div>	
{{END}}

{{BEGIN pages}}
{{IF currentPage}}<span style="padding-top:3px; padding-left: 2px;  background-color: silver;">{{page}}</span>{{END}}	
{{UNLESS currentPage}}<span style="padding-top:3px; padding-left: 2px; background-color: white;"><a href="{{url}}">{{page}}</a></span>{{END}}	

{{END}}

{{END}}
</div>


