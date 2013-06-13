function emptyElement(x){
  _(x).innerHTML = "";
}
function login(){
  var usua = _("usuario").value;
  var clav = _("clave").value;
  if(usua == "" || clav == ""){
    _("status").innerHTML = "Usuario y clave son requeridos";
  } else {
    _("submitbtn").style.display = "none";
    _("status").innerHTML = '<br><img style="width: 160px; height:25px" src="images/loading.gif">';
          
    $.ajax({
      type: "POST",
      url: "index.php",
      data: {
        usu: usua,  
        cla: clav
      },
      dataType: "json",
      success: function(data){
        if(data.msg == "login_failed"){
          _("status").innerHTML = '<img src="images/warning.png" style="width:50px; height=50px;"> <span style="position:absolute; margin-top:15px;">Datos incorrectos.</span>';
          _("submitbtn").style.display = "block";
        }else{
          setTimeout(function(){
            $("#loginicon_not").hide(400);
            $("#loginicon_yes").show(600, function(){   
              window.location.href = 'inicio.php?usu=' + data.usu;
            });            
          }, 1500);
        }
      //alert("sucesso: "+data.msg);
      },
      error: function(data){
        console.log(data.msg);
      //alert ("error: "+error);
      }
    });
  }
}
