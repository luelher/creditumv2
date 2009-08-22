using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Web;
using System.Web.Services;
using CREDITUM.Importar;
using GrupoEmporium.Datos;
using GrupoEmporium.Varias;
using MySQLDriverCS;


namespace CREDITUM.Importar
{
	/// <summary>
	/// Descripción breve de Service1.
	/// </summary>
	public class Servicio_Importar : System.Web.Services.WebService
	{

		private clsBDConexion CONN;
		private BaseDatos BD = new BaseDatos();
		private MySQLConnection OleConexion;
		private int Cod_CC;
		private DateTime Ultima_Fecha;

		public Servicio_Importar()
		{
			//CODEGEN: llamada necesaria para el Diseñador de servicios Web ASP .NET
			InitializeComponent();
		}

		#region Código generado por el Diseñador de componentes
		
		//Requerido por el Diseñador de servicios Web 
		private IContainer components = null;
				
		/// <summary>
		/// Método necesario para admitir el Diseñador. No se puede modificar
		/// el contenido del método con el editor de código.
		/// </summary>
		private void InitializeComponent()
		{
		}

		/// <summary>
		/// Limpiar los recursos que se estén utilizando.
		/// </summary>
		protected override void Dispose( bool disposing )
		{
			if(disposing && components != null)
			{
				components.Dispose();
			}
			base.Dispose(disposing);		
		}
		
		#endregion

		#region Servicio Web

		[WebMethod]
		public int Importar(DataSet Datos,int Codigo)
		{
			// 1- Revisar Casa Comercial
			// 2- Revisar Cedulas de la informacion crediticia
			// 3- Buscar si existe registro en la tabla clientes_personas
			// 4- Verificar si el registro es nuevo, o ya existen en la BD
			
			string sql="";
			DataSet DSConfig = new DataSet();
			DataTable DT = new DataTable();

			CONN = Conectar(out DSConfig);
			int Conta=0;
			Cod_CC = Codigo;

			try
			{				
				OleConexion = new MySQLConnection(CONN.StringConexion);
				OleConexion.Open();
			}
			catch(Exception ex)
			{return -1;}


			sql="SELECT clientes.NOMBRE FROM clientes WHERE clientes.ID_CLIENTE=" + Codigo.ToString();

			if (BD.EjecutarQuery(CONN,OleConexion,sql,out DT)==true)
			{
				if (DT.Rows.Count>0)
				{
					// El cliente existe
					if (Datos.Tables["CREDITOS"].Rows.Count>0)
					{
						sql= "SELECT MAX(creditos.FECHA_OPERACION)" +
							" FROM clientes_personas" +
							" INNER JOIN creditos ON (clientes_personas.ID_CLIENTE_PERSONA = creditos.ID_CLIENTE_PERSONA)" +
							" WHERE clientes_personas.ID_CLIENTE = " + Codigo.ToString() +
							" GROUP BY clientes_personas.ID_CLIENTE;";
						BD.EjecutarQuery(CONN,OleConexion,sql,out DT);

						try
						{Ultima_Fecha = Convert.ToDateTime(DT.Rows[0].ItemArray[0].ToString());}
						catch
						{Ultima_Fecha = DateTime.Now;}
						
						TimeSpan Actual = DateTime.Now.Subtract(Ultima_Fecha);

						if (Actual.Days >= 0)
						{
							// Se analizan todos los registros obtenidos
							Registro Reg;
							int ID_CLIENTE_PERSONA;
							for (int i=0;i<Datos.Tables["CREDITOS"].Rows.Count;i++)
							{
								Reg = new Registro(Datos.Tables["CREDITOS"].Rows[i]);
								if (Reg.ID_CLIENTE.ToUpper().Substring(0,1)=="J")
								{
									ID_CLIENTE_PERSONA = VerificarJuridica(Reg);
								}
								else
								{
									ID_CLIENTE_PERSONA = VerificarNatural(Reg);
								}
								if (ID_CLIENTE_PERSONA!=-1)
								{
									if (!RevisarRegistro(Reg,ID_CLIENTE_PERSONA))
									{Conta++;}
								}
							}
							ActualizarCliente(Datos.Tables["CREDITOS"].Rows.Count - Conta,Codigo);
							OleConexion.Close();
							return Conta;
						}
						else 
						{
							EscribirLog("El cliente " + Codigo.ToString() + " ya fue procesado para este mes. " + DateTime.Now.Date.ToString());
							return -1;
						}
						}
					else return 0;
				}
				else
				{
					EscribirLog("no se encontro del codigo " + Codigo.ToString() + " a las " + DateTime.Now.Date.ToString());
					return -1;
				}
			}
			else
			{
				// El Cliente no existe, no se procesan los datos
				EscribirLog("Error al procesar el codigo " + Codigo.ToString() + " a las " + DateTime.Now.Date.ToString());
				return -1;
			}
		}

