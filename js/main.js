var countriesArray, countries;
var diag_fields;
var diag_counter;

function _(x){
  return document.getElementById(x);
}

//To create new Localization - Clean fields
window.onload = function init() {
  
  
  ////Get the current page name
  val = window.location.href;
  val = val.split('/');
  val = val[val.length -1]
  
  if(val == 'tramite_uni.php'){
    diag_counter = 2;
    diag_fields = new Array();
    
    //Set localizacion data
    getLocalizacionData();
    //Load Paciente autocomplete data
    //PARA ACTIVAR EL AUTOCOMPLETADO DE PACIENTE QUITAR EL COMENTARIO.
    //autocompletePaciente();
  
    //Load Servicio autocomplete data
    autocompleteServicio();
    
    
    //SIE10 
    //Icono Buscar Paciente.
    $('#searchPaciente').click(function(){
      searchPaciente();
    });
  
    $.fn.enterKey = function (fnc) {
      return this.each(function () {
        $(this).keypress(function (ev) {
          var keycode = (ev.keyCode ? ev.keyCode : ev.which);
          if (keycode == '13') {
            fnc.call(this, ev);
          }
        })
      })
    }
    $("#paciente-auto").enterKey(function () {
      searchPaciente();
    })
  
    $.ajax({
      url: 'sie10.php',
      dataType: 'json'
    }).done(function (source) {

      countriesArray = $.map(source, function (value, key) {
        return {
          value: value, 
          data: key
        };    
      }),
      countries = $.map(source, function (value) {
        return value;
      });

      // Setup jQuery ajax mock:
      $.mockjax({
        url: '*',
        responseTime: 2000,
        response: function (settings) {
          var query = settings.data.query,
          queryLowerCase = query.toLowerCase(),
          re = new RegExp('\\b' + queryLowerCase, 'gi'),
          suggestions = $.grep(countriesArray, function (country) {
            // return country.value.toLowerCase().indexOf(queryLowerCase) === 0;
            return re.test(country.value);
          }),
          response = {
            query: query,
            suggestions: suggestions
          };

          this.responseText = JSON.stringify(response);
        }
      });
      // Initialize ajax autocomplete:
      $('#diagnostico-auto-1').autocomplete({        
        lookup: countriesArray,
        minChars: 3,
        autoSelectFirst: true,
        onSelect: function(elem){
          var id = $(this).attr('id');
          id = id.split('-');
          id = id[id.length - 1];
          $('#cod-diag-' + id).val(elem.data);
        },
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
          var re = new RegExp('\\b' + queryLowerCase, 'gi');
          return re.test(suggestion.value);
        }
      });
    });
      
    //Aniade un nuevo campo para ingresar un nuevo diagnostico
    $('#add-diag').click(function(){
      $('#sie10').append('<tr ><td><input class="cod_diag_class" type="hidden" name="cod_diag" id="cod-diag-' + diag_counter + '" value="" />'+
        '<input style="width:25px;" type="radio" name="group-' + diag_counter + '" value="pre" checked="true">PRE<input style="width:25px;" type="radio" name="group-' + diag_counter + '" value="def">DEF<input style="width:400px; margin-left:9px;" type="text" name="diagnostico" id="diagnostico-auto-' + diag_counter + '"/>'+
        '<a class="elim-diag" href="#"><img style="width:25px; margin-left:10px;margin-right:10px; margin-bottom: -8px;" src="images/icono-eliminar.png">Eliminar</a></td></tr>');
    
      // Initialize ajax autocomplete:
      $('#diagnostico-auto-' + diag_counter).autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: countriesArray,
        minChars: 3, 
        autoSelectFirst: true,
        onSelect: function(elem){
          var id = $(this).attr('id');
          id = id.split('-');
          id = id[id.length - 1];
          $('#cod-diag-' + id).val(elem.data);
        },
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
          var re = new RegExp('\\b' + queryLowerCase, 'gi');
          return re.test(suggestion.value);
        }
      });
      diag_fields[diag_counter] = true;
      $('.elim-diag').click(function (){
        var pos = $('#position', this).val();
        diag_fields[pos] = false;
        $(this).parent().parent().remove();
        return false;
      });
      diag_counter++;
      return false;
    });
    
  }
  
  //Guarda los datos del referente
  $('#saveTramiteUnidad').click(function(){
      //window.location.href = 'tramite_uni.php';
      saveTramiteUnidad();
      //getDiagnosticoCodes();
    });
  
  /////Muestra msg olvido clave
  $('#olvidoclave').click(function(){
    $('#msg').show(200);
  });
  
  ///// REFERENCIADO
  $('#refagregar').click(function(){    
    $('#frmref').show(500);
    $('#ref_descrip').val('');
    $('#ref_observ').val('');
    $('#ref_siglas').val('');
    $('#reflinks').hide(200);
    return false;
  });
  $('#refcancelar').click(function(){
    $('#frmref').hide(500);
    $('#ref_descrip').val('');
    $('#ref_observ').val('');
    $('#ref_siglas').val('');
    $('#reflinks').show(200);
    return false;
  });
  
  $('#refguardar').click(function(){
    var des = $('#ref_descrip').val();
    var obs = $('#ref_observ').val();
    var sig = $('#ref_siglas').val();
    var cod = $('#cod_referenciado').val();
    var res;
    if(cod == ""){
      res = save_edit_Referenciado("", des, obs, sig);
    }else{
      res = save_edit_Referenciado(cod, des, obs, sig);
    }
      
    if(res){
      $('#cod_referenciado').val('');
      $('#ref_descrip').val('');
      $('#ref_observ').val('');
      $('#ref_siglas').val('');
      $('#frmref').hide(500);
      $('#reflinks').show(200);
    }else{
      alert('Todos los campos son requeridos.');
    }
    return false;
  });
  
  //MARK AS SELECT THE ITEM CLICKED - DISPLAY DATA
  $('#cmbreferenciado option').click(function (){
    $('#frmref').hide(200);
    $('#reflinks').show(200);
    $('#cmbreferenciado option').removeClass('refselected');    
    $(this).addClass('refselected');    
  });

  //EDITAR referenciado
  
  $('#refeditar').click(function(){    
    var cod = $('#cmbreferenciado').val();
    var text = $('option.refselected').text();
    if(cod == "" || cod == null){
      alert('Seleccione un item.');
      return false;
    }    
    return false;    
  });
  
  
  ///// SEGURO
  $('#segagregar').click(function(){
    $('#msgseg').hide(200);
    $('#frmseg').show(500);
    $('#seg_descrip').val('');
    $('#seg_observ').val('');
    $('#cod_seguro').val('');
    $('#seglinks').hide(200);
    return false;
  });
  $('#segcancelar').click(function(){
    $('#frmseg').hide(500);
    $('#seg_descrip').val('');
    $('#seg_observ').val('');
    $('#cod_seguro').val('');
    $('#seglinks').show(200);
    return false;
  });
  
  $('#segguardar').click(function(){
    var des = $('#seg_descrip').val();
    var obs = $('#seg_observ').val();
    var cod = $('#cod_seguro').val();
    var res;
    if(cod == ""){
      res = save_edit_Seguro("", des, obs);
    }else{
      res = save_edit_Seguro(cod, des, obs);
    }
      
    if(res){
      $('#cod_seguro').val('');
      $('#seg_descrip').val('');
      $('#seg_observ').val('');
      $('#frmseg').hide(500);
      $('#seglinks').show(200);
    }else{
      alert('Todos los campos son requeridos.');
    }
    return false;
  });
  
  //MARK AS SELECT THE ITEM CLICKED - DISPLAY DATA
  $('#cmbseguros option').click(function (){
    $('#frmseg').hide(200);
    $('#seglinks').show(200);
    $('#cmbseguros option').removeClass('segselected');    
    $(this).addClass('segselected');
    
    var text = $('option.segselected').text();
    
    text = text.split('_');
    $('#msgseg').html('<h5>' + text[0] + ':</h5><span>' + text[1] + '</span>' )
    $('#msgseg').show(200);
  });

  //EDITAR SEGURO
  
  $('#segeditar').click(function(){
    $('#msgseg').hide(200);
    var cod = $('#cmbseguros').val();
    var text = $('option.segselected').text();
    if(cod == "" || cod == null){
      alert('Seleccione un item.');
      return false;
    }
    text = text.split('_');
    $('#seg_descrip').val('' + text[0]);
    $('#seg_observ').val('' + text[1]);
    $('#cod_seguro').val('' + cod);
    $('#frmseg').show(500);
    $('#seglinks').hide(200);
    
    return false;
    
  });
  ///// EMPRESA
  $('#empagregar').click(function(){
    $('#msgemp').hide(200);
    $('#frmemp').show(500);
    $('#emplinks').hide(200);
    $('#emp_descrip').val('');
    $('#emp_observ').val('');
    $('#cod_empresa').val('');
    return false;
  });
  $('#empcancelar').click(function(){
    $('#frmemp').hide(500);
    $('#emp_descrip').val('');
    $('#emp_observ').val('');
    $('#cod_empresa').val('');
    $('#emplinks').show(200);
    return false;
  });
  
  $('#empguardar').click(function(){
    var des = $('#emp_descrip').val();
    var obs = $('#emp_observ').val();    
    var cod = $('#cod_empresa').val();
    var res;
    if(cod == ""){
      res = save_edit_Empresa("", des, obs);
    }else{
      res = save_edit_Empresa(cod, des, obs);
    }
      
    if(res){
      $('#emp_descrip').val('');
      $('#emp_observ').val('');
      $('#cod_empresa').val('');
      $('#frmemp').hide(500);
      $('#emplinks').show(200);
    }else{
      alert('Todos los campos son requeridos.');
    }
    return false;
  });
  
  //MARK AS SELECT THE CLICKED ITEM AND DISPLAY DATA
  $('#cmbempresas option').click(function (){
    $('#frmemp').hide(200);
    $('#emplinks').show(200);
    $('#cmbempresas option').removeClass('empselected');
    $(this).addClass('empselected');
    var text = $('option.empselected').text();
    
    text = text.split('_');
    $('#msgemp').html('<h5>' + text[0] + ':</h5><span>' + text[1] + '</span>' )
    $('#msgemp').show(200);
  });

  //EDITAR EMPRESA
  
  $('#empeditar').click(function(){
    $('#msgemp').hide(200);
    var cod = $('#cmbempresas').val();
    var text = $('option.empselected').text();
    if(cod == "" || cod == null){
      alert('Seleccione un item.');
      return false;
    }
    text = text.split('_');
    $('#emp_descrip').val('' + text[0]);
    $('#emp_observ').val('' + text[1]);
    $('#cod_empresa').val('' + cod);
    $('#frmemp').show(500);
    $('#emplinks').hide(200);
    
    return false;
    
  });

  
  $('#nuevo_usuario').click(function()
  {
    $('#cod_usuario').val('');
    $('#usuario').val('');
    $('#clave').val('');
    $('#cmbtipo').val('');
    $('#cmbactivo').val('');
                
    $('#usuario').focus();
    return false;
  });
  
  $('#nuevo_paciente').click(function()
  {
    $('#cod_paciente').val('');
    $('#pnom').val('');
    $('#snom').val('');
    $('#pape').val('');
    $('#sape').val('');
    $('#ced').val('');
    $('#fnac').val('');
    $('#cmbgenero').val('');
    $('#cmbestciv').val('');
    $('#ins').val('');
    $('#hc').val('');
    $('#tel').val('');
    $('#cmbseguros').val('');
    $('#cmbempresas').val('');
                
    $('#pnom').focus();
    return false;
  });

  $('#nuevo_medicoreferente').click(function()
  {
    $('#cod_medicoreferente').val('');
    $('#usuario').val('');
    $('#clave').val('');
    $("#codmed").val('');
    $("#especialidad").val('');
    $("#observacion-med-ref").val('');
    $("#cmbestado").val('');
    $("#pnom").val('');
    $("#snom").val('');
    $("#pape").val('');
    $("#sape").val('');
    $("#cmbunidad").val('');
    $('#pnom').focus();
    return false;
  });
  
  $('#nuevo_medicoreferenciado').click(function()
  {
    $('#cod_medicoreferenciado').val('');
    $("#codmed").val('');
    $("#especialidad").val('');
    $("#observacion-med-ref").val('');
    $("#cmbestado").val('');
    $("#pnom").val('');
    $("#snom").val('');
    $("#pape").val('');
    $("#sape").val('');
    $('#pnom').focus();
    return false;
  });

  $('#nueva_unidad').click(function()
  {
    $('#cod_unidad').val('');
    $('#cmblocalizacion').val('');
    $('#descripcion').val('');
    $('#cmbactivo').val('activo');
    $('#observacion').val('');    
    $('#cmblocalizacion').focus();
    return false;
  });

  $('#nueva_localizacion').click(function()
  {
    $('#cod_localizacion').val('');
    $('#descripcion').val('');
    $('#parroquia').val('');
    $('#canton').val('');
    $('#provincia').val('');    
    $('#descripcion').focus();
    return false;
  });
  
  $('#nuevo_servicios').click(function()
  {
    $('#cod_servicios').val('');
    $('#descripcion').val('');
    $('#observacion').val('');
    $('#descripcion').focus();
    return false;
  });
  
  $('#op2').click(function(){
    $(this).addClass('header_highlight');
    $('#op1').removeClass('header_highlight');
    $('#dat1').fadeOut(400, function(){
      $('#dat2').fadeIn(600);
      $('')
    });    
  });
  
  $('#op1').click(function(){
    $(this).addClass('header_highlight');
    $('#op2').removeClass('header_highlight');
    $('#dat2').fadeOut(400, function(){
      $('#dat1').fadeIn(600);
    });    
  });
}