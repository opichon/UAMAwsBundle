<?php

namespace UAM\Bundle\AwsBundle\Propel;

use \Behavior;

class S3ObjectBehavior extends Behavior{

	protected $parameters = array(
		'bucket_column' => 'bucket',
		'path_column' => 'path',
		'original_filename_column' => 'original_filename',
		'mime_type_column' => 'mime_type', 
		'size_column' => 'size',
		'with_dimensions' => true,
		'width_column' => 'width',
		'height_column' => 'height'
	);

	public function modifyTable()
	{
		$table = $this->getTable();

		$columnName = $this->getParameter('bucket_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 63 
			));
		}

		$columnName = $this->getParameter('path_column');
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

		$columnName = $this->getParameter('mime_type_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'VARCHAR',
				'size' => 100
			));
		}

		$columnName = $this->getParameter('size_column');
		// add the column if not present
		if(!$this->getTable()->containsColumn($columnName)) {
			$column = $this->getTable()->addColumn(array(
				'name' => $columnName,
				'type' => 'INTEGER'
			));
		}

		if ($this->getparameter('with_dimensions')) {
			$columnName = $this->getParameter('width_column');
			// add the column if not present
			if(!$this->getTable()->containsColumn($columnName)) {
				$column = $this->getTable()->addColumn(array(
					'name' => $columnName,
					'type' => 'INTEGER'
				));
			}

			$columnName = $this->getParameter('height_column');
			// add the column if not present
			if(!$this->getTable()->containsColumn($columnName)) {
				$column = $this->getTable()->addColumn(array(
					'name' => $columnName,
					'type' => 'INTEGER'
				));
			}
		}
	}
} 