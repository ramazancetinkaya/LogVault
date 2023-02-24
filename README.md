# Logger

Logger is a PHP and PSR-compatible logging library that provides secure and powerful logging functionality for your applications.

## Features
  * Support for multiple logging levels, including debug, info, warning, error, and critical.
  * Customizable log formatting and output, including support for writing logs to files, databases, or other destinations.
  * Secure logging functionality that helps to prevent common security issues such as injection attacks or sensitive data leakage.
  * Easy integration with existing PSR-compatible applications and frameworks.

## Usage
```php
$logger = new Logger('info');
$logger->addHandler(function ($logData) {
    $formatted = sprintf("[%s] %s: %s", date('Y-m-d H:i:s', $logData['timestamp']), strtoupper($logData['level']), $logData['message']);
    if (!empty($logData['context'])) {
        $formatted .= ' ' . json_encode($logData['context']);
    }
    file_put_contents('/var/log/myapp.log', $formatted . PHP_EOL, FILE_APPEND);
});

$logger->log('info', 'User logged in', ['user_id' => 123]);
$logger->log('error', 'Database connection failed', ['exception' => $e]);
```

## Authors

**Ramazan Çetinkaya**

- [github/ramazancetinkaya](https://github.com/ramazancetinkaya)

## License
The Logger library is licensed under the MIT License. See **LICENSE.md** for more information.

## Copyright

Copyright © 2023, [Ramazan Çetinkaya](https://github.com/ramazancetinkaya).
