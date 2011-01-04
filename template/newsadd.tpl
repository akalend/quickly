<div>
<div style="color: blue; font-family: Arial; font-size: 12pt">context:{{context}}</blockquote></div>
{{BEGIN page}}
{{IF isLogining}}
<script src="js/lib/ajaxfileupload.js" type="text/javascript"></script>

    <form  id="myForm" action="/test"  method="POST">
        <div style="width: 600px;  border: doted 1 black;"><span style="width: 300px;">наименование</span>
        <input type="text" value="{{title}}" style="width: 400px;" name="title"></div>
        <input type="hidden" value="{{id}}" style="width: 400px;" name="id">
        <div style="width: 600px;  border: doted 1 black;"><span style="width: 300px;">категория</span>
            <select name="newsCategory">
        <option value="0" >-------</option>
        {{BEGIN category}}
            <option value="{{id}}" >{{title}}</option>
        {{END category}}    
        </select></div>
        
        <textarea name="text" rows="20" style="width: 600px;">{{text}}</textarea>

        
        <div style="width: 600px;  border: solid 1px red;">
            <div style="width: 600px;  border: doted 1 black;"><span style="width: 300px;">опубликовать</span> <input type="radio" value="1" name="title"> 
                <div style="color: red; float: right;">админский интерфейс</div></div>
            <div style="width: 600px;  border: doted 1 black;"><span style="width: 300px;"></span>в мусорку</span> <input type="radio" value="0" name="title"></div>
        </div>
        
        <div style="width: 600px;"><input type="submit" value="Save"></div>
    </form>

    
    {{IF picture}}
    <div style="padding-top:15px; width: 600px;"><span style="">загрузить картинку</span>
        <form name="form" action="" method="POST" enctype="multipart/form-data">
        <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">
        <button class="button" id="buttonUpload" onclick="return ajaxFileUpload();">Upload</button>       
        </form>
   {{END picture}} 
    </div>  
    убрал пока
    
<script>

var options = {
	  url: "/ajax/newsadd",
 	  beforeSubmit:  showRequest,	 
	  success: function() {
	       
	        alert("Спасибо за добавление новости\nсейчас произойдет перенаправление в Ваш раздел.");
	        document.location.href='/news/me/'
	  }
	};

$(document).ready(function() { 
     $('#myForm').ajaxForm(options); 
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
				url:'/upload', 
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
    </div>	
{{END}}   

{{END}}
</div>

