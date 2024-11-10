<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\models\User;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\renderer\RendererAddSpectacle;
use iutnc\nrv\exception\ValidationException;
use Exception;

class AddSpectacleAction extends Action
{
    public function __construct()
    {
        parent::__construct();
        $repository = new SpectacleRepository();
    }

    public function execute(): string
    {
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], [User::ROLE_ADMIN, User::ROLE_STAFF])) {
            header('Location: ?action=login');
            return "";
        }
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $horairePrevuSpectacle = filter_var($_POST['horairePrevuSpectacle'], FILTER_SANITIZE_STRING);
            $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
            $dureeSpectacle = filter_var($_POST['dureeSpectacle'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $urlVideo = $this->uploadFile('urlVideo');
                $urlAudio = $this->uploadFile('urlAudio');
                $this->validate($titre, $description, $urlVideo, $urlAudio, $horairePrevuSpectacle, $genre, $dureeSpectacle);
                $spectacle = new Spectacle(0, $titre, $description, $urlVideo, $urlAudio, $horairePrevuSpectacle, $genre, $dureeSpectacle, 0);
                $repository = new SpectacleRepository();
                $repository->ajouterSpectacle($titre, $description, $urlVideo, $urlAudio, $horairePrevuSpectacle, $genre, $dureeSpectacle, 0);

                return "<p>Spectacle '$titre' ajouté avec succès.</p>";

            } catch (ValidationException $e) {
                $error = $e->getMessage();
            } catch (Exception $e) {
                $error = 'An unexpected error occurred. Please try again later.';
            }
        }

        $renderer = new RendererAddSpectacle();
        return $renderer->render(['error' => $error]);
    }

    private function validate(string $titre, string $description, string $urlVideo, string $urlAudio, string $horairePrevuSpectacle, string $genre, int $dureeSpectacle): void
    {
        if (empty($titre) || empty($description) || empty($urlVideo) || empty($urlAudio) || empty($horairePrevuSpectacle) || empty($genre) || empty($dureeSpectacle)) {
            throw new ValidationException("Tous les champs sont obligatoires.");
        }

        if (!file_exists($urlVideo)) {
            throw new ValidationException("L'URL Vidéo est invalide.");
        }

        if (!file_exists($urlAudio)) {
            throw new ValidationException("L'URL Audio est invalide.");
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $horairePrevuSpectacle)) {
            throw new ValidationException("L'horaire prévu doit être au format AAAA-MM-JJTHH:MM.");
        }
    }


    private function uploadFile(string $fichier): string
    {
        if (isset($_FILES[$fichier]) && $_FILES[$fichier]['error'] === UPLOAD_ERR_OK) {
            $fichierTmp = $_FILES[$fichier]['tmp_name'];
            $fichierExtension = pathinfo($_FILES[$fichier]['name'], PATHINFO_EXTENSION);
            $fichierName = uniqid() . '.' . $fichierExtension;
            $fichierDestination = __DIR__ . '/uploads/' . $fichierName;

            if (!is_dir(__DIR__ . '/uploads/')) {
                mkdir(__DIR__ . '/uploads/', 0755, true);
            }

            $mimeType = mime_content_type($fichierTmp);
            $allowedTypes = ['video/mp4', 'audio/mpeg', 'audio/wav'];
            if (!in_array($mimeType, $allowedTypes)) {
                throw new ValidationException("Le fichier doit être une vidéo ou un fichier audio valide.");
            }

            if (move_uploaded_file($fichierTmp, $fichierDestination)) {
                return $fichierDestination;
            } else {
                throw new ValidationException("Erreur lors de l'upload du fichier.");
            }
        } else {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => "Le fichier téléchargé dépasse la directive upload_max_filesize dans php.ini.",
                UPLOAD_ERR_FORM_SIZE => "Le fichier téléchargé dépasse la directive MAX_FILE_SIZE spécifiée dans le formulaire HTML.",
                UPLOAD_ERR_PARTIAL => "Le fichier téléchargé n'a été que partiellement téléchargé.",
                UPLOAD_ERR_NO_FILE => "Aucun fichier n'a été téléchargé.",
                UPLOAD_ERR_NO_TMP_DIR => "Il manque un dossier temporaire.",
                UPLOAD_ERR_CANT_WRITE => "Échec de l'écriture du fichier sur le disque.",
                UPLOAD_ERR_EXTENSION => "Une extension PHP a arrêté le téléchargement du fichier.",
            ];
            $errorCode = $_FILES[$fichier]['error'];
            $errorMessage = $errorMessages[$errorCode] ?? "Erreur inconnue lors de l'upload du fichier.";
            throw new ValidationException($errorMessage);
        }
    }

}