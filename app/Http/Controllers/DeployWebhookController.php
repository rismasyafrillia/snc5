<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class DeployWebhookController extends Controller
{
    public function handle(Request $request): Response
    {
        $secret = (string) config('services.github_deploy.webhook_secret');
        $signature = (string) $request->header('X-Hub-Signature-256');

        if ($secret === '' || ! $this->signatureIsValid($secret, $signature, $request->getContent())) {
            Log::warning('Deploy webhook: invalid signature', ['ip' => $request->ip()]);

            abort(HttpResponse::HTTP_FORBIDDEN);
        }

        if ($request->header('X-GitHub-Event') !== 'push') {
            return response()->json(['ignored' => 'not a push event']);
        }

        if ($request->input('ref') !== 'refs/heads/main') {
            return response()->json(['ignored' => 'not main branch']);
        }

        Log::info('Deploy webhook: triggering deploy', [
            'after' => $request->input('after'),
        ]);

        // Container ini tidak punya akses ke Docker host, jadi kita hanya
        // menyentuh file trigger. systemd path unit di host yang mengawasi
        // file ini dan menjalankan script deploy sesungguhnya.
        file_put_contents(storage_path('app/deploy.trigger'), (string) now());

        return response()->json(['deploying' => true]);
    }

    private function signatureIsValid(string $secret, string $signature, string $payload): bool
    {
        if (! str_starts_with($signature, 'sha256=')) {
            return false;
        }

        $expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }
}
