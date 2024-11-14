<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\renderer\RendererAddSpectacle;
use Exception;

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
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        $error = '';
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titre = htmlspecialchars($_POST['titre'] ?? '', ENT_QUOTES,'UTF-8');
                $description = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES);
                $horairePrevuSpectacle = htmlspecialchars($_POST['horairePrevuSpectacle'] ?? '', ENT_QUOTES,'UTF-8');
                $genre = htmlspecialchars($_POST['genre'] ?? '', ENT_QUOTES,'UTF-8');
                $dureeSpectacle = htmlspecialchars($_POST['dureeSpectacle'] ?? '', ENT_QUOTES,'UTF-8');

                if (empty($titre) || empty($description) || empty($genre)) {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }

                $urlVideo = $this->handleFileUpload('urlVideo', 'videos/');
                $urlAudio = $this->handleFileUpload('urlAudio', 'audios/');

                $spectacle = new Spectacle(null, $titre, $description, $urlVideo, $urlAudio, $horairePrevuSpectacle, $genre, $dureeSpectacle, 0);

                $this->repository->ajouterSpectacle($spectacle);

                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }

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