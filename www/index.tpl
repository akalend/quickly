<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Welcome to Govnokod</title>
<script>
	<!--# include  virtual="$js" -->
</script>

</head>
<body>
<h5><a href='/'>Wellcome to Govnokod</a> (main)</h5>
<table width="940px" border="1">
	<tr style="height: 300px;">
		<td valign="top" style="width: 240px;">left banner<br>
<!--
		date:<!--# echo var="date_local" --><br>
		uri:<!--# echo var="uri"  default="no" --><br>
		request uri:<!--# echo var="request_uri"  default="no" --><br> 
		query_string:<!--# echo var="int"  default="no" --><br> 
	-->	
		request uri:<!--# echo var="request_uri"  default="no" --><br> 
		query_string:<!--# echo var="int"  default="no" --><br> 

		</td>
		<td valign="top">		
			<!--# include  virtual="$int?ssi=1" -->
		</td>
		<td valign="top" style="width: 240px;">html banner<br>
			<!--# include file="banner.tpl" -->
		</td>
	
	</tr>
</table>

</body>
</html>