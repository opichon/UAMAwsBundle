<?php

namespace UAM\Bundle\AwsBundle\Propel;

use Aws\S3\S3Client;

class S3ObjectBehaviorObjectBuilderModifier
{
	protected $behavior, $builder;

	public function __construct($behavior)
	{
		$this->behavior = $behavior;
	}

	protected function setBuilder($builder)
	{
		$this->builder = $builder;
		$this->builder->declareClasses(
			'Aws\\S3\\S3Client',
			'Aws\\S3\\Enum\\CannedAcl',
			'Aws\\S3\\Exception\\S3Exception'
		);
	}

	public function objectMethods($builder)
	{

		$this->setBuilder($builder);
		$script = '';

		$this->addGetUrlMethod($script);
		$this->addUploadMethod($script);

		return $script;
	}

	protected function addGetUrlMethod(&$script)
	{
		$script .= "
/**
 * Returns a pre-signed url to the document on AWS S3.
 *
 * @param Aws\S3\S3Client a S3Client instance
 * @param int|string $expires The Unix timestamp to expire at or a string that can be evaluated by strtotime
 *
 * @return string
 * @throws InvalidArgumentException if the request is not associated with this client object  
 */
public function getUrl(S3Client \$s3, \$expires = \"+5 minutes\")
{
	\$url = sprintf(
		'%s/%s?response-content-disposition=attachment; filename=\"%s\"',
		\$this->getBucket(),
		\$this->getPath(),
		\$this->getOriginalFilename()
	);
	\$request = \$s3->get(\$url);
	\$signed = \$s3->createPresignedUrl(\$request, \$expires);

	return \$signed;
}
";
	}

	protected function addUploadMethod(&$script)
	{
		$script .= "
/**
 * Uploads a file to S3.
 *
 * @return 
 */
public function upload(S3Client \$s3, \$file, \$filename = null)
{
	if (!file_exists(\$file)) {
		return; 
	}

	if (empty(\$filename)) {
		\$filename = basename(\$file);
	}

	$this->setOriginalFilename(\$filename);


	try {
		\$response = \$s3->putObject(array(
			'Bucket' => \$this->getBucket(),
			'Key'    => \$this->getPath(),
			'Body'   => fopen(\$file, 'r'),
			'ACL'    => CannedAcl::PRIVATE_ACCESS
		));

		return \$response;
	}
	catch (S3Exception \$e) {
		echo \"The file was not uploaded.\";
	}
}
";
	}
}