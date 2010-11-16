<html>
<head>
<title>Welcome to Govnokod</title>
</head>
<body>
<h5>Wellcome to Govnokod</h5>
<table width="940px" border="1">
	<tr style="height: 300px;">
		<td valign="top" style="width: 240px;">left <br>

		date:<!--# echo var="date_local" --><br>
		uri:<!--# echo var="host"  default="no" --><br>
		uri:<!--# echo var="host"  default="no" --><br>
			<!--# include file="banner.tpl" -->

		</td>
		<td valign="top">
		
			<!--# include virtual="/test/12/" -->
		</td>
		<td valign="top" style="width: 240px;">right banner</td>
	
	</tr>
</table>

</body>
</html>