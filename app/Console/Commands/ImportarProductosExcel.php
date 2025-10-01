<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Celular;

class ImportarProductosExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * php artisan productos:importar
     */
    protected $signature = 'productos:importar {path=lista.xlsx : Ruta del archivo Excel}';

    /**
     * The console command description.
     */
    protected $description = 'Importa productos desde un archivo Excel actualizando o creando según SKU + ELITA (detecta columnas por encabezado)';

    private function formatearNumero($valor)
    {
        $numero = (float) $valor;
        return number_format(round($numero, 2), 2, '.', '');
    }

    public function handle()
    {
        $path = 'storage/app/base/migration/'.$this->argument('path');

        if (!file_exists($path)) {
            $this->error("El archivo no existe: {$path}");
            return 1;
        }

        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        if (count($rows) < 2) {
            $this->error("El Excel no tiene datos suficientes.");
            return 1;
        }

        // 📌 Primera fila = encabezados
        $headers = array_map('trim', $rows[1]);

        // Mapeo de títulos de Excel a columnas en DB
        $map = [
            'Product Name (listado de equipos)' => 'name',
            'GAMAS'                            => 'gama',
            'Cobertura'                        => 'cobertura',
            'PRODUCT CODE ELITA'               => 'elita',
            'PRECIO BRUTO EQUIPO'              => 'precio_bruto_equipo',
            'Precio Seguro Actualizado'        => 'precio_seguro',
            'SKU'                              => 'sku',
            'Product Description'              => 'version',
        ];

        // Crear un índice [columnaExcel => letra]
        $colIndex = [];
        foreach ($headers as $colLetter => $titulo) {
            if (isset($map[$titulo])) {
                $colIndex[$map[$titulo]] = $colLetter;
            }
        }

        // Verificar que estén todas las columnas requeridas
        foreach ($map as $titulo => $campo) {
            if (!isset($colIndex[$campo])) {
                $this->error("Falta la columna requerida en Excel: {$titulo}");
                return 1;
            }
        }

        $total = 0;
        $creados = 0;
        $actualizados = 0;
        $noProcesados = [];
        $procesados = []; // nuevo array

        // 📌 Procesar filas (a partir de la fila 2)
        foreach ($rows as $index => $row) {
            if ($index === 1) continue;

            // 🔹 Verificar si la fila está vacía
            $valores = array_map('trim', $row);
            if (count(array_filter($valores)) === 0) {
                // si todos los valores están vacíos -> skip
                continue;
            }

            $total++;

            $sku    = trim($row[$colIndex['sku']] ?? '');
            $name   = trim($row[$colIndex['name']] ?? '');
            $gama   = trim($row[$colIndex['gama']] ?? '');
            $cob    = trim($row[$colIndex['cobertura']] ?? '');
            $elita  = trim($row[$colIndex['elita']] ?? '');
            $pbruto = $this->formatearNumero($row[$colIndex['precio_bruto_equipo']] ?? 0);
            $pseg   = $this->formatearNumero($row[$colIndex['precio_seguro']] ?? 0);
            $vers   = trim($row[$colIndex['version']] ?? '');

            if (empty($sku) || empty($elita)) {
                $noProcesados[] = "Fila {$index}: SKU/ELITA vacíos";
                continue;
            }

            // Guardar combinacion procesada
            $procesados[] = $sku.'|'.$elita;

            $producto = Celular::where('sku', $sku)->where('elita', $elita)->first();

            if ($producto) {
                // Actualizar
                $producto->update([
                    'name'                  => $name,
                    'gama'                  => $gama,
                    'cobertura'             => $cob,
                    'precio_bruto_equipo'   => $pbruto,
                    'precio_seguro'         => $pseg,
                    'version'               => $vers,
                ]);
                $actualizados++;
            } else {
                // Crear
                $producto = new Celular();
                $producto->status = 1;
                $producto->code = uniqid();
                $producto->sku = $sku;
                $producto->name = $name;
                $producto->gama = $gama;
                $producto->cobertura = $cob;
                $producto->elita = $elita;
                $producto->precio_bruto_equipo = $pbruto;
                $producto->precio_seguro = $pseg;
                $producto->version = $vers;
                $producto->save();

                $creados++;
            }
        }

        // 🔹 Desactivar los que no están en el Excel
        $desactivados = Celular::whereNotIn(
            \DB::raw("CONCAT(sku,'|',elita)"), 
            $procesados
        )->update(['status' => 0]);

        // ✅ Resumen final
        $this->info("Total filas en Excel: {$total}");
        $this->info("Productos actualizados: {$actualizados}");
        $this->info("Productos creados: {$creados}");
        $this->info("Productos desactivados: {$desactivados}");
        $this->info("No procesados: " . count($noProcesados));

        if (!empty($noProcesados)) {
            $this->warn("Listado de no procesados:");
            foreach ($noProcesados as $err) {
                $this->line(" - {$err}");
            }
        }

        return 0;
    }
}
