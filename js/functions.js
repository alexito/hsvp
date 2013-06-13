var sie10 = null;



function autocompletePaciente(){
  var pacientes = new Array();
  var ajax = ajaxObj("POST", "tramite_uni.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {      
      var temp;
      var resp = ajax.responseText;
      resp = resp.split('-');
      for(var i = 0; i <resp.length; i++){
        temp = resp[i].split(',');
        pacientes[i] = {
          value: String(temp[0]),  
          data: String(temp[1])
        };
      }
      $('#paciente-auto').autocomplete({
        lookup: pacientes,
        width: 500,
        autoSelectFirst: true,
        onSelect: loadPaciente
      });
    }
  }
  ajax.send("autopac=true");
}

function autocompleteServicio(){
  var pacientes = new Array();
  var ajax = ajaxObj("POST", "tramite_uni.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {      
      var temp;
      var resp = ajax.responseText;
      resp = resp.split('-');
      for(var i = 0; i <resp.length; i++){
        temp = resp[i].split(',');
        pacientes[i] = {
          value: String(temp[0]),  
          data: String(temp[1])
        };
      }
      $('#servicio-auto').autocomplete({
        lookup: pacientes,
        width: 500,
        autoSelectFirst: true,
        //onSelect: loadServicio
        onSelect: function(res){
          $('#cod_servicio').val(res.data);
        }
      });
    }
  }
  ajax.send("autoserv=true");
}


function loadServicio(suggestion){

  var ajax = ajaxObj("POST", "tramite_uni.php");
  ajax.onreadystatechange = function(){
    if(ajaxReturn(ajax) == true) {      
      var resp = ajax.responseText;
      resp = resp.split(',');          
      _('serv').innerHTML = resp[0];
      $('#cod_servicio').val(resp[1]);
    }
  }
  
  ajax.send("loadserv=true&cod="+suggestion.data);
}

//function loadPaciente(suggestion) {
function searchPaciente(){
  var cod = $('#paciente-auto').val();
  if(cod == ''){
    alert('Por favor, ingrese el numero de Cedula del Paciente.');
    return false;
  }
  var ajax = ajaxObj("POST", "tramite_uni.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {      
      var resp = ajax.responseText;
      resp = resp.split(',');
      if(resp[0] == ''){
        alert('No se encontraron datos del paciente. Por favor, revise el dato ingresado o registre un nuevo paciente.');
        return false;
      }        
      _('pape').innerHTML = resp[0];
      _('sape').innerHTML = resp[1];
      _('nom').innerHTML = resp[2];
      _('ced').innerHTML = resp[3];
      _('fnac').innerHTML = resp[4];
      _('hc').innerHTML = resp[5];
      _('gen').innerHTML = resp[6];
      _('ec').innerHTML = resp[7];
      _('tel').innerHTML = resp[8];
      _('ins').innerHTML = resp[9];
      _('emp').innerHTML = resp[10];
      _('seg').innerHTML = resp[11];
      $('#cod_paciente').val(resp[12]);
    }
  }
  ajax.send("pac=true&cod="+cod);
//ajax.send("pac=true&cod="+suggestion.data);
}

function getLocalizacionData(){
  var cod = $('#cmbunidad').val();
  //alert('The selected value is: ' + cod);
  //_('par').innerHTML = 'OK';
  var ajax = ajaxObj("POST", "tramite_uni.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {      
      var resp = ajax.responseText;
      resp = resp.split('-');
      _('par').innerHTML = resp[0];
      _('can').innerHTML = resp[1];
      _('pro').innerHTML = resp[2];
    }
  }
  ajax.send("tip=referente&cod="+cod);
}

