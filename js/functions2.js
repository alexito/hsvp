
function filtrarDatos(page, btn){
  //Filtra datos de referencias
  if(page == 'referencias'){
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
//    if($('#rxp').val() == '' || !isNumber($('#rxp').val())){
//      $('#rxp').val('20');
//    }    
    cargarReferenciasFiltradas(btn, $('#rxp').val(), $('#pa').val(),
      $('#load-page1').val(), $('#cmbopcion').val(), $('#cmbestadotipo').val(),
      $('#nro-tra-ced').val(), $('#fecha-desde').val(), $('#fecha-hasta').val());
  }  
}

function cargarReferenciasFiltradas(btn, rxp, pa, lp1, op, est, nro, fd, fh){
  $("#table_content").fadeOut(300);
  var ajax = ajaxObj("POST", "referencias.php");
  ajax.onreadystatechange = function() {
    if(ajaxReturn(ajax) == true) { 
      _("table_data").innerHTML = ajax.responseText;
      $("#table_content").fadeIn(300);
    }
  }
  ajax.send("btn="+btn+"&rxp="+rxp+"&pa="+pa+"&lp1="+lp1+"&op="+op+"&est="+est+
  "&nro="+nro+"&fd="+fd+"&fh="+fh);
}

function changeOptionFilter(){
  $('.opt-common').hide();
  $('#t' + $('#cmbopcion').val()).fadeIn(200);
  $('#load-page1').val('1');
}
