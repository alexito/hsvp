<div id="templatemo_header">

  <div id="site_title"><h1><a href="index.php">HSVP</a></h1></div>

  <div id="templatemo_menu" class="ddsmoothmenu">
    <ul>
      <?php
      if ($user_ok == TRUE && $log_tipo == 'admin') {        
      ?>
      <li><a href="#">Administrar</a>
        <ul>
          <li><a href="localizacion.php">Localizacion</a></li>
          <li><a href="unidad.php">Unidad</a></li>
          <li><a href="medico_referente.php">Medico Referente</a></li>
          <li><a href="servicios.php">Servicio</a></li>
          <li><a href="medico_referenciado.php">Medico Referenciado</a></li>          
          <li><a href="medicoxservicio.php">Medico - Servicio</a></li>          
          <li><a href="usuario.php">Creación de Usuario</a></li>
        </ul>
      </li>
      <?php }?>
      <?php
      if ($user_ok == TRUE && $log_tipo == 'referente') {        
      ?>
      <li><a href="#">Unidad</a>
        <ul>
          <li><a href="tramite_uni.php">Crear Referencia</a></li>
          <li><a href="referencias_uni.php">Ver Referencias</a></li>
          <li><a href="paciente.php">Nuevo Paciente</a></li>                    
        </ul>
      </li>
      <?php }?>
      <?php
      if ($user_ok == TRUE && $log_tipo == 'contrareferente') {        
      ?>
      <li><a href="#">Hospital</a>
        <ul>
          <li><a href="referencias.php">Ver Referencias</a></li>                           
        </ul>
      </li>
      <?php }
      if ($user_ok == TRUE) {        ?>
      <li><a href="logout.php">Salir</a></li>
      <?php }?>
    </ul>
    <br style="clear: left" />
  </div> <!-- end of templatemo_menu -->
  <div class="cleaner"></div>
</div> <!-- end of templatemo header -->