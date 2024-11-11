<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Soiree;
use iutnc\nrv\renderer\RendererAddSoiree;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\repository\SoireeRepository;

use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\renderer\RendererAddSpectacle;

class AddSoireeAction extends Action
{
    protected SoireeRepository $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new SoireeRepository();
    }

    public function execute(): string //il reste le render à faire
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
                $nomSoiree = filter_var($_POST['nomSoiree'] ?? '', FILTER_SANITIZE_STRING);
                $thematique = filter_var($_POST['thematique'] ?? '', FILTER_SANITIZE_STRING);
                $dateSoiree = filter_var($_POST['dateSoiree'] ?? '', FILTER_SANITIZE_STRING);
                $horraireDebut = filter_var($_POST['horraireDebut'] ?? '', FILTER_SANITIZE_STRING);
                $idLieu = filter_var($_POST['idLieu'] ?? '', FILTER_VALIDATE_INT);

                if (empty($nomSoiree) || empty($thematique) || empty($dateSoiree) || empty($horraireDebut))  {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }


                // Création du spectacle
                $soiree = new Soiree(
                    $dateSoiree,
                    $nomSoiree,
                    $thematique,
                    $horraireDebut,
                    $idLieu
                );

                // Sauvegarde dans la base
                $this->repository->ajouterSoiree($soiree);

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
        return (new RendererAddSoiree())->render(['error' => $error]);
    }
}
