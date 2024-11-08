<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Spectacle;
use iutnc\nrv\models\User;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\renderer\RendererAddSpectacle;
use iutnc\nrv\exception\ValidationException;

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
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_STRING);
            $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
            $urlVideo = filter_var($_POST['urlVideo'], FILTER_SANITIZE_URL);
            $urlAudio = filter_var($_POST['urlAudio'], FILTER_SANITIZE_URL);
            $horairePrevuSpectacle = filter_var($_POST['horairePrevuSpectacle'], FILTER_SANITIZE_STRING);
            $genre = filter_var($_POST['genre'], FILTER_SANITIZE_STRING);
            $dureeSpectacle = filter_var($_POST['dureeSpectacle'], FILTER_SANITIZE_NUMBER_INT);

            try {
                $this->validate($titre, $description, $urlVideo, $urlAudio, $horairePrevuSpectacle, $genre, $dureeSpectacle);
                $spectacle = new Spectacle(0, $titre, $description, $urlVideo, $urlAudio, $horairePrevuSpectacle, $genre, $dureeSpectacle, 0);
                $repository = new SpectacleRepository();
                $repository->ajouterSpectacle($spectacle);

                header('Location: ?action=home');
                exit();

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

        if (!filter_var($urlVideo, FILTER_VALIDATE_URL)) {
            throw new ValidationException("L'URL Vidéo est invalide.");
        }

        if (!filter_var($urlAudio, FILTER_VALIDATE_URL)) {
            throw new ValidationException("L'URL Audio est invalide.");
        }

        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $horairePrevuSpectacle)) {
            throw new ValidationException("L'horaire prévu doit être au format AAAA-MM-JJTHH:MM.");
        }
    }
}