function saveMedicoServicio(op){
  var status;
  var medref;
  var serv;
  var btn;
  var cmb;
  
  if(op == "ms"){
    cmb = $('#cmbmedicoreferenciado');
    status = _("status");
    medref = $("#cmbmedicoreferenciado").val();
    serv = $("#cmbservicios").val();
    btn = _("btnrel");
  }else{
    cmb = $('#cmbserviciosx');
    status = _("statusx");
    medref = $("#cmbmedicoreferenciadox").val();
    serv = $("#cmbserviciosx").val();
    btn = _("btnrelx");
  }
  
  if(medref == null || serv == null ){
    alert("Por favor, seleccione opciones de ambas listas.");
    return;
  }  
  cmb.attr('disabled','true');
  btn.style.display = "none";
  status.innerHTML = '<br><img src="images/loading.gif">';
  var ajax = ajaxObj("POST", "medicoxservicio.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      status.innerHTML = "";
      btn.style.display = "block";      
      status.innerHTML = ajax.responseText;  
      cmb.removeAttr('disabled');
    }
  }
  ajax.send("medref="+medref+"&serv="+serv+"&save=true&op="+op);
}

function getMedicoxServicios(get){
  var cod = "";
  var status = _("status");
  var loader;
  var cmb;
  if(get == 'servicios'){
    cmb = $('#cmbmedicoreferenciado');
    cod = $('#cmbmedicoreferenciado').val();
    loader = _("loader");
  }else{
    cmb = $('#cmbserviciosx');
    cod = $('#cmbserviciosx').val();
    loader = _("loaderx");
  }
  loader.style.display = "block";
  cmb.attr('disabled','true');
  //status.innerHTML = '<br><img src="images/loading.gif">';
  var ajax = ajaxObj("POST", "medicoxservicio.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      status.innerHTML = "";
      loader.style.display = "none";
      resp = ajax.responseText;  
      cod_serv = resp.split(',');
      if(get == 'servicios'){
        $('#cmbservicios').val(cod_serv);
      }else{
        $('#cmbmedicoreferenciadox').val(cod_serv);
      }      
      cmb.removeAttr('disabled');
    }
  }
  if(get == "servicios"){
    ajax.send("cod="+cod+"&get=servicios");
  }
  else{
    ajax.send("cod="+cod+"&get=medicos");
  }
}

function createLocalizacion(){
  var cod = _('cod_localizacion').value;
  var d = _("descripcion").value;
  var p = _("parroquia").value;
  var c = _("canton").value;
  var pr = _("provincia").value;
  var status = _("status");
  if(d == "" || p == "" || c == "" || pr == "" ){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("signupbtn").style.display = "none";
    _("nueva_localizacion").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "localizacion.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("signupbtn").style.display = "block";        
        _("nueva_localizacion").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500);
        $('#nueva_localizacion').click();
      }
    }
    if(cod == ""){//Code to INSERT
      ajax.send("d="+d+"&p="+p+"&c="+c+"&pr="+pr);      
    }else{//Code to UPDATE
      ajax.send("d="+d+"&p="+p+"&c="+c+"&pr="+pr+"&cod="+cod); 
    }      
  }
}

function editarLocalizacion(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_localizacion').val(id);
    $('#descripcion').val($('span#td_' + id + '_1').text());
    $('#parroquia').val($('span#td_' + id + '_2').text());
    $('#canton').val($('span#td_' + id + '_3').text());
    $('#provincia').val($('span#td_' + id + '_4').text());    
    $('#descripcion').focus();
  });	  
  return false;
}


function createUnidad(){
  var cod = _('cod_unidad').value;
  var loc = _("cmblocalizacion").value;
  var des = _("descripcion").value;
  var act = _("cmbactivo").value;
  var obs = _("observacion").value;
  var status = _("status");
  if(loc == "" || des == "" || act == "" || obs == "" ){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("submitbtn").style.display = "none";
    _("nueva_unidad").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "unidad.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("submitbtn").style.display = "block";        
        _("nueva_unidad").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500);    
        $('#nueva_unidad').click();
      }
    }
    if(cod == ""){//Code to INSERT
      ajax.send("loc="+loc+"&des="+des+"&act="+act+"&obs="+obs);
    }else{//Code to UPDATE
      ajax.send("loc="+loc+"&des="+des+"&act="+act+"&obs="+obs+"&cod="+cod);
    }      
  }
}


