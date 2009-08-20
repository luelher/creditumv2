<?php

class Experiencia{
  
  protected $cedula = '';
  protected $nombre = '';
  protected $apellido = '';
  protected $telefono = '';
  protected $celular = '';
  protected $profesion = '';
  protected $factura = '';
  protected $fecha_compra = '';
  protected $monto = 0.0;
  protected $pago_mes = 0.0;
  protected $numero_giros = 0.0;
  protected $fecha_cancelacion = '';  
  protected $experiencia = '';
  
  protected $metadata ='';
  
  // Metodos Gets
  public function getCedula()
  {
    return $this->cedula;
  }

  public function getNombre()
  {
    return $this->nombre;
  }
  
  public function getApellido()
  {
    return $this->apellido;
  }

  public function getTelefono()
  {
    return $this->telefono;
  }
  
  public function getCelular()
  {
    return $this->celular;
  }

  public function getProfesion()
  {
    return $this->profesion;
  }

  public function getFactura()
  {
    return $this->factura;
  }

  public function getFechaCompra()
  {
    return $this->fecha_compra;
  }

  public function getMonto()
  {
    return $this->monto;
  }

  public function getPagoMes()
  {
    return $this->pago_mes;
  }

  public function getNumeroGiros()
  {
    return $this->numero_giros;
  }

  public function getFechaCancelacion()
  {
    return $this->fecha_cancelacion;
  }

  public function getExperiencia()
  {
    return $this->experiencia;
  }

  // Metodos Sets
  public function setCedula($value)
  {
    $this->cedula = $value;
  }

  public function setNombre($value)
  {
    $this->nombre = $value;
  }
  
  public function setApellido($value)
  {
    $this->apellido = $value;
  }

  public function setTelefono($value)
  {
    $this->telefono = $value;
  }

  public function setCelular($value)
  {
    $this->celular = $value;
  }

  public function setProfesion($value)
  {
    $this->profesion = $value;
  }

  public function setFactura($value)
  {
    $this->factura = $value;
  }

  public function setFechaCompra($value)
  {
    $this->fecha_compra = $value;
  }

  public function setMonto($value)
  {
    $this->monto = $value;
  }

  public function setPagoMes($value)
  {
    $this->pago_mes = $value;
  }

  public function setNumeroGiros($value)
  {
    $this->numero_giros = $value;
  }
  
  public function setFechaCancelacion($value)
  {
    $this->fecha_cancelacion = $value;
  }

  public function setExperiencia($value)
  {
    $this->experiencia = $value;
  }

  public function Hidratar($datos)
  {
    $this->cedula = $datos[0];
    $this->nombre = $datos[1];
    $this->apellido = $datos[2];
    $this->telefono = $datos[3];
    $this->celular = $datos[4];
    $this->profesion = $datos[5];
    $this->factura = $datos[6];
    $this->fecha_compra = date('Y-m-d',strtotime($datos[7]));
    $this->monto = $datos[8];
    $this->pago_mes = $datos[9];
    $this->numero_giros = $datos[10];
    $this->fecha_cancelacion = date('Y-m-d',strtotime($datos[11]));
    $this->experiencia = $datos[12];
    
  }
  
  public function setMetadata($value)
  {
    $this->metadata = $value;
  }

  public function getMetadata()
  {
    return $this->metadata;
  }
  
}

?>