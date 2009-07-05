<?php


/**
 * This class adds structure of 'clientes_personas' table to 'propel' DatabaseMap object.
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
class ClientesPersonasMapBuilder implements MapBuilder {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.ClientesPersonasMapBuilder';

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
		$this->dbMap = Propel::getDatabaseMap(ClientesPersonasPeer::DATABASE_NAME);

		$tMap = $this->dbMap->addTable(ClientesPersonasPeer::TABLE_NAME);
		$tMap->setPhpName('ClientesPersonas');
		$tMap->setClassname('ClientesPersonas');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('ID_PERSONA', 'IdPersona', 'VARCHAR', true, 15);

		$tMap->addPrimaryKey('ID_CLIENTE_PERSONA', 'IdClientePersona', 'INTEGER', true, 11);

		$tMap->addColumn('ID_CLIENTE', 'IdCliente', 'INTEGER', true, 11);

	} // doBuild()

} // ClientesPersonasMapBuilder