function editUnidad(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_unidad').val(id);
    $('#cmblocalizacion').val($('span#td_' + id + '_1').text());
    $('#descripcion').val($('span#td_' + id + '_2').text());
    $('#observacion').val($('span#td_' + id + '_3').text());
    $('#cmbactivo').val($('span#td_' + id + '_4').text());    
    $('#cmblocalizacion').focus();
  });	  
  return false;
}

function createMedicoReferente(){
  var usu = '0';
  var cla = '0';
  if(String(_("usuario").value).length > 5 && String(_("clave").value).length > 5){
    usu = _("usuario").value;
    cla = _("clave").value;
  }
  
  var cod = _('cod_medicoreferente').value;
  var codmed = _("codmed").value;
  var esp = _("especialidad").value;
  var obs = _("observacion-med-ref").value;
  var est = _("cmbestado").value;
  var pnom = _("pnom").value;
  var snom = _("snom").value;
  var pape = _("pape").value;
  var sape = _("sape").value;
  var unid = $("#cmbunidad").val();
  var status = _("status");
  if(codmed == "" || esp == "" || obs == "" || est == "" || pnom == "" ||
    snom == "" || pape == "" || sape == ""){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("submitbtn").style.display = "none";
    _("nuevo_medicoreferente").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "medico_referente.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("submitbtn").style.display = "block";        
        _("nuevo_medicoreferente").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500);      
        $('#nuevo_medicoreferente').click();
      }
    }
    if(cod == ""){//Code to INSERT
      ajax.send("cla="+cla+"&usu="+usu+"&codmed="+codmed+"&esp="+esp+"&obs="+obs+"&est="+est+
        "&pnom="+pnom+"&snom="+snom+"&pape="+pape+"&sape="+sape+"&unid="+unid);
    }else{//Code to UPDATE
      ajax.send("cla="+cla+"&usu="+usu+"&codmed="+codmed+"&esp="+esp+"&obs="+obs+"&est="+est+
        "&pnom="+pnom+"&snom="+snom+"&pape="+pape+"&sape="+sape+"&unid="+unid+"&cod="+cod);
    }      
  }
}

function editMedicoReferente(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_medicoreferente').val(id);
    $('#pnom').val($('span#td_' + id + '_5').text());
    $('#snom').val($('span#td_' + id + '_6').text());
    $('#pape').val($('span#td_' + id + '_7').text());
    $('#sape').val($('span#td_' + id + '_8').text());
    $('#codmed').val($('span#td_' + id + '_1').text());
    $('#especialidad').val($('span#td_' + id + '_2').text());
    $('#cmbestado').val($('span#td_' + id + '_4').text());
    $('#observacion-med-ref').val($('span#td_' + id + '_3').text());
    var vals = $('span#uni_' + id).text();
    var unicod = vals.split(',');
        
    $('#cmbunidad').val(unicod);
    
    $('#pnom').focus();
  });	  
  return false;
}

function createMedicoReferenciado(){
  var cod = _('cod_medicoreferenciado').value;
  var codmed = _("codmed").value;
  var esp = _("especialidad").value;
  var obs = _("observacion-med-ref").value;
  var est = _("cmbestado").value;
  var pnom = _("pnom").value;
  var snom = _("snom").value;
  var pape = _("pape").value;
  var sape = _("sape").value;
  var status = _("status");
  if(codmed == "" || esp == "" || obs == "" || est == "" || pnom == "" ||
    snom == "" || pape == "" || sape == ""){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("submitbtn").style.display = "none";
    _("nuevo_medicoreferenciado").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "medico_referenciado.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("submitbtn").style.display = "block";        
        _("nuevo_medicoreferenciado").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500); 
        $('#nuevo_medicoreferenciado').click();
      }
    }
    if(cod == ""){//Code to INSERT
      ajax.send("codmed="+codmed+"&esp="+esp+"&obs="+obs+"&est="+est+
        "&pnom="+pnom+"&snom="+snom+"&pape="+pape+"&sape="+sape);
    }else{//Code to UPDATE
      ajax.send("codmed="+codmed+"&esp="+esp+"&obs="+obs+"&est="+est+
        "&pnom="+pnom+"&snom="+snom+"&pape="+pape+"&sape="+sape+"&cod="+cod);
    }      
  }
}

