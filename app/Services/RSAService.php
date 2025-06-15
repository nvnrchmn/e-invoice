<?php
namespace App\Services;

use phpseclib3\Crypt\PublicKeyLoader;

class RSAService
{
    protected $privateKey;
    protected $publicKey;

    public function __construct()
    {
        $this->privateKey = PublicKeyLoader::load(file_get_contents(base_path('keys/private.pem')));
        $this->publicKey  = PublicKeyLoader::load(file_get_contents(base_path('keys/public.pem')));
    }

    public function sign(string $data): string
    {
        return base64_encode($this->privateKey->sign($data));
    }

    public function verify(string $data, string $signature): bool
    {
        return $this->publicKey->verify($data, base64_decode($signature));
    }

}
