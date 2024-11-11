<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\renderer\RendererAddSpectacle;

class AddSpectacleAction extends Action
{
    protected SpectacleRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new SpectacleRepository();
    }

    public function execute(): string
    {
        // Vérification des permissions via Autorisation
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        $error = '';
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                var_dump('Step 1: Starting POST processing'); // Débogage
                var_dump($_POST); // Vérifie les données POST
                var_dump($_FILES); // Vérifie les fichiers uploadés

                // Validation des champs obligatoires
                $titre = filter_var($_POST['titre'] ?? '', FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_STRING);
                $horrairePrevuSpectacle = filter_var($_POST['horairePrevuSpectacle'] ?? '', FILTER_SANITIZE_STRING);
                $genre = filter_var($_POST['genre'] ?? '', FILTER_SANITIZE_STRING);
                $dureeSpectacle = filter_var($_POST['dureeSpectacle'] ?? '', FILTER_VALIDATE_INT);

                if (empty($titre) || empty($description) || empty($horrairePrevuSpectacle) || empty($genre)) {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }

                // Traitement des fichiers uploadés
                $urlVideo = $this->handleFileUpload('urlVideo', 'videos/');
                $urlAudio = $this->handleFileUpload('urlAudio', 'audios/');



                // Création du spectacle
                $spectacle = new Spectacle(
                    null,
                    $titre,
                    $description,
                    $urlVideo,
                    $urlAudio,
                    $horrairePrevuSpectacle,
                    $genre,
                    $dureeSpectacle,
                    0
                );

                // Sauvegarde dans la base
                $this->repository->ajouterSpectacle($spectacle);

                // Redirection vers l'accueil
                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = $e->getMessage();
        } catch (\Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . $e->getMessage();
        }

        // Affichage du formulaire avec un éventuel message d'erreur
        return (new RendererAddSpectacle())->render(['error' => $error]);
    }

    private function handleFileUpload(string $fieldName, string $destination): ?string
    {
        if (isset($_FILES[$fieldName]) && $_FILES[$fieldName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/' . $destination;
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $fileName = basename($_FILES[$fieldName]['name']);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES[$fieldName]['tmp_name'], $filePath)) {
                return 'uploads/' . $destination . $fileName;
            } else {
                throw new ValidationException("Erreur lors du téléchargement du fichier $fieldName.");
            }
        }

        throw new ValidationException("Fichier $fieldName manquant ou invalide.");
    }
}
