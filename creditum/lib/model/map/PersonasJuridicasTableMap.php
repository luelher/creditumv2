<?php


/**
 * This class defines the structure of the 'personas_juridicas' table.
 *
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu Dec 27 14:37:59 2012
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class PersonasJuridicasTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.PersonasJuridicasTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('personas_juridicas');
		$this->setPhpName('PersonasJuridicas');
		$this->setClassname('PersonasJuridicas');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addPrimaryKey('RIF', 'Rif', 'VARCHAR', true, 15, '');
		$this->addColumn('NIT', 'Nit', 'VARCHAR', true, 10, '');
		$this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 30, '');
		$this->addColumn('TELEFONO', 'Telefono', 'VARCHAR', false, 15, null);
		$this->addColumn('DIRECCION', 'Direccion', 'VARCHAR', false, 100, null);
		$this->addColumn('FAX', 'Fax', 'VARCHAR', false, 15, null);
		$this->addColumn('EMAIL', 'Email', 'VARCHAR', false, 30, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
	} // buildRelations()

	/**
	 * 
	 * Gets the list of behaviors registered for this table
	 * 
	 * @return array Associative array (name => parameters) of behaviors
	 */
	public function getBehaviors()
	{
		return array(
			'symfony' => array('form' => 'true', 'filter' => 'true', ),
			'symfony_behaviors' => array(),
		);
	} // getBehaviors()

} // PersonasJuridicasTableMap
