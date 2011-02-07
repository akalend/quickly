<!-- template=mynews.tpl -->
{{BEGIN page}}
<div style="padding-bottom: 35px;  border: doted 1 black; width:800px; float: left;">
<!-- {{dump( news)}} -->
{{BEGIN news}}

    <div style="{{UNLESS isPublish}} background-color: #e0e0e0;{{END}} margin-top: 10px; border: doted 1 blue; width:800px; float: left">
        <h2 style="padding-top:3px; font-size:12pt"><a href="#">{{title}}</a></h2>	
        
        <div style="font-family:Tahoma,Arial,Sans-serif; font-size:0.75em; ">{{text}}</div>
        {{IF haveImage}}<img src="/img/{{image}}" align="left">{{END}}
        
    <div style="margin-top: 3px; width:100px; float: left; background-color: silver;"><a href="/news/delete/{{id}}" title="удалять так же могут и модераторы">удалить</a></div>
    <div style="margin-top: 3px; margin-left: 8px; width:100px; float: left; background-color: silver;"><a href="/news/edit/{{id}}" title="редактировать так же могут и модераторы">редактировать</a></div>        
    <div style="margin-top: 3px; margin-left: 8px; width:100px; float: left; background-color: silver;"><a href="/news/activate/{{id}}" title="только модераторы">активировать</a></div>        
    <div style="margin-top: 3px; margin-left: 8px; width:100px; float: left; background-color: silver;"><a href="/news/hot/{{id}}" title="только модераторы">на главную</a></div>        
    </div>    

  {{END}}
</div>
{{END}}



