<?php

namespace UAM\Bundle\AwsBundle\Propel;

use \Behavior;

class S3ObjectBehavior extends Behavior{

	protected $parameters = array(
		'region_column' => 'region',
		'bucket_column' => 'bucket',
		'key_column' => 'key',
		'original_filename_column' => 'original_filename',
		'default_region' => null,
		'default_bucket' => null
	);

	protected $objectBuilderModifier;

	public function getObjectBuilderModifier()
	{
		if (is_null($this->objectBuilderModifier)) {
			$this->objectBuilderModifier = new S3ObjectBehaviorObjectBuilderModifier($this);
		}

		return $this->objectBuilderModifier;
	}

	public function modifyTable()
	{
		$table = $this->getTable();

		$columnName = $this->getParameter('region_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 20,
				'default' => $this->getParameter('default_region')
			));
		}

		$columnName = $this->getParameter('bucket_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 63,
				'default' => $this->getParameter('default_bucket')
			));
		}

		$columnName = $this->getParameter('key_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 255
			));
		}

		$columnName = $this->getParameter('original_filename_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 100
			));
		}
	}
}