<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Services\QrisPaymentService;
use RuntimeException;
use Tests\TestCase;

class QrisPaymentServiceTest extends TestCase
{
    public function test_it_builds_a_dynamic_qris_payload_for_the_order_amount(): void
    {
        config([
            'services.qris.merchant_payload' => $this->merchantPayload(),
        ]);

        $order = new Order([
            'status' => 'pending',
            'total_amount' => 125000,
        ]);

        $payload = app(QrisPaymentService::class)->createDynamicPayload($order);

        $this->assertStringContainsString('010212', $payload);
        $this->assertStringContainsString('5406125000', $payload);
        $this->assertSame(1, substr_count($payload, '5406125000'));
        $this->assertStringEndsWith(
            strtoupper(sprintf('%04X', $this->crc16(substr($payload, 0, -4)))),
            $payload
        );
    }

    public function test_it_rejects_a_merchant_payload_with_an_invalid_crc(): void
    {
        $payload = $this->merchantPayload();
        config([
            'services.qris.merchant_payload' => substr($payload, 0, -4).'0000',
        ]);

        $this->expectException(RuntimeException::class);

        app(QrisPaymentService::class)->createDynamicPayload(new Order([
            'status' => 'pending',
            'total_amount' => 125000,
        ]));
    }

    private function merchantPayload(): string
    {
        $fields = [
            '00' => '01',
            '01' => '11',
            '26' => 'MERCHANT',
            '53' => '360',
            '58' => 'ID',
            '59' => 'TEST',
            '60' => 'CITY',
        ];

        $payload = '';

        foreach ($fields as $tag => $value) {
            $payload .= $tag.str_pad((string) strlen($value), 2, '0', STR_PAD_LEFT).$value;
        }

        $payload .= '6304';

        return $payload.strtoupper(sprintf('%04X', $this->crc16($payload)));
    }

    private function crc16(string $data): int
    {
        $crc = 0xFFFF;

        for ($index = 0, $length = strlen($data); $index < $length; $index++) {
            $crc ^= ord($data[$index]) << 8;

            for ($bit = 0; $bit < 8; $bit++) {
                $crc = ($crc & 0x8000) !== 0
                    ? (($crc << 1) ^ 0x1021)
                    : ($crc << 1);
                $crc &= 0xFFFF;
            }
        }

        return $crc;
    }
}
