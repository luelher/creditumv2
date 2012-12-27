<?php

/**
 * Base class that represents a row from the 'empresa_conf' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Thu Dec 27 14:37:59 2012
 *
 * @package    lib.model.om
 */
abstract class BaseEmpresaConf extends BaseObject  implements Persistent {


	/**
	 * The Peer class.
	 * Instance provides a convenient way of calling static methods on a class
	 * that calling code may not be able to identify.
	 * @var        EmpresaConfPeer
	 */
	protected static $peer;

	/**
	 * The value for the id_cliente field.
	 * Note: this column has a database default value of: 0
	 * @var        int
	 */
	protected $id_cliente;

	/**
	 * The value for the web field.
	 * Note: this column has a database default value of: ''
	 * @var        string
	 */
	protected $web;

	/**
	 * The value for the precio_ok1 field.
	 * Note: this column has a database default value of: 0
	 * @var        double
	 */
	protected $precio_ok1;

	/**
	 * The value for the precio_ok2 field.
	 * Note: this column has a database default value of: 0
	 * @var        double
	 */
	protected $precio_ok2;

	/**
	 * The value for the precio_ok3 field.
	 * Note: this column has a database default value of: 0
	 * @var        double
	 */
	protected $precio_ok3;

	/**
	 * The value for the precio_ok4 field.
	 * Note: this column has a database default value of: 0
	 * @var        double
	 */
	protected $precio_ok4;

	/**
	 * The value for the precio_fallida field.
	 * Note: this column has a database default value of: 0
	 * @var        double
	 */
	protected $precio_fallida;

	/**
	 * The value for the id field.
	 * @var        int
	 */
	protected $id;

	/**
	 * Flag to prevent endless save loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInSave = false;

	/**
	 * Flag to prevent endless validation loop, if this object is referenced
	 * by another object which falls in this transaction.
	 * @var        boolean
	 */
	protected $alreadyInValidation = false;

	// symfony behavior
	
	const PEER = 'EmpresaConfPeer';

	/**
	 * Applies default values to this object.
	 * This method should be called from the object's constructor (or
	 * equivalent initialization method).
	 * @see        __construct()
	 */
	public function applyDefaultValues()
	{
		$this->id_cliente = 0;
		$this->web = '';
		$this->precio_ok1 = 0;
		$this->precio_ok2 = 0;
		$this->precio_ok3 = 0;
		$this->precio_ok4 = 0;
		$this->precio_fallida = 0;
	}

	/**
	 * Initializes internal state of BaseEmpresaConf object.
	 * @see        applyDefaults()
	 */
	public function __construct()
	{
		parent::__construct();
		$this->applyDefaultValues();
	}

	/**
	 * Get the [id_cliente] column value.
	 * 
	 * @return     int
	 */
	public function getIdCliente()
	{
		return $this->id_cliente;
	}

	/**
	 * Get the [web] column value.
	 * 
	 * @return     string
	 */
	public function getWeb()
	{
		return $this->web;
	}

	/**
	 * Get the [precio_ok1] column value.
	 * 
	 * @return     double
	 */
	public function getPrecioOk1()
	{
		return $this->precio_ok1;
	}

	/**
	 * Get the [precio_ok2] column value.
	 * 
	 * @return     double
	 */
	public function getPrecioOk2()
	{
		return $this->precio_ok2;
	}

	/**
	 * Get the [precio_ok3] column value.
	 * 
	 * @return     double
	 */
	public function getPrecioOk3()
	{
		return $this->precio_ok3;
	}

	/**
	 * Get the [precio_ok4] column value.
	 * 
	 * @return     double
	 */
	public function getPrecioOk4()
	{
		return $this->precio_ok4;
	}

	/**
	 * Get the [precio_fallida] column value.
	 * 
	 * @return     double
	 */
	public function getPrecioFallida()
	{
		return $this->precio_fallida;
	}

