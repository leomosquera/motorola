<?php

namespace App\Console\Commands;

use App\Models\Celular;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ProductsMigration extends Command
{
    protected $signature = 'products:migrate';

    protected $description = 'Actualiza y crea productos (celulares) desde el JSON de migración';

    public function handle()
    {
        $path = 'base/migration/celulares.json';

        if (!Storage::exists($path)) {
            $this->error("No existe el archivo: {$path}");

            return Command::FAILURE;
        }

        // Se elimina BOM si el archivo fue exportado desde Excel/u otra herramienta.
        $contenido = preg_replace('/^\xEF\xBB\xBF/', '', Storage::get($path));
        $json = json_decode($contenido, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($json)) {
            $this->error('El archivo no contiene un JSON válido: ' . json_last_error_msg());

            return Command::FAILURE;
        }

        $nuevos = 0;
        $actualizados = 0;
        $omitidos = 0;
        $idsProcesados = [];
        $combosProcesados = [];

        foreach ($json as $indice => $fila) {
            if (!is_array($fila)) {
                $omitidos++;
                $this->warn('Fila ' . ($indice + 1) . ' omitida: formato inválido.');

                continue;
            }

            /*
             * Convierte, por ejemplo:
             * " Product Name (listado de equipos)  "
             * en:
             * "Product Name (listado de equipos)"
             */
            $valor = $this->normalizarColumnas($fila);

            $sku = $this->limpiarTexto($valor['SKU'] ?? null);
            $elita = $this->limpiarTexto($valor['PRODUCT CODE ELITA'] ?? null);

            if ($sku === '' || $elita === '') {
                $omitidos++;
                $this->warn(
                    'Fila ' . ($indice + 1) .
                    ' omitida: faltan SKU o PRODUCT CODE ELITA.'
                );

                continue;
            }

            $combo = $sku . '|' . $elita;

            // Evita procesar dos veces un mismo SKU + ELITA dentro del JSON.
            if (isset($combosProcesados[$combo])) {
                $omitidos++;
                $this->warn(
                    'Fila ' . ($indice + 1) .
                    " omitida: SKU + ELITA duplicado ({$combo})."
                );

                continue;
            }

            $combosProcesados[$combo] = true;

            $data = [
                'name'                => $this->limpiarTexto(
                    $valor['Product Name (listado de equipos)'] ?? null
                ),
                'gama'                => $this->limpiarTexto($valor['GAMAS'] ?? null),
                'cobertura'           => $this->limpiarTexto($valor['Cobertura'] ?? null),
                'elita'               => $elita,
                'precio_bruto_equipo' => $this->formatearNumero(
                    $valor['PRECIO BRUTO EQUIPO'] ?? null
                ),
                'precio_seguro'       => $this->formatearNumero(
                    $valor['Precio Seguro Actualizado'] ?? null
                ),
                'version'             => $this->limpiarTexto(
                    $valor['Product Description'] ?? null
                ),
                'status'              => 1,
            ];

            $producto = Celular::where('sku', $sku)
                ->where('elita', $elita)
                ->first();

            if ($producto) {
                $producto->update($data);
                $actualizados++;
            } else {
                $producto = Celular::create(array_merge([
                    'sku'  => $sku,
                    'code' => uniqid(),
                ], $data));

                $nuevos++;
            }

            $idsProcesados[] = $producto->id;
        }

        /*
         * Solo se desactivan productos si hubo al menos una fila válida.
         * Así un JSON vacío o inválido no desactiva el catálogo por error.
         */
        $desactivados = 0;

        if (!empty($idsProcesados)) {
            $desactivados = Celular::where('status', 1)
                ->whereNotIn('id', array_unique($idsProcesados))
                ->update(['status' => 0]);
        } else {
            $this->warn(
                'No se desactivó ningún producto porque no hubo filas válidas para procesar.'
            );
        }

        $this->info('📱 Migración completada');
        $this->info("➡ Nuevos productos creados:   {$nuevos}");
        $this->info("➡ Productos actualizados:     {$actualizados}");
        $this->info("➡ Productos desactivados:     {$desactivados}");
        $this->info("➡ Filas omitidas:             {$omitidos}");
        $this->info('---------------------------------------');

        return Command::SUCCESS;
    }

    /**
     * Limpia espacios antes/después de cada clave del JSON.
     * También normaliza espacios múltiples y espacios no separables.
     */
    private function normalizarColumnas(array $fila): array
    {
        $normalizada = [];

        foreach ($fila as $columna => $valor) {
            $columna = str_replace("\xC2\xA0", ' ', (string) $columna);
            $columna = preg_replace('/\s+/u', ' ', trim($columna));

            if ($columna !== '') {
                $normalizada[$columna] = $valor;
            }
        }

        return $normalizada;
    }

    /**
     * Acepta null, números y strings; elimina espacios externos.
     */
    private function limpiarTexto($valor): string
    {
        return is_null($valor) ? '' : trim((string) $valor);
    }

    /**
     * Acepta, entre otros:
     * 199999
     * "199999"
     * "3462.74"
     * "3.462,74"
     * "3,462.74"
     */
    private function formatearNumero($valor): string
    {
        if ($valor === null || $valor === '') {
            return '0.00';
        }

        $valor = trim((string) $valor);
        $valor = preg_replace('/[^0-9,.\-]/', '', $valor);

        if ($valor === '' || !preg_match('/[0-9]/', $valor)) {
            return '0.00';
        }

        $negativo = strpos($valor, '-') === 0;
        $valor = str_replace('-', '', $valor);

        $cantidadComas = substr_count($valor, ',');
        $cantidadPuntos = substr_count($valor, '.');

        if ($cantidadComas > 0 && $cantidadPuntos > 0) {
            // El último separador determina cuál es el decimal.
            if (strrpos($valor, ',') > strrpos($valor, '.')) {
                $valor = str_replace('.', '', $valor);
                $valor = str_replace(',', '.', $valor);
            } else {
                $valor = str_replace(',', '', $valor);
            }
        } elseif ($cantidadComas > 0) {
            $valor = $this->normalizarSeparadorUnico($valor, ',');
        } elseif ($cantidadPuntos > 0) {
            $valor = $this->normalizarSeparadorUnico($valor, '.');
        }

        if (!preg_match('/^\d+(\.\d+)?$/', $valor)) {
            return '0.00';
        }

        if ($negativo) {
            $valor = '-' . $valor;
        }

        return function_exists('bcdiv')
            ? bcdiv($valor, '1', 2)
            : number_format((float) $valor, 2, '.', '');
    }

    /**
     * Define si el único separador es decimal o de miles.
     */
    private function normalizarSeparadorUnico(string $valor, string $separador): string
    {
        $posicion = strrpos($valor, $separador);
        $decimales = strlen($valor) - $posicion - 1;

        // 1 o 2 dígitos luego del último separador: decimal.
        if ($decimales >= 1 && $decimales <= 2) {
            $entero = str_replace(
                $separador,
                '',
                substr($valor, 0, $posicion)
            );

            return $entero . '.' . substr($valor, $posicion + 1);
        }

        // Ej.: 199.999 o 199,999
        return str_replace($separador, '', $valor);
    }
}