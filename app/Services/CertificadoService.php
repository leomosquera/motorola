<?php

namespace App\Services;

use App\Models\CampaignLog;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoService
{
    public function buildData(CampaignLog $campaignLog): array
    {
        $params   = json_decode($campaignLog->params, true);
        $services = json_decode($campaignLog->services);

        $producto = null;
        $codigoArticulo = $params['codarticulo']['value'] ?? null;

        foreach ($services->products->data ?? [] as $item) {
            if ($codigoArticulo === $item->code) {
                $producto = $item;
                break;
            }
        }

        if (!$producto) {
            throw new \RuntimeException('Producto no encontrado para el codarticulo');
        }

        return [
            'nombre'           => substr(preg_replace('/\s+/', ' ', $params['nombres']['value'] ?? ''), 0, 50),
            'detalleCobertura' => $producto->cobertura,
            'costoMensual'     => number_format($producto->precio_seguro, 2, ',', '.') . ' por mes',
        ];
    }

    public function generatePdf(array $data): string
    {
        return Pdf::loadView('emails.certificado.pdf', $data)
            ->setPaper('A4', 'portrait')
            ->output();
    }
}
