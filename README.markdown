Panada Twitter Library
============================
Yet Another Twitter Library for [Panada PHP Framwework](https://github.com/panada/Panada) based on [PHP Twitter Async](https://github.com/jmathai/twitter-async) by Jaisen Mathai.

## Usage Example:
### Using Twitter search (no key required)

```php
<?php
$this->twitter = new Libraries\Twitter();
var_dump($this->twitter->get('/search.json', array('q' => 'twitter')));

```

### Connect to Twitter and get Oauth token (consumer key required)
```php
<?php
$this->twitter = new Libraries\Twitter('YOUR CONSUMER KEY', 'YOUR CONSUMER SECRET');

// Set custom callback (optional)
$this->twitter->callback('http://localhost/panada/app/index.php/twitter/callback');
var_dump($this->twitter->connect());

```

### Verify credential (consumer and token required)
```php
<?php
$this->twitter = new Libraries\Twitter('YOUR CONSUMER KEY', 'YOUR CONSUMER SECRET', 'YOUR OAUTH TOKEN', 'YOUR OAUTH SECRET');
var_dump($this->twitter->get('/account/verify_credentials.json'));

```

### Update status (consumer and token required)

```php
<?php
$this->twitter = new Libraries\Twitter('YOUR CONSUMER KEY', 'YOUR CONSUMER SECRET', 'YOUR OAUTH TOKEN', 'YOUR OAUTH SECRET');
var_dump($this->twitter->post('/statuses/update.json', array('status' => 'This is my status')));

```


