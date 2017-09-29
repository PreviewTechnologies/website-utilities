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

echo $robotGenerator->generate();
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
