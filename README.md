### Installation

`composer require previewtechs/website-utilities`


####General robots.txt
```php
<?php
require "vendor/autoload.php";

$rulesOne = new \Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator\RobotsDotTxtRules('*');
$rulesOne->allow('/test')
    ->allow('/me')
    ->disallow('/thanks');

$rulesTwo = new \Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator\RobotsDotTxtRules('GoogleBot');
$rulesTwo->allow('/test')
    ->allow('/me')
    ->disallow('/thanks');

$robotGenerator = new \Previewtechs\WebsiteUtilities\RobotsDotTxtGenerator\RobotsDotTxtGenerator();
$robotGenerator->addRules($rulesOne);
$robotGenerator->addRules($rulesTwo);

//To print directly
echo $robotGenerator;

//To send response directly
return $robotGenerator->respondAsTextFile(\Psr\Http\Message\ResponseInterface $response);
```

Output:
```
User-Agent: *
Allowed: /test
Allowed: /me
Disallow: /thanks

User-Agent: GoogleBot
Allowed: /test
Allowed: /me
Disallow: /thanks
```


####Generate sitemap.xml
```php
<?php
require "vendor/autoload.php";

$urls = [
    'https://site.com/test.php' => [
        'changefreq' => 'daily',
        'priority' => 1,
        'lastmod' => date('Y-m-d')
    ],
    'https://test.com/another_test.php' => [
        'changefreq' => 'daily',
        'priority' => 2,
        'lastmod' => date('Y-m-d')
    ],
];

$gen = new \Previewtechs\WebsiteUtilities\SitemapGenerator\SitemapGenerator();
$gen->loadUrls($urls);
//If you want to send xml response directly
return $gen->respondAsXML(\Psr\Http\Message\ResponseInterface $response);

//Or, if you want to just print the sitemap
echo $gen;
```

Output:

```xml
<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
	<url>
		<loc>https://site.com/test.php</loc>
		<changefreq>daily</changefreq>
		<priority>1</priority>
		<lastmod>2017-09-30</lastmod>
	</url>
	<url>
		<loc>https://test.com/another_test.php</loc>
		<changefreq>daily</changefreq>
		<priority>2</priority>
		<lastmod>2017-09-30</lastmod>
	</url>
</urlset>
```