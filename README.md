# sqlpdo

Console access to database by PHP PDO

Following example:
```
./sqlpdo

Connections
test  Environ test
test2 Environ test 2

select one of the links above: test
SQL>create table a (id int);

SQL>insert into a (id) values (1);
Affected rows: 1
Timing: 0.003312

SQL>select * from a;
+--+
|id|
+--+
| 1|
+--+
Rows: 1
Timing: 0.000808
```

## Configuring connections

Edit sqlpdo.xml

Example of 2 connetions using the driver sqlite:
```xml
<?xml version="1.0"?>
<pdo history=".sqlpdo.hst" history_size="50" verbose="true">
	<dsn id="test" user="" passwd="" dsn="sqlite:/tmp/teste.db">Environ test</dsn>
	<dsn id="test2" user="" passwd="" dsn="sqlite:/tmp/teste2.db">Environ test 2</dsn>
</pdo>
```

Configure one or more &lt;dsn&gt; [driver PDO](http://br1.php.net/manual/en/pdo.drivers.php) used.
