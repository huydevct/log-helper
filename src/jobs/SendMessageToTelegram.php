<?php


namespace Huyct\TelegramHelper\jobs;


use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMessageToTelegram
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $payload;
    public $type;
    public $channel_id = null;

    /**
     * Create a new job instance.
     * @param $payload
     * @param string $type
     * @param null $channel_id
     */
    public function __construct($payload, $type = 'error', $channel_id = null)
    {
        $this->payload = $payload;
        $this->type = $type;
        if (empty($channel_id)) {
            $this->channel_id = $type == 'error' ? config('telegramhelper.log.connections.telegram.error_channel_id') : config('telegramhelper.log.connections.telegram.log_channel_id');
        } else {
            $this->channel_id = $channel_id;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $token = config('helper.log.connections.telegram.bot_token');
            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            if (is_array($this->payload)) {
                $message ="";
                foreach ($this->payload as $key => $data) {
                    $message.="- $key: ".(is_string($data)||is_numeric($data)?$data:json_encode($data));
                }
                $this->payload = $message;
            }
            if (empty($token) || empty($this->channel_id) || empty($this->payload)) {
                throw new \Exception("Data empty: ChannelID: {$this->channel_id} ,Token: {$token} ,Payload: {$this->payload}");
            }

            $client = new Client();
            $res = $client->post($url, [
                "json" => [
                    "chat_id" => $this->channel_id,
                    "text" => $this->payload,
                    "parse_mode" => "Html",
                    "disable_web_page_preview" => true
                ]
            ]);
            if ($res->getStatusCode() !== 200) {
                throw new \Exception($res->getReasonPhrase());
            }
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }
}