function editMedicoReferenciado(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_medicoreferenciado').val(id);
    $('#pnom').val($('span#td_' + id + '_5').text());
    $('#snom').val($('span#td_' + id + '_6').text());
    $('#pape').val($('span#td_' + id + '_7').text());
    $('#sape').val($('span#td_' + id + '_8').text());
    $('#codmed').val($('span#td_' + id + '_1').text());
    $('#especialidad').val($('span#td_' + id + '_2').text());
    $('#cmbestado').val($('span#td_' + id + '_4').text());
    $('#observacion-med-ref').val($('span#td_' + id + '_3').text());
       
    $('#pnom').focus();
  });	  
  return false;
}


function createPaciente(){
  var cod = _('cod_paciente').value;
  var ced = _("ced").value;
  var fnac = _("fnac").value;
  var cmbgenero = _("cmbgenero").value;
  var cmbestciv = _("cmbestciv").value;
  var pnom = _("pnom").value;
  var snom = _("snom").value;
  var pape = _("pape").value;
  var sape = _("sape").value;
  var ins = _("ins").value;
  var hc = _("hc").value;
  var tel = _("tel").value;
  
  var emp = $("#cmbempresas").val();
  var seg = $("#cmbseguros").val();
  
  var status = _("status");
  if(ced == "" || fnac == "" || cmbgenero == "" || cmbestciv == "" || pnom == "" ||
    snom == "" || pape == "" || sape == "" || ins == "" || hc == "" || tel == ""){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("submitbtn").style.display = "none";
    _("nuevo_paciente").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "paciente.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("submitbtn").style.display = "block";        
        _("nuevo_paciente").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500);
        $('#nuevo_paciente').click();
      }
    }
    var params = "ced="+ced+"&fnac="+fnac+"&cmbgenero="+cmbgenero+"&cmbestciv="+cmbestciv+
    "&pnom="+pnom+"&snom="+snom+"&pape="+pape+"&sape="+sape+"&ins="+ins+"&hc="+hc+"&tel="+tel+"&emp="+emp+"&seg="+seg;
    if(cod == ""){//Code to INSERT
      ajax.send(params);
    }else{//Code to UPDATE
      ajax.send(params+"&cod="+cod);
    }      
  }
}

function editPaciente(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_paciente').val(id);
    $('#pnom').val($('span#td_' + id + '_4').text());
    $('#snom').val($('span#td_' + id + '_5').text());
    $('#pape').val($('span#td_' + id + '_6').text());
    $('#sape').val($('span#td_' + id + '_7').text());
    $('#ced').val($('span#td_' + id + '_3').text());
    $('#fnac').val($('span#td_' + id + '_8').text());
    $('#cmbgenero').val($('span#td_' + id + '_9').text());
    $('#cmbestciv').val($('span#td_' + id + '_10').text());
    $('#ins').val($('span#td_' + id + '_11').text());
    $('#hc').val($('span#td_' + id + '_12').text());
    $('#tel').val($('span#td_' + id + '_13').text());
    $('#cmbseguros').val($('span#seg_' + id).text());
    $('#cmbempresas').val($('span#emp_' + id).text());
                
    $('#pnom').focus();
  });	  
  return false;
}

function save_edit_Seguro(cod, des, obs)
{
  if(des == "" || obs == "") {
    return false;
  }
  var ajax = ajaxObj("POST", "seguro-empresa.php");  
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      $('#cmbseguros').remove();
      $('div#value_seguros').html(ajax.responseText);  
      $('#cmbseguros option').click(function (){
        $('#cmbseguros option').removeClass('segselected');
        $(this).addClass('segselected');
      });
    }
  }
  if(cod == ""){
    ajax.send("seguros=true&des="+des+"&obs="+obs);    
  }else{
    ajax.send("seguros=true&des="+des+"&obs="+obs+"&cod="+cod);    
  }  
  return true;
}

