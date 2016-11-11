# EmailOversight API in PHP

[EmailOversight](https://emailoversight.com) is a set of powerful tools that enable you to take your data
management and email campaigns to the next level.

This is a simple PHP implementation of the API calls.

### Installation
Update your `composer.json` file
```json
{
    "require": {
        "bcismariu/emailoversight-php": "0.*"
    }
}
```
Run `composer update`

### Usage
```php
use Bcismariu\EmailOversight\EmailOversight;

$validator = new EmailOversight('YOUR_API_KEY');
$result = $validator->emailValidation('client.email@domain.com', 'your_list_id');
```
Read the official [API](https://login.emailoversight.com/ApiPage/EmailValidation) for more details regarding parameters and responses.

In order to help with multiple queries, you can also pass your `listId` to the constructor:
```php
$validator = new EmailOversight([
		'apitoken'	=> 'YOUR_API_KEY',
		'listid'	  => 'your_list_id'
	]);

$result1 = $validator->emailValidation('first.client@domain.com');
$result2 = $validator->emailValidation('second.client@domain.com');
```
Email Valid Boolean
```
$validEmail = $validator->isValid($result);

if($validEmail) {
 // Good Email
}else {
 // Bad Email
}
```

### Contributions

This is a very basic implementation that can only handle email validations. Any project contributions are welcomed!
