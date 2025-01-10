<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;

class ExportController extends Controller
{
    public function exportToPptx()
    {
        $data = \App\Models\Aktiv::with('files')->get(); // Adjust query as needed

        $ppt = new PhpPresentation();
        $slide = $ppt->getActiveSlide();

        foreach ($data as $aktiv) {
            $shape = $slide->createRichTextShape()
                ->setHeight(300)
                ->setWidth(600)
                ->setOffsetX(170)
                ->setOffsetY(100);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $textRun = $shape->createTextRun("Локация: " . $aktiv->location);
            $textRun->getFont()->setBold(true)->setSize(20)->setColor(new Color('FF000000'));

            $slide = $ppt->createSlide();
        }

        $oWriterPPTX = IOFactory::createWriter($ppt, 'PowerPoint2007');
        $fileName = 'exported_data.pptx';

        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $oWriterPPTX->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
    public function exportToPptx_id($id)
    {
        $aktiv = \App\Models\Aktiv::where('id', $id)->with('files')->first();

        if (!$aktiv) {
            return response()->json(['error' => 'Aktiv not found'], 404);
        }

        $ppt = new PhpPresentation();

        // Add the first slide with details
        $slide = $ppt->getActiveSlide();

        $shape = $slide->createRichTextShape()
            ->setHeight(100)
            ->setWidth(800)
            ->setOffsetX(50)
            ->setOffsetY(50);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $textRun = $shape->createTextRun("Бектемир туман ҳокимлиги");
        $textRun->getFont()->setBold(true)->setSize(24)->setColor(new Color('FF000000'));

        $shape = $slide->createRichTextShape()
            ->setHeight(300)
            ->setWidth(800)
            ->setOffsetX(50)
            ->setOffsetY(150);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $shape->createTextRun("Локация: " . $aktiv->location . "\n");
        $shape->createTextRun("Широта: " . $aktiv->latitude . "\n");
        $shape->createTextRun("Долгота: " . $aktiv->longitude . "\n");
        $shape->createTextRun("Кадастр рақами: " . $aktiv->kadastr_raqami . "\n");

        // Add slides for each file with images
        if ($aktiv->files) {
            foreach ($aktiv->files as $file) {
                $slide = $ppt->createSlide();

                $imagePath = storage_path('app/public/' . $file->path);
                if (file_exists($imagePath)) {
                    $slide->createDrawingShape()
                        ->setName('File Image')
                        ->setPath($imagePath)
                        ->setWidth(600) // Adjust width and height as needed
                        ->setHeight(400)
                        ->setOffsetX(100)
                        ->setOffsetY(100);
                } else {
                    $shape = $slide->createRichTextShape()
                        ->setHeight(300)
                        ->setWidth(800)
                        ->setOffsetX(50)
                        ->setOffsetY(100);
                    $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    $shape->createTextRun("Файл: " . $file->path . " (image not found)");
                }
            }
        }

        // Save the presentation
        $oWriterPPTX = IOFactory::createWriter($ppt, 'PowerPoint2007');
        $fileName = 'aktiv_' . $id . '.pptx';

        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $oWriterPPTX->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
