<div>
{{BEGIN page}}
<div>
<form method="POST"   enctype="multipart/form-data" action="/user/edit/{{user_id}}">

<div >
<div style="width: 420px;">
<div style="float: left; width: 120px; ">name</div>
<span><input type="text" name="name" value="{{name}}"> </span>
{{IF error_name}}<span style="color: red">{{error_name}}</span>{{END}}
</div>

<div style="width: 420px;">
<div style="float: left; width: 120px; ">birthday</div>
<span>&nbsp;{{birthdate}}</span>
</div>


<div>
<div style="float: left; width: 120px; ">city</div>
<span><input type="text" name="city" value="{{city}}"> </span>
{{IF error_city}}<span style="color: red">{{error_city}}</span>{{END}}
</div>


<div style="float: left; width: 120px; ">interes</div>
<span><input type="text" name="interes" value="{{interes}}"> </span>
</div>




<div style=" width: 120px; ">
{{IF is_avatar}}
<img src="http://{{server}}/img/avatar/{{avatar}}" ></div>
<input type="hidden" name="is_avatar" value="1">
{{END}}
<div style=" width: 120px; ">change avatar</div>
   <span> <input name="avatar" type="file" label="fileupload" /></span>
{{IF error_avatar}}<span style="color: red">{{error_avatar}}</span>{{END}}

<div ><input type="submit"  value="save"> </div>
</form>
</div>
{{END}}
</div>