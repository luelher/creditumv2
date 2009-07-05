<?php


/**
 * This class adds structure of 'empresa_conf' table to 'propel' DatabaseMap object.
 *
 *
 * This class was autogenerated by Propel 1.3.0-dev on:
 *
 * Sun Mar 29 23:53:01 2009
 *
 *
 * These statically-built map classes are used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class EmpresaConfMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.EmpresaConfMapBuilder';

	/**
	 * The database map.
	 */
	private $dbMap;

	/**
	 * Tells us if this DatabaseMapBuilder is built so that we
	 * don't have to re-build it every time.
	 *
	 * @return     boolean true if this DatabaseMapBuilder is built, false otherwise.
	 */
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	/**
	 * Gets the databasemap this map builder built.
	 *
	 * @return     the databasemap
	 */
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	/**
	 * The doBuild() method builds the DatabaseMap
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap(EmpresaConfPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(EmpresaConfPeer::TABLE_NAME);
		$tMap->setPhpName('EmpresaConf');
		$tMap->setClassname('EmpresaConf');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('ID_CLIENTE', 'IdCliente', 'INTEGER', true, 11);

		$tMap->addColumn('WEB', 'Web', 'VARCHAR', true, 50);

		$tMap->addColumn('PRECIO_OK1', 'PrecioOk1', 'FLOAT', true, null);

		$tMap->addColumn('PRECIO_OK2', 'PrecioOk2', 'FLOAT', true, null);

		$tMap->addColumn('PRECIO_OK3', 'PrecioOk3', 'FLOAT', true, null);

		$tMap->addColumn('PRECIO_OK4', 'PrecioOk4', 'FLOAT', true, null);

		$tMap->addColumn('PRECIO_FALLIDA', 'PrecioFallida', 'FLOAT', true, null);

		$tMap->addPrimaryKey('ID', 'Id', 'INTEGER', true, null);

	} // doBuild()

} // EmpresaConfMapBuilder