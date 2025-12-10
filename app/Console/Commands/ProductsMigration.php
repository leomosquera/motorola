<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Celular;
use Storage;

class ProductsMigration extends Command
{
    protected $signature = 'products:migrate';
    protected $description = 'Actualiza y crea productos (celulares) desde el JSON de migración';

    public function handle()
    {
        $json = Storage::get('base/migration/celulares.json');
        $json = json_decode($json, true);

        $nuevos = 0;
        $actualizados = 0;
        $procesados = []; // lista SKU|ELITA procesados

        foreach ($json as $valor) {

            // ─────────────────────────────
            // Validar datos básicos
            // ─────────────────────────────
            if (!isset($valor['SKU']) || !isset($valor['PRODUCT CODE ELITA'])) {
                continue;
            }

            // Normalizar valores
            $sku   = trim($valor['SKU']);
            $elita = trim($valor['PRODUCT CODE ELITA']);

            // Marcar combinación SKU + ELITA
            $combo = $sku . '|' . $elita;
            $procesados[] = $combo;

            // Buscar producto existente
            $producto = Celular::where('sku', $sku)
                ->where('elita', $elita)
                ->first();

            $data = [
                'name'                => trim($valor['Product Name (listado de equipos)'] ?? ''),
                'gama'                => trim($valor['GAMAS'] ?? ''),
                'cobertura'           => trim($valor['Cobertura'] ?? ''),
                'elita'               => $elita,
                'precio_bruto_equipo' => $this->formatearNumero($valor['PRECIO BRUTO EQUIPO'] ?? 0),
                'precio_seguro'       => $this->formatearNumero($valor['Precio Seguro Actualizado'] ?? 0),
                'version'             => trim($valor['Product Description'] ?? ''),
                'status'              => 1,
            ];

            if ($producto) {
                // actualizar
                $producto->update($data);
                $actualizados++;
            } else {
                // crear nuevo
                Celular::create(array_merge([
                    'sku'   => $sku,
                    'code'  => uniqid(),
                ], $data));

                $nuevos++;
            }
        }

        // ─────────────────────────────
        // DESACTIVAR productos NO presentes en el JSON
        // ─────────────────────────────
        $desactivados = Celular::whereRaw("CONCAT(sku,'|',elita) NOT IN ('" . implode("','", $procesados) . "')")
            ->update(['status' => 0]);

        // ─────────────────────────────
        // Resultado final
        // ─────────────────────────────
        $this->info("📱 Migración completada");
        $this->info("➡ Nuevos productos creados:   {$nuevos}");
        $this->info("➡ Productos actualizados:     {$actualizados}");
        $this->info("➡ Productos desactivados:     {$desactivados}");
        $this->info("---------------------------------------");

        return Command::SUCCESS;
    }

    /** Limpia y normaliza números del JSON */
    private function formatearNumero($valor)
    {
        if (is_null($valor) || $valor === '') {
            return "0.00";
        }

        // valor como string
        $valor = trim((string)$valor);

        // reemplazar comas por puntos
        $valor = str_replace(',', '.', $valor);

        // permitir solo números y puntos
        $valor = preg_replace('/[^0-9.]/', '', $valor);

        if ($valor === '') return "0.00";

        // limitar a 2 decimales con BCMath
        return bcdiv($valor, '1', 2);
    }
}
