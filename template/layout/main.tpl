<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>{{title}}</title>
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

{{BEGIN login}}{{login}}{{END}}

{{BEGIN page}}


<table>
<tr>
<td width="600px">
<div style="width: 100%">
{{page}}
</div>
</td>
<td width="200px" height="200px" style="border: 1px solid; " valign="top" >
 место под баннер и прочие блоки
</td>
</tr>
</table>

{{END page}}

{{BEGIN mail}}{{mail}}{{END}}

{{BEGIN db}}

<div style="width:100%;  color: blue; padding-top: 20px;"">
{{sql}} <br>
    time={{time}} sec
</div>
{{END db}}

</body>
</html>