	/**
	 * Get the [id] column value.
	 * 
	 * @return     int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set the value of [id_cliente] column.
	 * 
	 * @param      int $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setIdCliente($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id_cliente !== $v || $this->isNew()) {
			$this->id_cliente = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::ID_CLIENTE;
		}

		return $this;
	} // setIdCliente()

	/**
	 * Set the value of [web] column.
	 * 
	 * @param      string $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setWeb($v)
	{
		if ($v !== null) {
			$v = (string) $v;
		}

		if ($this->web !== $v || $this->isNew()) {
			$this->web = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::WEB;
		}

		return $this;
	} // setWeb()

	/**
	 * Set the value of [precio_ok1] column.
	 * 
	 * @param      double $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setPrecioOk1($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->precio_ok1 !== $v || $this->isNew()) {
			$this->precio_ok1 = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::PRECIO_OK1;
		}

		return $this;
	} // setPrecioOk1()

	/**
	 * Set the value of [precio_ok2] column.
	 * 
	 * @param      double $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setPrecioOk2($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->precio_ok2 !== $v || $this->isNew()) {
			$this->precio_ok2 = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::PRECIO_OK2;
		}

		return $this;
	} // setPrecioOk2()

	/**
	 * Set the value of [precio_ok3] column.
	 * 
	 * @param      double $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setPrecioOk3($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->precio_ok3 !== $v || $this->isNew()) {
			$this->precio_ok3 = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::PRECIO_OK3;
		}

		return $this;
	} // setPrecioOk3()

	/**
	 * Set the value of [precio_ok4] column.
	 * 
	 * @param      double $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setPrecioOk4($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->precio_ok4 !== $v || $this->isNew()) {
			$this->precio_ok4 = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::PRECIO_OK4;
		}

		return $this;
	} // setPrecioOk4()

	/**
	 * Set the value of [precio_fallida] column.
	 * 
	 * @param      double $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setPrecioFallida($v)
	{
		if ($v !== null) {
			$v = (double) $v;
		}

		if ($this->precio_fallida !== $v || $this->isNew()) {
			$this->precio_fallida = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::PRECIO_FALLIDA;
		}

		return $this;
	} // setPrecioFallida()

	/**
	 * Set the value of [id] column.
	 * 
	 * @param      int $v new value
	 * @return     EmpresaConf The current object (for fluent API support)
	 */
	public function setId($v)
	{
		if ($v !== null) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = EmpresaConfPeer::ID;
		}

