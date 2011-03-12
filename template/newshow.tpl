<div>
<div style="color: blue; font-family: Arial; font-size: 12pt">context:{{context}}</blockquote></div>

{{BEGIN page}}

<h2>{{title}}</h2>
<div style="width: 900px;">
{{if haveImage}}<img src="/img/{{img}}" align="left"/>{{end}}
{{text}}</div>

<div style="width: 900px;">
<div >****</div>
<div style="font-size: 8pt;">{{tags}}</div>
</div>        
<h6>comments</h6>
<div id="comments">

{{BEGIN comments}}<div style="padding-top: 10px;">
<div>{{text}}</div>
<div>
    <div style="color: silver; block: left">{{date}}</div><div style="color: blue; block: left">{{user_name}}</div>
</div>
</div>
{{END}}
 


{{IF isLogining}}<form action="/ajax/addcomment/{{id}}" method="GET">
<textarea cols="40" rows="5" name="comment"></textarea><br/>
<input type="submit" value="Отправить" /><input type="hidden" name="user_id" value="{{user_id}}" />
<input type="hidden" name="news_id" value="{{id}}" />
</form>
{{END}}
</div>    

{{END}}
</div>
<script>

</script>
