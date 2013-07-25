
function filtrarDatos(page, btn){
  //Filtra los Servicios
  if(page == 'servicios'){
    cargarServiciosFiltrados(btn, $('#rxp').val(), $('#pa').val(), $('#cmborden').val(), _('texto').value);
  }
  
  //Filtra las unidades
  if(page == 'unidad'){
    if($('#cmbopcion').val() == 'op2'){
      if($('#cmbact').val() == 'op0'){
        alert('Por favor, seleccione el Estado (Activo o Inactivo) para filtrar los datos.');
        return;
      }
    }
    cargarUnidadesFiltradas(btn, $('#rxp').val(), $('#pa').val(), $('#cmbopcion').val(), $('#cmborden').val(), $('#cmbact').val(), _('texto').value);    
  }
  
  //Filtra la localizacion
  if(page == 'localizacion'){
    cargarLocalizacionesFiltradas(btn, $('#rxp').val(), $('#pa').val(), $('#cmbopcion').val(), $('#cmborden').val(), _('texto').value);    
  }
  //Filtra datos de referencias  
  if(page == 'referencias' || page == 'referencias_uni'){
    if($('#cmbopcion').val() == 'op2'){
      if($('#nro-tra-ced').val() == ""){
        alert('Por favor ingrese un número de Cédula o el código del Trámite.');
        return;
      }
    }
    if($('#cmbopcion').val() == 'op3'){
      if($('#fecha-desde').val() == '' || $('#fecha-hasta').val() == ''){
        alert('Por favor seleccione fechas Desde y Hasta.');
        return;
      }
    }
    if(page == 'referencias'){
      cargarReferenciasFiltradasHospital(btn, $('#rxp').val(), $('#pa').val(),
        $('#load-page1').val(), $('#cmbopcion').val(), $('#cmbestadotipo').val(),
        $('#nro-tra-ced').val(), $('#fecha-desde').val(), $('#fecha-hasta').val());
    }else{
      cargarReferenciasFiltradasUnidad(btn, $('#rxp').val(), $('#pa').val(),
        $('#load-page1').val(), $('#cmbopcion').val(), $('#cmbestadotipo').val(),
        $('#nro-tra-ced').val(), $('#fecha-desde').val(), $('#fecha-hasta').val());
    }
  }    
}

function cargarUnidadesFiltradas(btn, rxp, pa, op, ord, est, tex){
  var tem1 = $('#table_data tr:last-child > td:first-child > span').text();   
  _("table_data").innerHTML = '<div style="float:left;"><br><img src="images/loading.gif"></div>';
  var ajax = ajaxObj("POST", "unidad.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) { 
      $("#table_content").hide();         
      _("table_data").innerHTML = ajax.responseText;  
      var tem2 = $('#table_data tr:last-child > td:first-child > span').text();
      actualizarPaginador(btn, tem1, tem2);
      $("#table_content").fadeIn(800);
    }
  }
  ajax.send("btn="+btn+"&rxp="+rxp+"&pa="+pa+"&op="+op+"&ord="+ord+"&est="+est+"&tex="+tex);
}

function cargarServiciosFiltrados(btn, rxp, pa, ord, tex){
  var tem1 = $('#table_data tr:last-child > td:first-child > span').text();   
  _("table_data").innerHTML = '<div style="float:left;"><br><img src="images/loading.gif"></div>';
  var ajax = ajaxObj("POST", "servicios.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) { 
      $("#table_content").hide();         
      _("table_data").innerHTML = ajax.responseText;  
      var tem2 = $('#table_data tr:last-child > td:first-child > span').text();
      actualizarPaginador(btn, tem1, tem2);
      $("#table_content").fadeIn(800);
    }
  }
  ajax.send("btn="+btn+"&rxp="+rxp+"&pa="+pa+"&ord="+ord+"&tex="+tex);
}

function cargarLocalizacionesFiltradas(btn, rxp, pa, op, ord, tex){
  var tem1 = $('#table_data tr:last-child > td:first-child > span').text();   
  _("table_data").innerHTML = '<div style="float:left;"><br><img src="images/loading.gif"></div>';
  var ajax = ajaxObj("POST", "localizacion.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) { 
      $("#table_content").hide();         
      _("table_data").innerHTML = ajax.responseText;  
      var tem2 = $('#table_data tr:last-child > td:first-child > span').text();
      actualizarPaginador(btn, tem1, tem2);
      $("#table_content").fadeIn(800);
    }
  }
  ajax.send("btn="+btn+"&rxp="+rxp+"&pa="+pa+"&op="+op+"&ord="+ord+"&tex="+tex);
}

function cargarReferenciasFiltradasHospital(btn, rxp, pa, lp1, op, est, nro, fd, fh){
  var tem1 = $('#table_data tr:last-child > td:first-child > span').text();   
  _("table_data").innerHTML = '<div style="float:left;"><br><img src="images/loading.gif"></div>';
  var ajax = ajaxObj("POST", "referencias.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) { 
      $("#table_content").hide();
         
      _("table_data").innerHTML = ajax.responseText;  
      var tem2 = $('#table_data tr:last-child > td:first-child > span').text();
      actualizarPaginador(btn, tem1, tem2);
      $("#table_content").fadeIn(800);
    }
  }
  ajax.send("btn="+btn+"&rxp="+rxp+"&pa="+pa+"&lp1="+lp1+"&op="+op+"&est="+est+
    "&nro="+nro+"&fd="+fd+"&fh="+fh);
}

function cargarReferenciasFiltradasUnidad(btn, rxp, pa, lp1, op, est, nro, fd, fh){
  var tem1 = $('#table_data tr:last-child > td:first-child > span').text(); 
  _("table_data").innerHTML = '<div style="float:left;"><br><img src="images/loading.gif"></div>';
  var ajax = ajaxObj("POST", "referencias_uni.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) { 
      $("#table_content").hide();     
      _("table_data").innerHTML = ajax.responseText;  
      var tem2 = $('#table_data tr:last-child > td:first-child > span').text();
      actualizarPaginador(btn, tem1, tem2);
      $("#table_content").fadeIn(800);
    }
  }
  ajax.send("btn="+btn+"&rxp="+rxp+"&pa="+pa+"&lp1="+lp1+"&op="+op+"&est="+est+
    "&nro="+nro+"&fd="+fd+"&fh="+fh);
}


function actualizarPaginador(btn, tem1, tem2){
  if(btn == 'car'){
    $('#pa').val('1');
  }
  if(btn == 'ant'){
    if($('#pa').val() != '1'){
      $('#pa').val(parseInt($('#pa').val()) - 1);
    }
  }      
  if(btn == 'sig'){        
    if(tem1 != tem2){
      $('#pa').val(parseInt($('#pa').val()) + 1);
    }
  }
}


function changeOptionFilter(){
  $('.opt-common').hide();
  $('#t' + $('#cmbopcion').val()).fadeIn(200);
  $('#load-page1').val('1');
  if($('#cmbopcion').val() == 'op1' || $('#cmbopcion').val() == 'op3'){
    $('#top1').fadeIn(200);
  }
}

function changeOptionFilterLocalizacion(){
  $('.opt-common').hide();
  if($('#cmbopcion').val() == 'op5'){
    $('#top2').fadeIn(200);
  }
  else{
    $('#top1').fadeIn(200);
  }
}

function changeOptionFilterUnidad(){
  if($('#cmbopcion').val() == 'op3'){
    $('#top3').fadeIn(200);
  }
  else{
    $('#top3').fadeOut(200);
  }
}