		return $this;
	} // setId()

	/**
	 * Indicates whether the columns in this object are only set to default values.
	 *
	 * This method can be used in conjunction with isModified() to indicate whether an object is both
	 * modified _and_ has some values set which are non-default.
	 *
	 * @return     boolean Whether the columns in this object are only been set with default values.
	 */
	public function hasOnlyDefaultValues()
	{
			if ($this->id_cliente !== 0) {
				return false;
			}

			if ($this->web !== '') {
				return false;
			}

			if ($this->precio_ok1 !== 0) {
				return false;
			}

			if ($this->precio_ok2 !== 0) {
				return false;
			}

			if ($this->precio_ok3 !== 0) {
				return false;
			}

			if ($this->precio_ok4 !== 0) {
				return false;
			}

			if ($this->precio_fallida !== 0) {
				return false;
			}

		// otherwise, everything was equal, so return TRUE
		return true;
	} // hasOnlyDefaultValues()

	/**
	 * Hydrates (populates) the object variables with values from the database resultset.
	 *
	 * An offset (0-based "start column") is specified so that objects can be hydrated
	 * with a subset of the columns in the resultset rows.  This is needed, for example,
	 * for results of JOIN queries where the resultset row includes columns from two or
	 * more tables.
	 *
	 * @param      array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
	 * @param      int $startcol 0-based offset column which indicates which restultset column to start with.
	 * @param      boolean $rehydrate Whether this object is being re-hydrated from the database.
	 * @return     int next starting column
	 * @throws     PropelException  - Any caught Exception will be rewrapped as a PropelException.
	 */
	public function hydrate($row, $startcol = 0, $rehydrate = false)
	{
		try {

			$this->id_cliente = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
			$this->web = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
			$this->precio_ok1 = ($row[$startcol + 2] !== null) ? (double) $row[$startcol + 2] : null;
			$this->precio_ok2 = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
			$this->precio_ok3 = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
			$this->precio_ok4 = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
			$this->precio_fallida = ($row[$startcol + 6] !== null) ? (double) $row[$startcol + 6] : null;
			$this->id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
			$this->resetModified();

			$this->setNew(false);

			if ($rehydrate) {
				$this->ensureConsistency();
			}

			// FIXME - using NUM_COLUMNS may be clearer.
			return $startcol + 8; // 8 = EmpresaConfPeer::NUM_COLUMNS - EmpresaConfPeer::NUM_LAZY_LOAD_COLUMNS).

		} catch (Exception $e) {
			throw new PropelException("Error populating EmpresaConf object", $e);
		}
	}

	/**
	 * Checks and repairs the internal consistency of the object.
	 *
	 * This method is executed after an already-instantiated object is re-hydrated
	 * from the database.  It exists to check any foreign keys to make sure that
	 * the objects related to the current object are correct based on foreign key.
	 *
	 * You can override this method in the stub class, but you should always invoke
	 * the base method from the overridden method (i.e. parent::ensureConsistency()),
	 * in case your model changes.
	 *
	 * @throws     PropelException
	 */
	public function ensureConsistency()
	{

	} // ensureConsistency

	/**
	 * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
	 *
	 * This will only work if the object has been saved and has a valid primary key set.
	 *
	 * @param      boolean $deep (optional) Whether to also de-associated any related objects.
	 * @param      PropelPDO $con (optional) The PropelPDO connection to use.
	 * @return     void
	 * @throws     PropelException - if this object is deleted, unsaved or doesn't have pk match in db
	 */
	public function reload($deep = false, PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("Cannot reload a deleted object.");
		}

		if ($this->isNew()) {
			throw new PropelException("Cannot reload an unsaved object.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmpresaConfPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}

		// We don't need to alter the object instance pool; we're just modifying this instance
		// already in the pool.

		$stmt = EmpresaConfPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
		$row = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		if (!$row) {
			throw new PropelException('Cannot find matching row in the database to reload object values.');
		}
		$this->hydrate($row, 0, true); // rehydrate

		if ($deep) {  // also de-associate any related objects?

		} // if (deep)
	}

	/**
	 * Removes this object from datastore and sets delete attribute.
	 *
	 * @param      PropelPDO $con
	 * @return     void
	 * @throws     PropelException
	 * @see        BaseObject::setDeleted()
	 * @see        BaseObject::isDeleted()
	 */
	public function delete(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmpresaConfPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		try {
			$ret = $this->preDelete($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEmpresaConf:delete:pre') as $callable)
			{
			  if (call_user_func($callable, $this, $con))
			  {
			    $con->commit();
			
			    return;
			  }
			}

			if ($ret) {
				EmpresaConfPeer::doDelete($this, $con);
				$this->postDelete($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEmpresaConf:delete:post') as $callable)
				{
				  call_user_func($callable, $this, $con);
				}

				$this->setDeleted(true);
				$con->commit();
			} else {
				$con->commit();
			}
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Persists this object to the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All modified related objects will also be persisted in the doSave()
	 * method.  This method wraps all precipitate database operations in a
	 * single transaction.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        doSave()
	 */
	public function save(PropelPDO $con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(EmpresaConfPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
		}
		
		$con->beginTransaction();
		$isInsert = $this->isNew();
		try {
			$ret = $this->preSave($con);
			// symfony_behaviors behavior
			foreach (sfMixer::getCallables('BaseEmpresaConf:save:pre') as $callable)
			{
			  if (is_integer($affectedRows = call_user_func($callable, $this, $con)))
			  {
			    $con->commit();
			
			    return $affectedRows;
			  }
			}

			if ($isInsert) {
				$ret = $ret && $this->preInsert($con);
			} else {
				$ret = $ret && $this->preUpdate($con);
			}
			if ($ret) {
				$affectedRows = $this->doSave($con);
				if ($isInsert) {
					$this->postInsert($con);
				} else {
					$this->postUpdate($con);
				}
				$this->postSave($con);
				// symfony_behaviors behavior
				foreach (sfMixer::getCallables('BaseEmpresaConf:save:post') as $callable)
				{
				  call_user_func($callable, $this, $con, $affectedRows);
				}

				EmpresaConfPeer::addInstanceToPool($this);
			} else {
				$affectedRows = 0;
			}
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollBack();
			throw $e;
		}
	}

	/**
	 * Performs the work of inserting or updating the row in the database.
	 *
	 * If the object is new, it inserts it; otherwise an update is performed.
	 * All related objects are also updated in this method.
	 *
	 * @param      PropelPDO $con
	 * @return     int The number of rows affected by this insert/update and any referring fk objects' save() operations.
	 * @throws     PropelException
	 * @see        save()
	 */
	protected function doSave(PropelPDO $con)
	{
		$affectedRows = 0; // initialize var to track total num of affected rows
		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;

			if ($this->isNew() ) {
				$this->modifiedColumns[] = EmpresaConfPeer::ID;
			}

			// If this object has been modified, then save it to the database.
			if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = EmpresaConfPeer::doInsert($this, $con);
					$affectedRows += 1; // we are assuming that there is only 1 row per doInsert() which
										 // should always be true here (even though technically
										 // BasePeer::doInsert() can insert multiple rows).

					$this->setId($pk);  //[IMV] update autoincrement primary key

					$this->setNew(false);
				} else {
					$affectedRows += EmpresaConfPeer::doUpdate($this, $con);
				}

				$this->resetModified(); // [HL] After being saved an object is no longer 'modified'
			}

			$this->alreadyInSave = false;

		}
		return $affectedRows;
	} // doSave()

	/**
	 * Array of ValidationFailed objects.
	 * @var        array ValidationFailed[]
	 */
	protected $validationFailures = array();

	/**
	 * Gets any ValidationFailed objects that resulted from last call to validate().
	 *
	 *
	 * @return     array ValidationFailed[]
	 * @see        validate()
	 */
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	/**
	 * Validates the objects modified field values and all objects related to this table.
	 *
	 * If $columns is either a column name or an array of column names
	 * only those columns are validated.
	 *
	 * @param      mixed $columns Column name or an array of column names.
	 * @return     boolean Whether all columns pass validation.
	 * @see        doValidate()
	 * @see        getValidationFailures()
	 */
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	/**
	 * This function performs the validation work for complex object models.
	 *
	 * In addition to checking the current object, all related objects will
	 * also be validated.  If all pass then <code>true</code> is returned; otherwise
	 * an aggreagated array of ValidationFailed objects will be returned.
	 *
	 * @param      array $columns Array of column names to validate.
	 * @return     mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
	 */
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = EmpresaConfPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	/**
	 * Retrieves a field from the object by name passed in as a string.
	 *
	 * @param      string $name name
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     mixed Value of field.
	 */
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EmpresaConfPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		$field = $this->getByPosition($pos);
		return $field;
	}

	/**
	 * Retrieves a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @return     mixed Value of field at $pos
	 */
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getIdCliente();
				break;
			case 1:
				return $this->getWeb();
				break;
			case 2:
				return $this->getPrecioOk1();
				break;
			case 3:
				return $this->getPrecioOk2();
				break;
			case 4:
				return $this->getPrecioOk3();
				break;
			case 5:
				return $this->getPrecioOk4();
				break;
			case 6:
				return $this->getPrecioFallida();
				break;
			case 7:
				return $this->getId();
				break;
			default:
				return null;
				break;
		} // switch()
	}

	/**
	 * Exports the object as an array.
	 *
	 * You can specify the key type of the array by passing one of the class
	 * type constants.
	 *
	 * @param      string $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                        BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. Defaults to BasePeer::TYPE_PHPNAME.
	 * @param      boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns.  Defaults to TRUE.
	 * @return     an associative array containing the field names (as keys) and field values
	 */
	public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true)
	{
		$keys = EmpresaConfPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getIdCliente(),
			$keys[1] => $this->getWeb(),
			$keys[2] => $this->getPrecioOk1(),
			$keys[3] => $this->getPrecioOk2(),
			$keys[4] => $this->getPrecioOk3(),
			$keys[5] => $this->getPrecioOk4(),
			$keys[6] => $this->getPrecioFallida(),
			$keys[7] => $this->getId(),
		);
		return $result;
	}

	/**
	 * Sets a field from the object by name passed in as a string.
	 *
	 * @param      string $name peer name
	 * @param      mixed $value field value
	 * @param      string $type The type of fieldname the $name is of:
	 *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
	 *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
	 * @return     void
	 */
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = EmpresaConfPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	/**
	 * Sets a field from the object by Position as specified in the xml schema.
	 * Zero-based.
	 *
	 * @param      int $pos position in xml schema
	 * @param      mixed $value field value
	 * @return     void
	 */
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setIdCliente($value);
				break;
			case 1:
				$this->setWeb($value);
				break;
			case 2:
				$this->setPrecioOk1($value);
				break;
			case 3:
				$this->setPrecioOk2($value);
				break;
			case 4:
				$this->setPrecioOk3($value);
				break;
			case 5:
				$this->setPrecioOk4($value);
				break;
			case 6:
				$this->setPrecioFallida($value);
				break;
			case 7:
				$this->setId($value);
				break;
		} // switch()
	}

	/**
	 * Populates the object using an array.
	 *
	 * This is particularly useful when populating an object from one of the
	 * request arrays (e.g. $_POST).  This method goes through the column
	 * names, checking to see whether a matching key exists in populated
	 * array. If so the setByName() method is called for that column.
	 *
	 * You can specify the key type of the array by additionally passing one
	 * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
	 * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
	 * The default key type is the column's phpname (e.g. 'AuthorId')
	 *
	 * @param      array  $arr     An array to populate the object from.
	 * @param      string $keyType The type of keys the array uses.
	 * @return     void
	 */
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = EmpresaConfPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setIdCliente($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setWeb($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPrecioOk1($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPrecioOk2($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPrecioOk3($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPrecioOk4($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setPrecioFallida($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setId($arr[$keys[7]]);
	}

	/**
	 * Build a Criteria object containing the values of all modified columns in this object.
	 *
	 * @return     Criteria The Criteria object containing all modified values.
	 */
	public function buildCriteria()
	{
		$criteria = new Criteria(EmpresaConfPeer::DATABASE_NAME);

		if ($this->isColumnModified(EmpresaConfPeer::ID_CLIENTE)) $criteria->add(EmpresaConfPeer::ID_CLIENTE, $this->id_cliente);
		if ($this->isColumnModified(EmpresaConfPeer::WEB)) $criteria->add(EmpresaConfPeer::WEB, $this->web);
		if ($this->isColumnModified(EmpresaConfPeer::PRECIO_OK1)) $criteria->add(EmpresaConfPeer::PRECIO_OK1, $this->precio_ok1);
		if ($this->isColumnModified(EmpresaConfPeer::PRECIO_OK2)) $criteria->add(EmpresaConfPeer::PRECIO_OK2, $this->precio_ok2);
		if ($this->isColumnModified(EmpresaConfPeer::PRECIO_OK3)) $criteria->add(EmpresaConfPeer::PRECIO_OK3, $this->precio_ok3);
		if ($this->isColumnModified(EmpresaConfPeer::PRECIO_OK4)) $criteria->add(EmpresaConfPeer::PRECIO_OK4, $this->precio_ok4);
		if ($this->isColumnModified(EmpresaConfPeer::PRECIO_FALLIDA)) $criteria->add(EmpresaConfPeer::PRECIO_FALLIDA, $this->precio_fallida);
		if ($this->isColumnModified(EmpresaConfPeer::ID)) $criteria->add(EmpresaConfPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Builds a Criteria object containing the primary key for this object.
	 *
	 * Unlike buildCriteria() this method includes the primary key values regardless
	 * of whether or not they have been modified.
	 *
	 * @return     Criteria The Criteria object containing value(s) for primary key(s).
	 */
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(EmpresaConfPeer::DATABASE_NAME);

		$criteria->add(EmpresaConfPeer::ID, $this->id);

		return $criteria;
	}

	/**
	 * Returns the primary key for this object (row).
	 * @return     int
	 */
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	/**
	 * Generic method to set the primary key (id column).
	 *
	 * @param      int $key Primary key.
	 * @return     void
	 */
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	/**
	 * Sets contents of passed object to values from current object.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      object $copyObj An object of EmpresaConf (or compatible) type.
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @throws     PropelException
	 */
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setIdCliente($this->id_cliente);

		$copyObj->setWeb($this->web);

		$copyObj->setPrecioOk1($this->precio_ok1);

		$copyObj->setPrecioOk2($this->precio_ok2);

		$copyObj->setPrecioOk3($this->precio_ok3);

		$copyObj->setPrecioOk4($this->precio_ok4);

		$copyObj->setPrecioFallida($this->precio_fallida);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); // this is a auto-increment column, so set to default value

	}

	/**
	 * Makes a copy of this object that will be inserted as a new row in table when saved.
	 * It creates a new object filling in the simple attributes, but skipping any primary
	 * keys that are defined for the table.
	 *
	 * If desired, this method can also make copies of all associated (fkey referrers)
	 * objects.
	 *
	 * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
	 * @return     EmpresaConf Clone of current object.
	 * @throws     PropelException
	 */
	public function copy($deepCopy = false)
	{
		// we use get_class(), because this might be a subclass
		$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	/**
	 * Returns a peer instance associated with this om.
	 *
	 * Since Peer classes are not to have any instance attributes, this method returns the
	 * same instance for all member of this class. The method could therefore
	 * be static, but this would prevent one from overriding the behavior.
	 *
	 * @return     EmpresaConfPeer
	 */
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new EmpresaConfPeer();
		}
		return self::$peer;
	}

	/**
	 * Resets all collections of referencing foreign keys.
	 *
	 * This method is a user-space workaround for PHP's inability to garbage collect objects
	 * with circular references.  This is currently necessary when using Propel in certain
	 * daemon or large-volumne/high-memory operations.
	 *
	 * @param      boolean $deep Whether to also clear the references on all associated objects.
	 */
	public function clearAllReferences($deep = false)
	{
		if ($deep) {
		} // if ($deep)

	}

	// symfony_behaviors behavior
	
	/**
	 * Calls methods defined via {@link sfMixer}.
	 */
	public function __call($method, $arguments)
	{
	  if (!$callable = sfMixer::getCallable('BaseEmpresaConf:'.$method))
	  {
	    throw new sfException(sprintf('Call to undefined method BaseEmpresaConf::%s', $method));
	  }
	
	  array_unshift($arguments, $this);
	
	  return call_user_func_array($callable, $arguments);
	}

} // BaseEmpresaConf
