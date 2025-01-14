<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Color;
use Illuminate\Support\Facades\Storage;



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
        // Fetch the Aktiv record with associated files
        $aktiv = \App\Models\Aktiv::where('id', $id)->with('files')->first();

        if (!$aktiv) {
            return response()->json(['error' => 'Aktiv not found'], 404);
        }

        // Initialize a new PowerPoint presentation
        $ppt = new PhpPresentation();

        // ===== SLIDE 1: General Information with Image =====
        $slide1 = $ppt->getActiveSlide();

        // Add the image on the left (col-6)
        if ($aktiv->files->isNotEmpty()) {
            $imagePath = storage_path('app/public/' . $aktiv->files->first()->path); // Local file path
            if (file_exists($imagePath)) {
                $slide1->createDrawingShape()
                    ->setName('Image')
                    ->setPath($imagePath)
                    ->setWidth(400) // Half width of the slide
                    ->setHeight(300)
                    ->setOffsetX(50) // Left side
                    ->setOffsetY(100); // Centered vertically
            }
        }

        // Add the text on the right (col-6)
        $details = $slide1->createRichTextShape()
            ->setHeight(300)
            ->setWidth(400) // Half width of the slide
            ->setOffsetX(500) // Right side
            ->setOffsetY(100); // Centered vertically
        $details->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $details->createTextRun("Объект номи: " . $aktiv->object_name . "\n")
            ->getFont()->setBold(true)->setSize(18)->setColor(new Color('FF000000'));
        $details->createTextRun("Локация: " . $aktiv->location . "\n");
        $details->createTextRun("Широта: " . $aktiv->latitude . "\n");
        $details->createTextRun("Долгота: " . $aktiv->longitude . "\n");
        $details->createTextRun("Кадастр рақами: " . $aktiv->kadastr_raqami . "\n");

        // Generate a map image using geolokatsiya (Google Maps link)
        if (!empty($aktiv->geolokatsiya)) {
            // Extract latitude and longitude from the Google Maps URL
            $coordinates = $this->extractCoordinatesFromUrl($aktiv->geolokatsiya);

            if ($coordinates) {
                list($latitude, $longitude) = $coordinates;

                // Generate the map image based on the coordinates
                $mapImagePath = $this->generateMapImage($latitude, $longitude);
                // dd($mapImagePath);
                if ($mapImagePath && file_exists($mapImagePath)) {
                    $slide1->createDrawingShape()
                        ->setName('Map')
                        ->setPath($mapImagePath)
                        ->setWidth(400)
                        ->setHeight(300)
                        ->setOffsetX(500) // Place next to text
                        ->setOffsetY(450);
                }
            }
        }

        // ===== SLIDE 2+: Images with Text =====
        foreach ($aktiv->files as $index => $file) {
            // Skip the first file since it's already on Slide 1
            if ($index === 0) continue;

            $slide = $ppt->createSlide();

            $imagePath = storage_path('app/public/' . $file->path); // Local file path
            if (file_exists($imagePath)) {
                // Image on the left (col-6)
                $slide->createDrawingShape()
                    ->setName('Image')
                    ->setPath($imagePath)
                    ->setWidth(400)
                    ->setHeight(300)
                    ->setOffsetX(50)
                    ->setOffsetY(100);
            }

            // Text on the right (col-6)
            $textBox = $slide->createRichTextShape()
                ->setHeight(300)
                ->setWidth(400)
                ->setOffsetX(500)
                ->setOffsetY(100);
            $textBox->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $textBox->createTextRun("Объект номи: " . $aktiv->object_name . "\n")
                ->getFont()->setBold(true)->setSize(18)->setColor(new Color('FF000000'));
            $textBox->createTextRun("Локация: " . $aktiv->location . "\n");
        }

        // ===== Save and Return the File =====
        $oWriterPPTX = IOFactory::createWriter($ppt, 'PowerPoint2007');
        $fileName = 'aktiv_' . $id . '.pptx';

        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $oWriterPPTX->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    private function extractCoordinatesFromUrl($geolokatsiya)
    {
        // Extract the latitude and longitude from the Google Maps URL
        preg_match('/q=([\-0-9.]+),([\-0-9.]+)/', $geolokatsiya, $matches);

        // Debugging the extraction result
        // dd($matches);  // Debug here

        if (count($matches) === 3) {
            $latitude = $matches[1];
            $longitude = $matches[2];
            return [$latitude, $longitude];
        }

        return null; // Return null if coordinates cannot be extracted
    }
    private function generateMapImage($latitude, $longitude)
    {
        $apiKey = 'AIzaSyAAnUwWTguBMsDU8UrQ7Re-caVeYCmcHQY'; // Replace with your actual API key
        $mapUrl = "https://maps.googleapis.com/maps/api/staticmap"
            . "?center={$latitude},{$longitude}"
            . "&zoom=14"
            . "&size=400x300"
            . "&maptype=roadmap"
            . "&markers=color:red%7Clabel:%7C{$latitude},{$longitude}"
            . "&key={$apiKey}";

        \Log::info("Generated Map URL: " . $mapUrl);  // Log the map URL to check

        // Use cURL to get the response and capture HTTP status code
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $mapUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        \Log::info("HTTP Code: " . $httpCode);  // Log the HTTP response code

        if ($httpCode != 200) {
            \Log::error("Failed to fetch map image. HTTP Code: " . $httpCode);
            return null; // Handle failure, maybe log or alert
        }

        // Save the image to the public directory
        $mapImagePath = public_path('maps/' . uniqid() . '.png');  // Save to public/maps folder
        // Ensure the directory exists
        if (!file_exists(public_path('maps'))) {
            mkdir(public_path('maps'), 0777, true); // Create the maps directory if it doesn't exist
        }

        file_put_contents($mapImagePath, $response);

        return $mapImagePath;
    }
}
