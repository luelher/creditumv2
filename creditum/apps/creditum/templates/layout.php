<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--

Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Title      : Boorish
Version    : 1.0
Released   : 20080123
Description: A wide two-column design suitable for blogs and small websites.

-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
</head>
<body>
<!-- start header -->
<div id="header">
  <div id="logo">
    <h1><a href="http://creditum.sl">Creditum</a></h1>
    <h2>Información Crediticia las 24 Horas</h2>
  </div>
  <div id="menu">
    <?php include_component_slot('principal') ?>
    
  </div>
  <?php include_component_slot('info') ?>
</div>
<!-- end header -->
<!-- start page -->
<div id="page">
  <!-- start content -->
  <div id="content">

    <!-- start latest-post -->
    <div id="latest-post" class="post">
      <?php echo $sf_content ?>
    </div>
    <!-- end latest-post -->
    <!-- start recent-posts -->
    <div id="recent-posts">
      <?php include_component_slot('menu') ?>
    </div>
    <!-- end recent-posts -->
  </div>
  <!-- end content -->
  <!-- start sidebar -->
  <div id="sidebar">
    <ul>
    </ul>
    <div style="clear: both;">&nbsp;</div>
  </div>
  <!-- end sidebar -->
</div>
<!-- end page -->
<div id="footer">
  <p id="legal">&copy;2009 Informadora de Crédito en Línea. Todos los Derechos Reservados. | Desarrollado, Diseñado y Mantenido por <a href="http://www.grupoemporium.com.ve/">Grupo Emporium</a></p>
  <p id="links"><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional"><abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a> | <a href="http://jigsaw.w3.org/css-validator/check/referer" title="This page validates as CSS"><abbr title="Cascading Style Sheets">CSS</abbr></a></p>
</div>
</body>
</html>


