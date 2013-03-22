<?php

namespace UAM\Bundle\AwsBundle\Propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 's3object' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.vendor.uam.aws-bundle.UAM.Bundle.AwsBundle.Propel.map
 */
class S3ObjectTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vendor.uam.aws-bundle.UAM.Bundle.AwsBundle.Propel.map.S3ObjectTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('s3object');
        $this->setPhpName('S3Object');
        $this->setClassname('UAM\\Bundle\\AwsBundle\\Propel\\S3Object');
        $this->setPackage('vendor.uam.aws-bundle.UAM.Bundle.AwsBundle.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 100, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('bucket', 'Bucket', 'VARCHAR', true, 63, null);
        $this->addColumn('path', 'Path', 'VARCHAR', true, 255, null);
        $this->addColumn('credentials', 'Credentials', 'VARCHAR', true, 100, null);
        $this->addColumn('preauth', 'Preauth', 'VARCHAR', false, 100, '5 minutes');
        $this->addColumn('filename', 'Filename', 'VARCHAR', true, 255, null);
        $this->addColumn('size', 'Size', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
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
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
        );
    } // getBehaviors()

} // S3ObjectTableMap
