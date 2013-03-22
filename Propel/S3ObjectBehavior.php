<?php

namespace UAM\Bundle\AwsBundle\Propel;

use \Behavior;

class S3ObjectBehavior extends Behavior{

	protected $parameters = array(
		'region_column' => 'region',
		'bucket_column' => 'bucket',
		'key_column' => 'key',
		'original_filename_column' => 'original_filename',
		'mime_type_column' => 'mime_type', 
		'size_column' => 'size',
		'with_dimensions' => true,
		'width_column' => 'width',
		'height_column' => 'height'
	);

	protected $objectBuilderModifier, $queryBuilderModifier, $peerBuilderModifier;

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
				'size' => 20 
			));
		}

		$columnName = $this->getParameter('bucket_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 63 
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