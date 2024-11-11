<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Soiree;
use iutnc\nrv\renderer\RendererAddSoiree;
use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use Exception;

/**
 * Action pour ajouter une soirée.
 * Ceci concerne la fonctionnalité 15. Creer une nouvelle soiree.
 */
class AddSoireeAction extends Action
{

    /**
     * Attribut repository
     * @var SoireeRepository $repository
     */
    protected SoireeRepository $repository;

    /**
     * Constructeur
     * Ce constructeur initialise l'attribut repository.
     */
    public function __construct()
    {
        parent::__construct();
        $this->repository = new SoireeRepository();
    }

    /**
     * Méthode execute
     * Cette méthode permet d'ajouter une soirée.
     * @return string Retourne le résultat de l'action
     */
    public function execute(): string //TODO RENDER A FAIRE
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

                $nomSoiree = filter_var($_POST['nomSoiree'] ?? '', FILTER_SANITIZE_STRING);
                $thematique = filter_var($_POST['thematique'] ?? '', FILTER_SANITIZE_STRING);
                $dateSoiree = filter_var($_POST['dateSoiree'] ?? '', FILTER_SANITIZE_STRING);
                $horraireDebut = filter_var($_POST['horraireDebut'] ?? '', FILTER_SANITIZE_STRING);
                $idLieu = filter_var($_POST['idLieu'] ?? '', FILTER_VALIDATE_INT);

                if (empty($nomSoiree) || empty($thematique) || empty($dateSoiree) || empty($horraireDebut))  {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }

                $soiree = new Soiree($dateSoiree, $nomSoiree, $thematique, $horraireDebut, $idLieu);

                $this->repository->ajouterSoiree($soiree);

                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = $e->getMessage();
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . $e->getMessage();
        }
        return (new RendererAddSoiree())->render(['error' => $error]);
    }
}
