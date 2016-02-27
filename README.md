# generator

一个写了好像没什么用的东西, 主要辅助命令行等其他工具做一个自动生成的工作.

## 生成对象

```php
// include composer
$generator = new Generator('Test', "Test");
echo $generator->generate();
```

生成一个对象, 此处是个字符穿, 具体操作由具体业务处理.

## Api

### FastD\Generator\Factory\Object::__construct($name, $namespace = null, $type = self::OBJECT_CLASS)

#### name

&emsp;&emsp;要生成的类名

#### namespace

&emsp;&emsp;要生成的命名空间

#### type

$emsp;&emsp;要生成的对象类型, OBJECT_CLASS, OBJECT_ABSTRACT, OBJECT_INTERFACE

### FastD\Generator\Factory\Object::generate()

&emsp;&emsp;返回生成的最终信息

不写了,具体看 测试用例.

好像瞎折腾了.

## License MIT

