<html>
<head>
<title>Welcome to quickly</title>
</head>
<body>
<h5>Wellcome to quickly (caching block test)</h5>
query_string:<!--# echo var="int"  default="no" --><br> 
request uri:<!--# echo var="request_uri"  default="no" --><br> 
<table width="940px" border="1">
	<tr style="height: 300px;">
		<td valign="top" style="width: 240px;">left block
		<!--#include virtual="/mc" -->
		</td>
		content
		<td valign="top">content block<br>
		<!--#include virtual="/content/$int" -->
		</td>
		
	
	</tr>
	</tr>
</table>

</body>
</html>