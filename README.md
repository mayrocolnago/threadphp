# PHP Thread Function
A basic but strong function designed to run threads asynchronously in PHP without requiring any extra extension installed.

Basic usage
-

```php
@include_once('thread.php');

thread(function(){
  sleep(15); // Wait 15 seconds
  @file_put_contents(__DIR__ .'/done.txt', date('H:i:s'));
});

echo 'This line is immediately executed and waits for nothing.';
```

The anonymous function will execute regardless the script has ended or not.

Working with variables
-

Due to the fact that every thread is initialized as a external process, your environment variables will be lost.

Still, if you want to get variables into the function from this runtime execution, you can do this.

```php
$var = 'value';

thread(function(){
  echo 'The value of "var" is '.($varname ?? ''); // This would print "value"
},[
  'varname' => $var
]);
```

Do you wanna get rogue?

```php
thread(function(){
  @file_put_contents(__DIR__ .'/current_vars.json', json_encode(get_defined_vars()));
}, get_defined_vars());
```

Limitations
-

There is not yet a way to pass the current classes, functions and pre-included files to the thread.

Any collaboration is valid.
