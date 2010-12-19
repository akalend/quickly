function logining() {
    var login = $("#loginInput").val();
    var password = $("#passwordInput").val();
    
    var memory = $("#memory").attr('checked');
    if (password == 'password' && login == 'login')
        return;
        
    $.post('/ajax/signin/', 'login='+login+'&password='+password+'&mem='+memory, 
         function(ob) {
             var div = $("#loginForm");
             var errdiv = $("#err_msg");
             var span = $("#userNameSpan");
             if (ob.error) {
                 errdiv.show();
             }
             $.log(ob);
             if (ob.user) {
                 div.hide(); 
                 //document.location.href="http://localhost/";
                 span.html(ob.user.name);
                 var div2 = $("#logoutDiv");
                 div2.show();
             }
             
    }, 'json');
};

function signout() {
         var div = $("#loginForm");
         div.show();
         var div2 = $("#logoutDiv");
         div2.hide();
    
         $.getJSON('/ajax/signout/', null, function(ob) {             
         });

}

function clean(ob) {
    ob.value='';    
    var errdiv = $("#err_msg");
    errdiv.hide();
}

jQuery(document).ready(function(){
/*    $.getJSON('/ajax/signin/', null, 
         function(ob) {
             var div = $("#loginForm");
             
             if (ob.user) {
                 div.html('Дорый день <b>'+ob.user.name+'</b>');
             }

         });
*/         
     //    $.("loginBtn").click='login';
});
