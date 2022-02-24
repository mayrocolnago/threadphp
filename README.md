# PHP Thread Function
A basic but strong function designed to run threads asynchronously in PHP without requiring any extra extension installed.

Basic usage
-

```php
@include_once('thread.php');

thread(function(){
  sleep(10);
  @file_put_contents(__DIR__ .'/done.txt', date('H:i:s'));
});

echo 'This line is immediately executed.';
```

The anonymous function will execute regardless the script has ended or not.

Any collaboration is valid.
