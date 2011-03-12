<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" media="screen" href="/css/ajaxfileupload.css" />
<script src="/js/lib/jquery.min.js" type="text/javascript" ></script>
<script src="/js/lib/jquery.form.js" type="text/javascript" ></script>
<script src="/js/lib/jquery.debug.js" type="text/javascript"></script>
<script src="/js/login.js" type="text/javascript"></script>
<script src="/js/<!--# echo var="$js"  default="no.js" --> " type="text/javascript"></script>


<title>24 часа Новостей о Товарах Финансах и Недвижимости на tfn24.ru</title>

</head>
<body>
<!--# include file="banner800x90.tpl" -->
<div>
    <div style="text-align: center; height : 90px; border : 1px dotted; width : 90px; float: left;">
        <h5><a href="/">Logo</a></h5>
    </div>
    <div style="height : 90px; border : 1px dotted; width : 190px; float: left;">
        <a href="">О проекте</a><br/>
        <a href="">О нас</a><br/>
    </div>
    <div style="height : 90px; border : 1px dotted; width : 350px; float: left;">
        <form action="/search/1" method="GET" >
            <input style="height: 20px; width: 300px;" name="key" type="text"  value="<!--# include  virtual="$b64" -->"> 
            <input type="hidden" name="ssi" value="1">
            <input type="submit" value=">>">
        </form>
        <br>
        <div style="text-align : right; wigth:100%; padding-right: 10px; "><a style="background: yellow" href="/newsadd">Подать объявление</a></div>
        
    </div>
        <!--# include virtual="/login" --> 
    
</div>
        <!--# include virtual="/newsmenu" --> 
<div>

<table width="1001px" border="1">

	<tr style="height: 300px;">
		<td valign="top">		

		<!--#include  virtual="$int" -->
		</td>
		<td valign="top" style="width: 240px;">html banner<br>
			<!--# include file="banner.tpl" -->
			<br>тут кнопочки
			<br>
			<!--# include file="anons.tpl" -->
			<!--# include file="reporters.tpl" -->
		</td>
	
	</tr>
</table>
</div>
rewrite uri:<!--# echo var="uri"  default="no" --><br>
int uri <!--# echo var="$int" -->
</body>
</html>