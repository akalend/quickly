<!-- template=catalog.tpl -->
{{BEGIN page}}
<div style="border: doted 1 black">

{{IF title}}<h1>{{title}}</h1>{{END}}
<br/>
{{BEGIN row2}}
<a href="{{URL}}/{{ if($h2_id ,'goods', 'catalog')}}/{{innername}}" >{{fullname}}</a><br>
{{END}}
{{IF item}}<h1>Каталог</h1>{{END}}
{{BEGIN item}}
<div style="padding-top:10px;">
<a href="{{URL}}/catalog/{{root.innername}}" >{{root.fullname}}</a><br>

{{BEGIN child}}
<div style="padding-left:10px;">
<a href="{{URL}}/catalog/{{item.innername}}" >{{item.fullname}}</a><br>
</div>	
{{END}}
</div>
{{END}}

{{BEGIN row}}
{{IF count}}<a href="{{URL}}/goods/{{shortname}}" >{{name}}</a>({{count}})<br>{{END}}
{{END}}
{{END}}
</div>


