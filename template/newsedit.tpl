<div>
<div style="color: blue; font-family: Arial; font-size: 12pt">context:{{context}}</blockquote></div>

{{BEGIN page}}

{{IF isLogining}}
<script src="/js/lib/ajaxfileupload.js" type="text/javascript"></script>

    <form  id="myForm" action="/news/edit/{{id}}"  method="POST">
        <div style="width: 600px;  border: doted 1 black;"><span style="width: 300px;">наименование</span>
        <input type="text" value="{{title}}" style="width: 400px;" name="title"> {{IF error_title}}<span style="color: red">не пустое</span>{{END}} </div>
        <input type="hidden" value="{{id}}" style="width: 400px;" name="id">
        <div style="width: 600px;  border: doted 1 black;"><span style="width: 300px;">категория</span>
            <select name="newsCategory">
        <option value="0" >-------</option>
        {{BEGIN category}}
            <option value="{{id}}" {{IF selected}}selected{{END}} >{{title}}</option>
        {{END category}}    
        </select></div>
 
        

        регион ....
        <input type="text" name="search" id="input-search" style="position: absolute;  left: 150px" autocomplete="off"/>
        <ul id="request-log"></ul>
        
        
        {{IF error_text}}<div style="color: red">не пустое</div>{{END}}        
        <textarea name="text" rows="20" style="width: 600px;">{{text}}</textarea>

                
        <div style="width: 600px;"><input type="submit" value="Save"></div>
    </form>

    

    <div style="padding-top:15px; width: 600px;"><span style="">загрузить картинку</span>
        <form name="form" action="" method="POST" enctype="multipart/form-data">
        <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
         <input type="hidden" name="id" id="newsId" value="{{id}}" />
        <button class="button" id="buttonUpload" onclick="return ajaxFileUpload();">Upload</button>
        </form>
        
        <img  style="display: {{if haveImage}}block{{end}}{{unless haveImage}}none{{end}};" id="newsImg" src="/img/{{img}}"/>
        
    </div>  

<script>

autocomplete.sendrequest = function ()
{
//	$("#request-log").append ("<li>send request; query = "+autocomplete.last_request+"</li>");
    var cityes = new Array();
    $.post('/cityes', autocomplete.last_request, 
        function(ob) {
           var i;
           $.log(ob.cityes);
           for( city in ob.cityes) {
               //cityes[i] = ob.cityes[i].name;
               $.log(ob.cityes[city].name);
               cityes[city] = ob.cityes[city].name;
           };                      
    }, 'json');
 
	return cityes;
}

$(document).ready ( function () {
	autocomplete.init("#input-search");
});




function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 
 
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 
 
    //$.log('About to submit: \n\n' + queryString); 
 
    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 

function ajaxFileUpload()
	{
		//starting setting some animation when the ajax starts and completes		
		$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
		
		$.ajaxFileUpload
		(
			{
				url:'/upload?id={{id}}', 
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
						    alert(data.msg);
						}
					} else {
					  $("#newsImg").attr('src','/img/0.gif');  
					    
					  $("#newsImg").attr('src','/img/'+data.url);
					  $("#newsImg").css('display','block');
					  //$.log($("#newsImg").attr('src'));
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		
		return false;
	}  
</script>
    
{{END}}   

{{UNLESS isLogining}}
	<div>Ве не можете подать новость,<br>
	 Вы должны залогиниться или зарегистрироваться
	 
	 сюда форму логина!!!<br>
    <form action="/signin">
	 <div style="width: 160px;">
	   <div style="width: 60px; float: left">логин</div><div style="width: 100px; float: left">
	       <input type="text" name="login" style="width: 100px;"></div>
	   <div style="width: 60px; float: left">пароль</div>
	           <div style="width: 100px; float: left"><input style="width: 100px; float: left" type="text" name="password"></div>
	    <div><input style="align: center; width: 25px; float: left; font: 6pt Verdanta;" type="submit" value=">>" /></div>
	   
	 </div>
    </form>    
    </div>	
{{END}}   

{{END}}
</div>
