<script>
function openProgressBar() {
	return;
    /* generate random progress-id */
    uuid = "";
    for (i = 0; i < 32; i++) {
      uuid += Math.floor(Math.random() * 16).toString(16);
    }
    /* patch the form-action tag to include the progress-id */
    document.getElementById("upload").action="/upload.php?X-Progress-ID=" + uuid;

    /* call the progress-updater every 1000ms */
    interval = window.setInterval( function () {  fetch(uuid);  }, 1000 );
  }

  function fetch(uuid) {
    req = new XMLHttpRequest();
    req.open("GET", "/progress", 1);
    req.setRequestHeader("X-Progress-ID", uuid);
    req.onreadystatechange = function () {
    if (req.readyState == 4) {
      if (req.status == 200) {
        /* poor-man JSON parser */
        var upload = eval(req.responseText);

        document.getElementById('tp').innerHTML = upload.state;

        /* change the width if the inner progress-bar */
        if (upload.state == 'done' || upload.state == 'uploading') {
          bar = document.getElementById('progressbar');
          w = 400 * upload.received / upload.size;
          bar.style.width = w + 'px';
        }
        /* we are done, stop the interval */
        if (upload.state == 'done') {
          window.clearTimeout(interval);
        }
      }
    }
  }
  req.send(null);
}
</script>
<div>
{{BEGIN page}}
<div>
<form method="POST" action="/user/edit/{{user_id}}">

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

<div ><input type="submit"  value="save"> </div>
</form>
</div>

<form id="upload" enctype="multipart/form-data" 
  action="/upload" target="uploadframe" method="post" 
  onsubmit="openProgressBar(); return true;">
    <input type="hidden" name="MAX_FILE_SIZE" value="30000000"  />
    <input name="userfile" type="file" label="fileupload" />
    <input type="submit" value="Send File" />
  </form>
  <iframe id="uploadframe" name="uploadframe" 
  		width="0" height="0" frameborder="0" border="0" src="about:blank"></iframe>


<!--
<div style="block: float;">
	<img  src="/img/{{user_id}}.jpg"/>
</div>	
-->
{{END}}
