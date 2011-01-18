<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" type="text/css" media="screen" href="/css/jquery.rating.css" />
<script src="/js/lib/jquery.min.js" type="text/javascript" ></script>
<script src="/js/lib/jquery.debug.js" type="text/javascript"></script>
<script src="/js/lib/jquery.rating.pack.js" type="text/javascript"></script>

<script src="/js/login.js" type="text/javascript"></script>


<title>24 часа Новостей о Товарах Финансах и Недвижимости на tfn24.ru</title>

</head>
<body>
<div style="height : 90px; width=100%;  border : 1px dotted;">баннер растяжка<br>
будет включен как HTML/js 
</div>
content.tpl
<div>
    <div style="text-align: center; height : 90px; border : 1px dotted; width : 90px; float: left;">
        <h5><a href="/">Logo</a></h5>
    </div>
    <div style="height : 90px; border : 1px dotted; width : 190px; float: left;">
        <a href="">О проекте</a><br/>
        <a href="">О нас</a><br/>
        <a href="">Правила подачи новостей</a><br/>
    </div>
    <div style="height : 90px; border : 1px dotted; width : 350px; float: left;">
        <form action="/search/1" method="GET" >
            <input style="height: 20px; width: 300px;" name="key" type="text" > 
            <input type="hidden" name="ssi" value="1">
            <input type="submit" value=">>">
        </form>
        <br>
        <div style="text-align : right; wigth:100%; padding-right: 10px; "><a style="background: yellow" href="/newsadd">Поделиться новостью</a></div>
        
    </div>
{{login}}     
</div>
<div style="block: none; padding-top: 100px; height: 30px;">
{{menu}}
</div>
<div>

<table width="1001px" border="1">

	<tr style="height: 300px;">
		<td valign="top">		
		{{BEGIN page}}
		{{page}}
		{{END page}}	
		</td>
		<td valign="top" style="width: 240px;">html banner block<br>
			{{LeftBanner}}
		</td>
	
	</tr>
</table>
</div>

</body>
</html>
