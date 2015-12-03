# sqlpdo

SqlPdo is console tool to access the database with PHP PDO.

Following example:

```bash
sqlpdo
Welcome SqlPdo 1.0.0

Please select your connection:
  [0] local
  [1] local2
> 0

Type \h for help

Database: teste

SQL >
```

## Configuring connections

Edit $HOME/.config/sqlpdo/config

Example of 2 connetions using the driver mysql:

```
{
    "pdo": [
        {
            "name": "local",
            "description": "Database test",
            "dbname": "test",
            "user": "utest",
            "password": "ptest",
            "host": "localhost",
            "driver": "pdo_mysql"
        },
        {
            "name": "local2",
            "description": "Database 2 test",
            "dbname": "test2",
            "user": "utest2",
            "password": "ptest2",
            "host": "localhost",
            "driver": "pdo_mysql"
        }
    ]
}
```

For more details on connection [driver](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connection-details).

## Instalation

## License

(The MIT License)

Copyright (c) 2013 Edison E. Abreu [&lt;dinho.abreu@gmail.com&gt;](mailto://dinho.abreu@gmail.com)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
