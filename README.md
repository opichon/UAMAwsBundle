UAMAwsBundle
==============

The UAMAwsBundle exposes AWS clients as services for use in your Symfony 2 app.

Installation
=============

Add the package to your project's `composer.json`:

```
"require": {
	"uam/aws-bundle": "dev-master",
	…
}
```

Register this bundle in your ap's kernel:

``` 
# app/AppKernel.php

public function registerBundles()
{
	bundles = (
		// …
		new UAM\Bundle\AwsBundle\UAMAwsBundle(),
	);
	
	return bundles();
}

```

Configuration
=============
The UAMAwsBundle can be configured in 2 ways: either by poiinting to a AWS configuration file or by setting the configuration parameters in your `config.php` configuration file.

### Direct configuration
Define the following settings in your app's configuration file:

```
# app/config/config.php
uam_aws:
	config:
		key: 	YOUR AWS ACCESS KEY
		secret: YOUR AWS SECRET KEY
		region: DEFAULT REGION
```

### Via AWS configuration file

You can also simply have your app's configuration file point to a AWS configuration file in a location of your choice. This configuration file must be in the format required by the AWS SDK's `Aws::factory()` method.

```
# app/config/config.php 
uam_aws:
	config_path: /path/to/aws/config/file
```

Usage
=====

Currently this bundle defines a single 's3' service that provides a client for AWS S3 service.

You can obtain this service from a container in the standard way, e.g. in a Controller:

```
# MyBundle/Controller/MyController.php

public function someAction()
{
	$s3 = $this->container->get('s3');
}
```

The 's3' service is an instance of `Aws\S3\S3Client`. See the AWS SDK documentation for usage of the S3Client.