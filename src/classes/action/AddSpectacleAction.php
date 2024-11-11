<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\renderer\RendererAddSpectacle;
use Exception;

/**
 * Action pour ajouter un spectacle.
 * Ceci concerne la fonctionnalité 14. Creer un nouveau spectacle.
 */
class AddSpectacleAction extends Action
{

    /**
     * Attribut repository
     * @var SpectacleRepository $repository
     */
    protected SpectacleRepository $repository;

    /**
     * Constructeur
     * Ce constructeur initialise l'attribut repository.
     */
    public function __construct()
    {
        parent::__construct();
        $this->repository = new SpectacleRepository();
    }

    /**
     * Méthode execute
     * Cette méthode permet d'ajouter un spectacle.
     * @return string Retourne le résultat de l'action
     */
    public function execute(): string
    {
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        $error = '';
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                var_dump('Step 1: Starting POST processing');
                var_dump($_POST);
                var_dump($_FILES);

                $titre = filter_var($_POST['titre'] ?? '', FILTER_SANITIZE_STRING);
                $description = filter_var($_POST['description'] ?? '', FILTER_SANITIZE_STRING);
                $horrairePrevuSpectacle = filter_var($_POST['horairePrevuSpectacle'] ?? '', FILTER_SANITIZE_STRING);
                $genre = filter_var($_POST['genre'] ?? '', FILTER_SANITIZE_STRING);
                $dureeSpectacle = filter_var($_POST['dureeSpectacle'] ?? '', FILTER_VALIDATE_INT);

                if (empty($titre) || empty($description) || empty($horrairePrevuSpectacle) || empty($genre)) {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }

                $urlVideo = $this->handleFileUpload('urlVideo', 'videos/');
                $urlAudio = $this->handleFileUpload('urlAudio', 'audios/');

                $spectacle = new Spectacle(null, $titre, $description, $urlVideo, $urlAudio, $horrairePrevuSpectacle, $genre, $dureeSpectacle, 0);

                $this->repository->ajouterSpectacle($spectacle);

                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . $e->getMessage();
        }

        // Affichage du formulaire avec un éventuel message d'erreur
        return (new RendererAddSpectacle())->render(['error' => $error]);
    }

    /**
     * Méthode handleFileUpload
     * Cette méthode permet de gérer le téléchargement d'un fichier.
     * @param string $fieldName Nom du champ de fichier
     * @param string $destination Destination du fichier
     * @return string|null Retourne le chemin du fichier téléchargé
     */
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
