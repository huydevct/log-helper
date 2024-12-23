<?php


namespace Huyct\TelegramHelper\exceptions;

use Huyct\TelegramHelper\jobs\SendMessageToTelegram;
use Illuminate\Support\Facades\Request;

class TelegramSendLog
{
    static function TelegramSendLog($e)
    {
        if (config('loghelper.log.enable')) {
            $ip = config('app.ip_server');
            $message = "- Source: " . config('app.name', 'localhost') . ": " . $ip;
            $message .= "\n- Path: " . url()->full();
            $message .= "\n- Method: " . Request::method();
            $message .= "\n- Client IP: " . Request::ip();
            $message .= "\n- User agent: ".Request::userAgent();
            if(isset($_SERVER['argv'])){
                $command = '';
                if(is_string($_SERVER['argv'])){
                    $command = $_SERVER['argv'];
                }else if(is_array($_SERVER['argv'])){
                    $command = implode(' ',$_SERVER['argv']);
                }
                $message .= "\n- Command : $command";
            }
            $message .= "\n- Error: " . $e->getMessage();
            $message .= "\n- Date: " . date('H:i:s d/m/Y');
            $message .= "\n`" . $e->getFile() . "(" . $e->getLine() . ")`\n";
            $message .= "```" . json_encode(data_get($e->getTrace(), '0', null)) . "```";
            dispatch(new SendMessageToTelegram($message, 'error'))->onQueue(config('loghelper.log.name_queue'));
        }
    }
}