		#endregion

		#region Metodos estaticos

		private static clsBDConexion Conectar(out DataSet ds)
		{
			ds = new DataSet();
			try
			{
				#region CargarConfig
				ds.ReadXml(@"c:\Config.xml", XmlReadMode.ReadSchema);
				clsBDConexion conn = new clsBDConexion(ds.Tables["Config"].Rows[0].ItemArray[0].ToString(),
					ds.Tables["Config"].Rows[0].ItemArray[1].ToString(),
					ds.Tables["Config"].Rows[0].ItemArray[2].ToString(),
					ds.Tables["Config"].Rows[0].ItemArray[3].ToString());
				#endregion
				return conn;
			}
			catch
			{
				return null;
			}
		}


		#endregion

		#region Metodos Privados

		private int VerificarJuridica(Registro R)
		{
			// Verificar existencia o insertar en Personas juridicas
			// Verificar existencia o insertar en la tabla Clientes_Personas
			// Retornar el ID_CLIENTE_PERSONA resultante
			string sql="";
			DataTable DT = new DataTable();

			sql = "SELECT NOMBRE FROM personas_juridicas WHERE RIF='" + R.ID_CLIENTE + "'";
			
			if (BD.EjecutarQuery(CONN,OleConexion,sql,out DT))
			{
				if (DT.Rows.Count>0)
				{
					sql = "SELECT ID_CLIENTE_PERSONA FROM clientes_personas WHERE ID_PERSONA='" + R.ID_CLIENTE + "' AND ID_CLIENTE=" + Cod_CC.ToString();
					BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
					if (DT.Rows.Count>0)
					{
						return Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString());
					}
					else
					{
						sql="INSERT INTO clientes_personas(ID_PERSONA,ID_CLIENTE) VALUES('" + R.ID_CLIENTE + "'," + Cod_CC + ")";
						if (BD.EjecutarNonQuery(CONN,OleConexion,sql)!=-1)
						{
							sql = "SELECT ID_CLIENTE_PERSONA FROM clientes_personas WHERE ID_PERSONA='" + R.ID_CLIENTE + "' AND ID_CLIENTE=" + Cod_CC.ToString();
							BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
							if (DT.Rows.Count>0)
							{
								return Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString());
							}
							else return -1;
						}
						else return -1;
					}
				}
				else
				{
					sql="INSERT INTO personas_juridicas(RIF,NIT,NOMBRE,TELEFONO,DIRECCION,FAX,EMAIL) VALUES ('" + R.ID_CLIENTE + "','','" + R.NOMBRE + "','" + R.TELEFONO + "','','')";
					BD.EjecutarNonQuery(CONN,OleConexion,sql);

					sql="INSERT INTO clientes_personas(ID_PERSONA,ID_CLIENTE) VALUES('" + R.ID_CLIENTE + "'," + Cod_CC + ")";
					if (BD.EjecutarNonQuery(CONN,OleConexion,sql)!=-1)
					{
						sql = "SELECT ID_CLIENTE_PERSONA FROM clientes_personas WHERE ID_PERSONA='" + R.ID_CLIENTE + "' AND ID_CLIENTE=" + Cod_CC.ToString();
						BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
						if (DT.Rows.Count>0)
						{
							return Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString());
						}
						else return -1;
					}
					else return -1;
				}
			}
			else
			{return -1;}
		}


		private int VerificarNatural(Registro R)
		{
			// Verificar existencia o insertar en Personas naturales
			// Verificar existencia o insertar en la tabla Clientes_Personas
			// Retornar el ID_CLIENTE_PERSONA resultante
			string sql="";
			DataTable DT = new DataTable();

			sql = "SELECT NOMBRE FROM personas_naturales WHERE CEDULA='" + R.ID_CLIENTE + "'";
			
			if (BD.EjecutarQuery(CONN,OleConexion,sql,out DT))
			{
				if (DT.Rows.Count>0)
				{
					sql = "SELECT ID_CLIENTE_PERSONA FROM clientes_personas WHERE ID_PERSONA='" + R.ID_CLIENTE + "' AND ID_CLIENTE=" + Cod_CC.ToString();
					BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
					if (DT.Rows.Count>0)
					{
						return Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString());
					}
					else
					{
						sql="INSERT INTO clientes_personas(ID_PERSONA,ID_CLIENTE) VALUES('" + R.ID_CLIENTE + "'," + Cod_CC + ")";
						if (BD.EjecutarNonQuery(CONN,OleConexion,sql)!=-1)
						{
							sql = "SELECT ID_CLIENTE_PERSONA FROM clientes_personas WHERE ID_PERSONA='" + R.ID_CLIENTE + "' AND ID_CLIENTE=" + Cod_CC.ToString();
							BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
							if (DT.Rows.Count>0)
							{
								return Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString());
							}
							else return -1;
						}
						else return -1;
					}
				}
				else
				{
					sql="INSERT INTO personas_naturales(CEDULA,NOMBRE,APELLIDO,TELEFONO,CELULAR,PROFESION) " +
						"VALUES ('" + R.ID_CLIENTE + "','" + R.NOMBRE + "','" + R.APELLIDO + "','" + R.TELEFONO + "','" + R.CELULAR + "','" + R.PROFESION + "')";
					BD.EjecutarNonQuery(CONN,OleConexion,sql);

					sql="INSERT INTO clientes_personas(ID_PERSONA,ID_CLIENTE) VALUES('" + R.ID_CLIENTE + "'," + Cod_CC + ")";
					if (BD.EjecutarNonQuery(CONN,OleConexion,sql)!=-1)
					{
						sql = "SELECT ID_CLIENTE_PERSONA FROM clientes_personas WHERE ID_PERSONA='" + R.ID_CLIENTE + "' AND ID_CLIENTE=" + Cod_CC.ToString();
						BD.EjecutarQuery(CONN,OleConexion,sql,out DT);
						if (DT.Rows.Count>0)
						{
							return Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString());
						}
						else return -1;
					}
					else return -1;
				}
				
			}
			else
			{return -1;}

		}


		private bool RevisarRegistro(Registro R, int ID_CLI_PER)
		{
			// Se busca si el registro existe (ID_CLI_PER,FACTURA,FECHA_COMPRA,MONTO)

			string sql="";
			DataTable DT = new DataTable();
			int Estado;

			sql="SELECT ID,Experiencia FROM creditos WHERE ID_CLIENTE_PERSONA=" + ID_CLI_PER + " AND FACTURA='" + R.FACTURA + "' AND FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "'";
			BD.EjecutarQuery(CONN,OleConexion,sql,out DT);

			if (R.FECHA_CANCELACION==DateTime.MinValue) Estado=0;
			else Estado=1;

			if (DT.Rows.Count>0)
			{
				if(R.EXPERIENCIA>Convert.ToInt32(DT.Rows[0]["Experiencia"].ToString()))
				{
					// Existe, Actualizar
					if(Estado==0)
					{
						sql= "UPDATE creditos SET ID_CLIENTE_PERSONA=" + ID_CLI_PER.ToString() + ",FACTURA='" + R.FACTURA + "',FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "',FECHA_OPERACION='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(DateTime.Now) + "',MONTO=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.MONTO.ToString()) + ",PAGO_MES=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.PAGO_MES.ToString()) + ",NUM_GIROS=" + R.NUM_GIROS.ToString() + ",EXPERIENCIA=" + R.EXPERIENCIA.ToString() + ", ESTADO=" + Estado.ToString() +
							" WHERE ID_CLIENTE_PERSONA=" + ID_CLI_PER + " AND FACTURA='" + R.FACTURA + "' AND FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "'";
					}
					else
					{
						sql= "UPDATE creditos SET ID_CLIENTE_PERSONA=" + ID_CLI_PER.ToString() + ",FACTURA='" + R.FACTURA + "',FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "',FECHA_OPERACION='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_CANCELACION.Date) + "',MONTO=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.MONTO.ToString()) + ",PAGO_MES=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.PAGO_MES.ToString()) + ",NUM_GIROS=" + R.NUM_GIROS.ToString() + ",EXPERIENCIA=" + R.EXPERIENCIA.ToString() + ", ESTADO=" + Estado.ToString() +
							" WHERE ID_CLIENTE_PERSONA=" + ID_CLI_PER + " AND FACTURA='" + R.FACTURA + "' AND FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "'";
					}

					if (BD.EjecutarNonQuery(CONN,OleConexion,sql)==-1) return false;
				}
				else
				{
					if(Estado==0)
					{
						sql= "UPDATE creditos SET ID_CLIENTE_PERSONA=" + ID_CLI_PER.ToString() + ",FACTURA='" + R.FACTURA + "',FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "',FECHA_OPERACION='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(DateTime.Now) + "',MONTO=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.MONTO.ToString()) + ",PAGO_MES=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.PAGO_MES.ToString()) + ",NUM_GIROS=" + R.NUM_GIROS.ToString() + ", ESTADO=" + Estado.ToString() +
							" WHERE ID_CLIENTE_PERSONA=" + ID_CLI_PER + " AND FACTURA='" + R.FACTURA + "' AND FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "'";
					}
					else
					{
						sql= "UPDATE creditos SET ID_CLIENTE_PERSONA=" + ID_CLI_PER.ToString() + ",FACTURA='" + R.FACTURA + "',FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "',FECHA_OPERACION='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_CANCELACION.Date) + "',MONTO=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.MONTO.ToString()) + ",PAGO_MES=" + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.PAGO_MES.ToString()) + ",NUM_GIROS=" + R.NUM_GIROS.ToString() + ", ESTADO=" + Estado.ToString() +
							" WHERE ID_CLIENTE_PERSONA=" + ID_CLI_PER + " AND FACTURA='" + R.FACTURA + "' AND FECHA_COMPRA='" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "'";
					}

					if (BD.EjecutarNonQuery(CONN,OleConexion,sql)==-1) return false;
				}

			}
			else
			{
				// No Existe, Insertar
				if(Estado==0)
				{
					sql= "INSERT INTO creditos(ID_CLIENTE_PERSONA,FACTURA,FECHA_COMPRA,FECHA_OPERACION,MONTO,PAGO_MES,NUM_GIROS,EXPERIENCIA,ESTADO) " +
						" VALUES(" + ID_CLI_PER + ",'" + R.FACTURA + "','" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "','" + GrupoEmporium.Varias.Conversiones.ToDateMysql(DateTime.Now) + "'," + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.MONTO.ToString()) + "," + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.PAGO_MES.ToString()) + "," + R.NUM_GIROS.ToString() + "," + R.EXPERIENCIA.ToString() + "," + Estado.ToString() + ")";
				}
				else
				{
					sql= "INSERT INTO creditos(ID_CLIENTE_PERSONA,FACTURA,FECHA_COMPRA,FECHA_OPERACION,MONTO,PAGO_MES,NUM_GIROS,EXPERIENCIA,ESTADO) " +
						" VALUES(" + ID_CLI_PER + ",'" + R.FACTURA + "','" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_COMPRA) + "','" + GrupoEmporium.Varias.Conversiones.ToDateMysql(R.FECHA_CANCELACION.Date) + "'," + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.MONTO.ToString()) + "," + GrupoEmporium.Varias.Clase_ValidarDBL.ComaXPunto(R.PAGO_MES.ToString()) + "," + R.NUM_GIROS.ToString() + "," + R.EXPERIENCIA.ToString() + "," + Estado.ToString() + ")";
				}

				if (BD.EjecutarNonQuery(CONN,OleConexion,sql)==-1) return false;
			}
			return true;
		}


		private void ActualizarCliente(int Cantidad,int Cliente)
		{
			string sql="";
			DataTable DT = new DataTable();

			sql= "SELECT CONSULTAS FROM clientes_conf WHERE ID_CLIENTE=" + Cliente;
			if (BD.EjecutarQuery(CONN,OleConexion,sql,out DT))
			{
				if (DT.Rows.Count>0)
				{
					int Suma= Convert.ToInt32(DT.Rows[0].ItemArray[0].ToString()) + Cantidad;
					sql= "UPDATE clientes_conf SET CONSULTAS=" + Suma.ToString() + " WHERE ID_CLIENTE=" + Cliente;
					BD.EjecutarNonQuery(CONN,OleConexion,sql);

					//Colocar aqui informacion del cliente que se conecta
					sql= "SELECT clientes.NOMBRE AS CLIENTE,  casas_comerciales.NOMBRE AS CASACOMERCIAL " +
						" FROM clientes LEFT JOIN casas_comerciales ON (clientes.ID_CASA_COMERCIAL = casas_comerciales.ID_CASA_COMERCIAL) " +
						" WHERE clientes.ID_Cliente=" + Cliente.ToString();
					DataTable DTCliente = new DataTable();
					BD.EjecutarQuery( CONN,OleConexion,sql,out DTCliente);

					string NombreCliente = DTCliente.Rows[0][0].ToString() + " - " + DTCliente.Rows[0][1].ToString();
					NombreCliente = NombreCliente.PadRight(36,Convert.ToChar(" "));


					EscribirLog(Cantidad.ToString() + "		" + Cliente.ToString() + "		" + NombreCliente + "	" + DateTime.Now.ToString());
				}
				else
				{EscribirLog(Cantidad.ToString() + "		" + Cliente.ToString() + "		" + "No esta registrada como un cliente. ".PadRight(36,Convert.ToChar(" ")) + "	"  + DateTime.Now.ToString());}
			}
			else
			{EscribirLog(Cantidad.ToString() + "		" + Cliente.ToString() + "		" + "Error al actualizar el Cliente".PadRight(36,Convert.ToChar(" ")) + "	" + DateTime.Now.ToString());}
		}


		private void EscribirLog(string info)
		{
			string archivo = @"c:\Log\Importacion.Log";

			if (!System.IO.Directory.Exists(@"c:\Log")) System.IO.Directory.CreateDirectory(@"c:\Log");

			if (System.IO.File.Exists(archivo))
			{
				System.IO.StreamWriter SW = System.IO.File.AppendText(archivo);
				SW.WriteLine(info);
				SW.Close();
			}
			else
			{
				System.IO.StreamWriter SW = System.IO.File.CreateText(archivo);
				SW.WriteLine(info);
				SW.Close();				
			}
		}


		#endregion

		#region Estructuras

		private struct Registro
		{
			public string ID_CLIENTE;
			public string NOMBRE;
			public string APELLIDO;
			public string TELEFONO;
			public string CELULAR;
			public string PROFESION;
			public string FACTURA;
			public DateTime FECHA_COMPRA;
			public double MONTO;
			public double PAGO_MES;
			public int NUM_GIROS;
			public DateTime FECHA_CANCELACION;
			public int EXPERIENCIA;

			public Registro(DataRow DR)
			{
				ID_CLIENTE = DR.ItemArray[0].ToString();
				NOMBRE= DR.ItemArray[1].ToString();
				APELLIDO= DR.ItemArray[2].ToString();
				TELEFONO= DR.ItemArray[3].ToString();
				CELULAR= DR.ItemArray[4].ToString();
				PROFESION= DR.ItemArray[5].ToString();
				FACTURA= DR.ItemArray[6].ToString();
				try
				{FECHA_COMPRA= Convert.ToDateTime(DR.ItemArray[7].ToString());}
				catch
				{FECHA_COMPRA= DateTime.MaxValue;}
				MONTO= Convert.ToDouble(DR.ItemArray[8].ToString());
				PAGO_MES= Convert.ToDouble(DR.ItemArray[9].ToString());
				NUM_GIROS= Convert.ToInt32(DR.ItemArray[10].ToString());
				try
				{FECHA_CANCELACION= Convert.ToDateTime(DR.ItemArray[11].ToString());}
				catch
				{FECHA_CANCELACION= DateTime.MinValue;}
				EXPERIENCIA= Convert.ToInt32(DR.ItemArray[12].ToString());
			}
		}


			#endregion


		}
}