function save_edit_Empresa(cod, des, obs)
{
  if(des == "" || obs == "") {
    return false;
  }
  var ajax = ajaxObj("POST", "seguro-empresa.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      $('#cmbempresas').remove();
      $('div#value_empresas').append(ajax.responseText);
      $('#cmbempresas option').click(function (){
        $('#cmbempresas option').removeClass('empselected');
        $(this).addClass('empselected');
      });
    }
  }
  if(cod == ""){
    ajax.send("empresas=true&des="+des+"&obs="+obs);    
  }else{
    ajax.send("empresas=true&des="+des+"&obs="+obs+"&cod="+cod);    
  }
  return true;
}

function save_edit_Referenciado(cod, des, obs, sig)
{
  if(des == "" || obs == "" || sig == "") {
    return false;
  }
  var ajax = ajaxObj("POST", "referenciado.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) {
      $('#cmbreferenciado').remove();
      $('div#value_referenciado').append(ajax.responseText);
      $('#cmbreferenciado option').click(function (){
        $('#cmbreferenciado option').removeClass('refselected');
        $(this).addClass('refselected');
      });
    }
  }
  if(cod == ""){
    ajax.send("des="+des+"&obs="+obs+"&sig="+sig);    
  }else{
    ajax.send("des="+des+"&obs="+obs+"&sig="+sig+"&cod="+cod);    
  }
  return true;
}

function createUsuario(){
  var cod = _('cod_usuario').value;
  var u = _("usuario").value;
  var c = _("clave").value;
  var t = _("cmbtipo").value;
  var a = _("cmbactivo").value;
  
  var status = _("status");
  if(u == "" || c == "" || t == "" || a == ""){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("submitbtn").style.display = "none";
    _("nuevo_usuario").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "usuario.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("submitbtn").style.display = "block";        
        _("nuevo_usuario").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500);
        $('#nuevo_usuario').click();
        $('#cmbtipo').removeAttr('disabled');
      }
    }
    var params = "u="+u+"&c="+c+"&t="+t+"&a="+a;
    if(cod == ""){//Code to INSERT
      ajax.send(params);
    }else{//Code to UPDATE
      ajax.send(params+"&cod="+cod);
    }      
  }
}

function editUsuario(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_usuario').val(id);
    $('#usuario').val($('span#td_' + id + '_1').text());
    $('#clave').val("");        
    $('#cmbtipo').val($('span#tip_' + id).text());
    if($('span#tip_' + id).text() == 'referente'){
      $('#cmbtipo').attr('disabled', true);
    }
    $('#cmbactivo').val($('span#act_' + id).text());
                
    $('#pnom').focus();
  });	  
  return false;
}

function createServicios(){
  var cod = _('cod_servicios').value;
  var d = _("descripcion").value;
  var o = _("observacion").value;
  var r = _("cmbreferenciado").value;
  var status = _("status");
  if (r == ""){
    alert('Debe seleccionar un referenciado de la lista.');
  }else if(d == "" || o == ""){
    status.innerHTML = "Todos los campos son requeridos";
  } else {    
    _("submitbtn").style.display = "none";
    _("nuevo_servicios").style.display = "none";
    status.innerHTML = '<br><img src="images/loading.gif">';       
    $("#table_content").hide(300);
    var ajax = ajaxObj("POST", "servicios.php");
    ajax.onreadystatechange = function() {
      if(ajaxReturn(ajax) == true) {
        status.innerHTML = "Datos guardados correctamente.";
        _("submitbtn").style.display = "block";        
        _("nuevo_servicios").style.display = "block";
        _("table_data").innerHTML = ajax.responseText;
        $("#table_content").show(500);
        $('#nuevo_servicios').click();        
      }
    }
    var params = "d="+d+"&o="+o+"&r="+r;
    if(cod == ""){//Code to INSERT
      ajax.send(params);
    }else{//Code to UPDATE
      ajax.send(params+"&cod="+cod);
    }      
  }
}

function editServicios(id){
  $('html, body').animate({
    scrollTop:$('#templatemo_main').offset().top
  }, 'slow', function(){
    $('#cod_servicios').val(id);
    $('#descripcion').val($('span#td_' + id + '_1').text());
    $('#observacion').val($('span#td_' + id + '_2').text());
    $('#cmbreferenciado').val("");
                
    $('#descripcion').focus();
  });	  
  return false;
}
