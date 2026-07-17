<?php

namespace App\Http\Controllers;

use App\Exports\DriversExport;
use Illuminate\Http\Request;
use ZipArchive;

class ExportController extends Controller
{
    public function index()
    {
        return view('export.index');
    }

    public function download(Request $request)
    {
        $request->validate([
            'periode' => ['required', 'in:harian,bulanan,tahunan'],
        ]);

        $periode  = $request->periode;
        $params   = [];
        $namaFile = 'SiDriver_BPU';

        switch ($periode) {
            case 'harian':
                $request->validate(['tanggal' => 'required|date']);
                $params   = ['tanggal' => $request->tanggal];
                $namaFile .= '_Harian_' . $request->tanggal;
                break;

            case 'bulanan':
                $request->validate([
                    'bulan' => 'required|integer|between:1,12',
                    'tahun' => 'required|integer|min:2020',
                ]);
                $params   = ['bulan' => $request->bulan, 'tahun' => $request->tahun];
                $namaFile .= '_Bulanan_' . str_pad($request->bulan, 2, '0', STR_PAD_LEFT) . '-' . $request->tahun;
                break;

            case 'tahunan':
                $request->validate(['tahun' => 'required|integer|min:2020']);
                $params   = ['tahun' => $request->tahun];
                $namaFile .= '_Tahunan_' . $request->tahun;
                break;
        }

        $export   = new DriversExport($periode, $params);
        $headings = DriversExport::headings();
        $data     = $export->getData();

        // Buat file XLSX menggunakan ZipArchive + OpenXML
        $xlsxContent = $this->buildXlsx($headings, $data, 'Data Driver BPU');

        return response($xlsxContent, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '.xlsx"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    /**
     * Buat file XLSX (format OpenXML) dari array data.
     * Menggunakan ZipArchive bawaan PHP — tanpa dependency eksternal.
     */
    private function buildXlsx(array $headings, array $rows, string $sheetTitle): string
    {
        // Gabungkan header + data
        $allRows   = array_merge([$headings], $rows);
        $totalRows = count($allRows);
        $totalCols = count($headings);

        // --- Bangun XML sheet ---
        $sheetXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $sheetXml .= '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $sheetXml .= '<sheetViews><sheetView workbookViewId="0"><selection activeCell="A1" sqref="A1"/></sheetView></sheetViews>';
        $sheetXml .= '<sheetData>';

        foreach ($allRows as $rowIndex => $row) {
            $excelRow = $rowIndex + 1;
            $isHeader = ($rowIndex === 0);
            $sheetXml .= '<row r="' . $excelRow . '">';

            foreach ($row as $colIndex => $cellValue) {
                $colLetter  = $this->colLetter($colIndex);
                $cellRef    = $colLetter . $excelRow;
                $styleIndex = $isHeader ? 1 : 0; // 1 = header style

                // Escape karakter XML
                $escaped = htmlspecialchars((string) $cellValue, ENT_XML1, 'UTF-8');

                $sheetXml .= '<c r="' . $cellRef . '" t="inlineStr" s="' . $styleIndex . '">';
                $sheetXml .= '<is><t>' . $escaped . '</t></is>';
                $sheetXml .= '</c>';
            }

            $sheetXml .= '</row>';
        }

        $sheetXml .= '</sheetData>';

        // Auto filter pada header
        $lastCol = $this->colLetter($totalCols - 1);
        $sheetXml .= '<autoFilter ref="A1:' . $lastCol . '1"/>';
        $sheetXml .= '</worksheet>';

        // --- Styles: 2 style — default (0) dan header hijau BPJS (1) ---
        $stylesXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $stylesXml .= '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">';
        $stylesXml .= '<fonts count="2">';
        $stylesXml .= '<font><sz val="11"/><name val="Calibri"/></font>';
        $stylesXml .= '<font><b/><sz val="11"/><color rgb="FFFFFFFF"/><name val="Calibri"/></font>'; // bold white
        $stylesXml .= '</fonts>';
        $stylesXml .= '<fills count="3">';
        $stylesXml .= '<fill><patternFill patternType="none"/></fill>';
        $stylesXml .= '<fill><patternFill patternType="gray125"/></fill>';
        $stylesXml .= '<fill><patternFill patternType="solid"><fgColor rgb="FF00A651"/></patternFill></fill>'; // hijau BPJS
        $stylesXml .= '</fills>';
        $stylesXml .= '<borders count="1"><border><left/><right/><top/><bottom/><diagonal/></border></borders>';
        $stylesXml .= '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>';
        $stylesXml .= '<cellXfs count="2">';
        $stylesXml .= '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'; // 0: default
        $stylesXml .= '<xf numFmtId="0" fontId="1" fillId="2" borderId="0" xfId="0" applyFont="1" applyFill="1"/>'; // 1: header
        $stylesXml .= '</cellXfs>';
        $stylesXml .= '</styleSheet>';

        // --- Workbook ---
        $workbookXml  = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $workbookXml .= '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" ';
        $workbookXml .= 'xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">';
        $workbookXml .= '<sheets>';
        $workbookXml .= '<sheet name="' . htmlspecialchars($sheetTitle, ENT_XML1) . '" sheetId="1" r:id="rId1"/>';
        $workbookXml .= '</sheets></workbook>';

        // --- Relationships ---
        $relsWorkbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';

        $relsRoot = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';

        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';

        // --- Buat ZIP (= file XLSX) di memory ---
        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');

        $zip = new ZipArchive();
        $zip->open($tmpFile, ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml',           $contentTypes);
        $zip->addFromString('_rels/.rels',                   $relsRoot);
        $zip->addFromString('xl/workbook.xml',               $workbookXml);
        $zip->addFromString('xl/_rels/workbook.xml.rels',    $relsWorkbook);
        $zip->addFromString('xl/worksheets/sheet1.xml',      $sheetXml);
        $zip->addFromString('xl/styles.xml',                 $stylesXml);

        $zip->close();

        $content = file_get_contents($tmpFile);
        unlink($tmpFile);

        return $content;
    }

    /**
     * Konversi index kolom (0-based) ke huruf Excel (A, B, ..., Z, AA, AB, ...)
     */
    private function colLetter(int $index): string
    {
        $letter = '';
        $index++;
        while ($index > 0) {
            $index--;
            $letter = chr(65 + ($index % 26)) . $letter;
            $index  = (int) ($index / 26);
        }
        return $letter;
    }
}
