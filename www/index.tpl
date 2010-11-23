<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Welcome to Quckly project</title>
<script>
	<!--# include  virtual="$js" -->
</script>

</head>
<body>
<h5><a href='/'>Wellcome to Quckly project</a> (main)</h5>
<table width="940px" border="1">
	<tr style="height: 40px;">
		<td colspan="3">Some Header <br>
		  <div>
            <form action="/search/1" method="GET" >
                <input style="height: 20px; width: 300px;" name="key" type="text"  value="<!--# include  virtual="$b64" -->"> 
                <input type="hidden" name="ssi" value="1">
                <input type="submit" value="search">
            </form>
		  </div>
		   
			<div style="float: left; height: 40px; width: 200 px;"><a href="/catalog">catalog</a></div>
			<div style="float: left; height: 40px; width: 200 px;"><a href="/brands">no follow</a></div>
			<div style="float: left; height: 40px; width: 200 px;">xxx</div>
			<div style="float: left; height: 40px; width: 200 px;">yyy</div>
		</td>
	</tr>

	<tr style="height: 300px;">
		<td valign="top" style="width: 240px;">left banner<br>
<!--
		date:<!--# echo var="date_local" --><br>
		uri:<!--# echo var="uri"  default="no" --><br>
		
		query_string:<!--# echo var="int"  default="no" --><br> 
	
	    is args:<!--# echo var="is_args"  default="no" --><br>
		uri:<!--# echo var="uri"  default="no" --><br> 
	    request uri:<!--# echo var="request_uri"  default="no" --><br> 
		query_string:<!--# echo var="int"  default="no" --><br> 
-->	
		</td>
		<td valign="top">		
			<!--# include  virtual="$int" -->
		</td>
		<td valign="top" style="width: 240px;">html banner<br>
			<!--# include file="banner.tpl" -->
		</td>
	
	</tr>
</table>

</body>
</html>