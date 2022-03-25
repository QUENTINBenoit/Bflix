<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImageUploader
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function upload(Form $form, string $fieldName, $uploadFolder = null,)
    {
        // Si la variable $uploadFolder n'est pas définie, 
        // on utilise la variable d'environnement UPLOAD_FODLER
        // définie dans le fichier .env 
        $uploadFolder =  $uploadFolder ?? $_ENV['UPLOAD_FOLDER'];

        // je récupère le fichier "physique" avec  $form->get('image')->getData(); 
        $imageFile = $form->get($fieldName)->getData();
        // si je récupère une image à télévharger je la deplace dans le dossier uploads
        if ($imageFile) {
            $originalFileName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFileName = $this->slugger->slug($originalFileName);

            // Ms-social-cdcd4177211.jpeg
            $newFileName = $safeFileName . '-' . uniqid() . '.' . $imageFile->guessExtension();

            // Je déplace le fichier du dossier temporaire (/tmp/)
            // vers le dossier uploads
            try {
                // Si le déplacement s'est bien passé, je vais pouvoir
                // passer à la mise à jour de l'entité
                // $uploadFolder = 'uploads/images'
                $imageFile->move($uploadFolder, $newFileName);

                // A la fin de l'upload, on retourne le nom de l'image
                return $newFileName;
            } catch (FileException $e) {
                // Sinon, on affiche une erreur
                // Envoyer un Email à l'adminstrateur
                // Envoyer un message au client
            }
        }

        // Aucune image à uploader...on retourne null
        return null;
    }
}
