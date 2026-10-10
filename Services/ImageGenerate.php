<?php

namespace Portfolio\Services;

class ImageGenerate
{
    public function imageSize(string $originalName, string $tmpPath, int $w, int $h): string
    {
        // Type réel du fichier, pas celui annoncé par le navigateur
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($tmpPath);

        $loaders = [
            'image/jpeg' => 'imagecreatefromjpeg',
            'image/png'  => 'imagecreatefrompng',
            'image/webp' => 'imagecreatefromwebp',
        ];

        if (!isset($loaders[$mime])) {
            $_SESSION['error'] = 'Format non supporté (jpg, png, webp uniquement)';
            return '';
        }

        // Nettoyage du nom : accents, espaces, apostrophes
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $name = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $name);
        $name = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $name), '-'));
        if ($name === '') {
            $name = 'image-' . uniqid();
        }

        $destination = 'img/' . $name . '.webp';

        if (file_exists($destination)) {
            $_SESSION['error'] = $name . '.webp déjà existant !';
            return '';
        }

        $source = $loaders[$mime]($tmpPath);

        $newImage = imagecreatetruecolor($w, $h);
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);

        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $w, $h, imagesx($source), imagesy($source));
        imagewebp($newImage, $destination, 80);


        return $destination;
    }
}