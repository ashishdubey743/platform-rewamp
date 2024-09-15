<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhatsappChatApi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['accountStatus', 'vnumber', 'sub_status', 'qr_code', 'init',
        'ban_test', 'w_a_job_id',
    ];

    protected $casts = [
        'ban_test' => 'boolean',
        'init' => 'boolean',
    ];

    public function Sessions()
    {
        return $this->BelongsTo(\App\Models\VNumbers::class, 'vnumber');
    }

    public function LinkedJobs()
    {
        return $this->BelongsTo(\App\Models\WAJob::class);
    }

    public function sendRequest($method, $data)
    {
        $url = $this->APIurl.$method.'?token='.$this->token;
        if (is_array($data)) {
            $data = json_encode($data);
        }
        $options = stream_context_create(['http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/json',
            'content' => $data]]);
        $response = file_get_contents($url, false, $options);
        file_put_contents('requests.log', $response.PHP_EOL, FILE_APPEND);
    }
}
