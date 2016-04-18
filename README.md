# generator

一个写了好像没什么用的东西, 主要辅助命令行等其他工具做一个自动生成的工作.

## 要求

php >= 7

## composer

```json
{
    "fastd/generator": "~1.0"
}
```

## 生成对象

```php
// include composer
$generator = new \FastD\Generator\Generator('Test');
echo $generator->output();
```

`FastD\Generator\Generator` 构造方法接受三个参数，第一个是类名，第二个是命名空间，第三个是对象类型: 普通对象，抽象类，接口，可以通过 `FastD\Generator\Factory\Object::OBJECT_CLASS`, `FastD\Generator\Factory\Object::OBJECT_ABSTRACT`, `FastD\Generator\Factory\Object::OBJECT_INTERFACE` 分别控制.

具体请看: Testing

### 输出

```php
class Test { }
```

### 生成文件

```php
// include composer
$generator = new \FastD\Generator\Generator('Test');
echo $generator->save(__DIR__ . '/save/Test.php');
```

&emsp;&emsp;返回生成的最终信息

不写了,具体看 测试用例.

好像瞎折腾了.

## License MIT

