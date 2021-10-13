<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Rabbitmq\Jobs;

use Lswl\Log\Log;
use Lswl\Support\Utils\Collection;

abstract class BaseRabbitmq extends BaseJob
{
    /**
     * @var Collection
     */
    protected $msg;

    public function __construct(array $msg)
    {
        // 链接名称
        $this->connection = 'rabbitmq';
        // 队列名称
        $this->queue = env('RABBITMQ_QUEUE', 'default');
        // 消息
        $this->msg = new Collection($msg);

        Log::dir('queue')
            ->name($this->getClassBaseName('.send'))
            ->withDateToName()
            ->withMessageLineBreak()
            ->debug(
                $this->msg->toJson(JSON_UNESCAPED_UNICODE)
            );
    }

    /**
     * 获取类名称
     * @param string $name
     * @return string
     */
    public function getClassBaseName(string $name = ''): string
    {
        return class_basename(get_called_class()) . $name;
    }
}
