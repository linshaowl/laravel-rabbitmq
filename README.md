## 介绍

> 环境变量值参考：[env](docs/ENV.md)
>
> 详细使用说明查看：[README.md](https://github.com/vyuldashev/laravel-queue-rabbitmq/blob/master/README.md)

## 安装

使用以下命令安装：
```
$ composer require lswl/laravel-rabbitmq
```

## 快速使用

- 配置环境变量
- 启用监听
- 书写业务代码

**启用监听:**
```shell
# 方式1: 使用 laravel 自带命令, 该命令使用 `basic_get` 方式
php artisan queue:work rabbitmq

# 方式2(推荐): 使用扩展包命令, 该命令使用 `basic_consume` 方式, 比 `basic_get` 性能高约2倍
php artisan rabbitmq:consume rabbitmq
```

**业务代码：**
```php
// 任务类
use Lswl\Rabbitmq\Jobs\BaseRabbitmq;

class CustomJob extends BaseRabbitmq
{
    // 自行实现逻辑
    public function handle()
    {
        // 调用任务时传递的数据为 msg
        // $this->msg->key === 'value';
    }
}

// 调用任务类
CustomJob::dispatch([
    'key' => 'value',
    ...
]);
```
