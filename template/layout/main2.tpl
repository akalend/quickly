<html>
<head>
 <title>layout 2 {{title}}</title>
<script  src="/js/lib/jquery.fs.js"></script>
{{BEGIN js}}
<script  src="/js/{{src}}"></script>
<script>
 window.onload = function(){   	
 	{{run}}
 	var content = $('#content');
	var ch = content.children;	
  }
 </script>
{{END}}

</head>
<body bgcolor="white" text="black">
<center><h1><a href="/">Welcome to Govnokod! </a> layout 2</h1></center>

{{BEGIN login}}{{login}}{{END}}


<table>
<tr>
<td width="600px">
{{BEGIN page}}
<div style="width: 100%">
{{page}}
</div>
{{END page}}
</td>
<td width="200px" height="200px" style="border: 1px solid; " valign="top" >
Здесь банер или иной блок<br>зависящий от URI (leftBanner)
{{ leftBanner }}</td>
</tr>
</table>


---start HTML block ---
{{html}}
---end HTML block ---


{{BEGIN mail}}{{mail}}{{END}}


{{BEGIN db}}

<div style="width:100%;  color: blue; padding-top: 20px;"">
{{sql}} <br>
time={{time}} sec
</div>
{{END db}}

</body>
</html>
