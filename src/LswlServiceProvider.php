<?php

/**
 * (c) linshaowl <linshaowl@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Lswl\Rabbitmq;

use Illuminate\Contracts\Queue\Job;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Lswl\Log\Log;

class LswlServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 任务失败事件
        Queue::failing(function (JobFailed $event) {
            Log::dir('queue')
                ->name($this->getLogName($event->job, 'failed'))
                ->withDateToName()
                ->withMessageLineBreak()
                ->throwable(
                    $event->exception
                );
        });

        // 任务开始事件
        Queue::before(function (JobProcessing $event) {
            Log::dir('queue')
                ->name($this->getLogName($event->job, 'handle'))
                ->withDateToName()
                ->withMessageLineBreak()
                ->debug(
                    $event->job->getRawBody()
                );
        });
    }

    /**
     * 获取日志名称
     * @param Job $job
     * @param string $name
     * @return string
     */
    protected function getLogName(Job $job, string $name): string
    {
        $payload = $job->payload();
        return (!empty($payload['displayName']) ? class_basename($payload['displayName']) . '.' : '') . $name;
    }
}
