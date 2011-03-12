<!-- template=hotnews.tpl -->
{{BEGIN page}}
<div style="padding-bottom: 35px;  border: doted 1 black; width:800px; float: left;">
{{BEGIN news}}

<script>
jQuery(document).ready(function(){
    $('.star{{part}}_{{id}}').rating({
        click: function(value, link){
            alert(value);
        }
     });
});
</script>

    <div style="border: doted 1 blue; width:400px; height:260px; float: left;">
    <h2 style="padding-top:3px; font-size:12pt"><a href="/news/{{id}}">{{title}}</a></h2>	
    <img src="img/{{image}}" align="left">
    <div style="font-family:Tahoma,Arial,Sans-serif; font-size:0.75em;">{{text}}</div>

    <input name="star{{part}}_{{id}}" type="radio" value="1" class="star"/>
    <input name="star{{part}}_{{id}}" type="radio" value="2" class="star"/>
    <input name="star{{part}}_{{id}}" type="radio" value="3" class="star"/>
    <input name="star{{part}}_{{id}}" type="radio" value="4" class="star"/>
    <input name="star{{part}}_{{id}}" type="radio" value="5" class="star"/>
    <span id="#hover-test{{part}}_{{id}}"></span>
    </div>
{{END}}
</div>
{{END}}



