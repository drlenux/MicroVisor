# Micro Visor

### Config

---

```php
<?php

return [
    'timeout' => 0.1,
    'services' => [
        'service-name' => [
            'cmd' => 'shell command'
            'timeout' => 3, // second
            'thread' => 2 
        ]
    ]
];
```

### Run

---

```shell
php ./bin/console.php
```
