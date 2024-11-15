<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Soiree;
use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\repository\LieuRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\renderer\RendererAddSoiree;
use Exception;

/**
 * Class AddSoireeAction
 *
 * Action pour ajouter une soirée dans le système.
 *
 * @package iutnc\nrv\action
 */
class AddSoireeAction extends Action
{
    /**
     * @var SoireeRepository Instance du dépôt des soirées.
     */
    protected SoireeRepository $soireeRepository;

    /**
     * @var LieuRepository Instance du dépôt des lieux.
     */
    protected LieuRepository $lieuRepository;

    /**
     * AddSoireeAction constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->soireeRepository = new SoireeRepository();
        $this->lieuRepository = new LieuRepository();
    }

    /**
     * Exécute l'action d'ajout de soirée.
     *
     * @return string Résultat de l'exécution de l'action sous forme de chaîne de caractères.
     */
    public function execute(): string
    {
        // Vérifie si l'utilisateur a les autorisations nécessaires.
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        $error = '';
        try {
            // Traitement des données du formulaire lors de la soumission.
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nomSoiree = htmlspecialchars($_POST['nomSoiree'] ?? '', ENT_QUOTES, 'UTF-8');
                $thematique = htmlspecialchars($_POST['thematique'] ?? '', ENT_QUOTES, 'UTF-8');
                $dateSoiree = htmlspecialchars($_POST['dateSoiree'] ?? '', ENT_QUOTES, 'UTF-8');
                $horraireDebut = htmlspecialchars($_POST['horraireDebut'] ?? '', ENT_QUOTES, 'UTF-8');
                $tarif = intval(htmlspecialchars($_POST['tarif'] ?? '', ENT_QUOTES));
                $idLieu = htmlspecialchars($_POST['idLieu'] ?? '', ENT_QUOTES);

                // Vérifie si tous les champs obligatoires sont remplis.
                if (empty($nomSoiree) || empty($thematique) || empty($dateSoiree) || empty($horraireDebut) || empty($idLieu) || empty($tarif)) {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }

                // Récupère le lieu en fonction de l'ID fourni.
                $lieu = $this->lieuRepository->getLieuById($idLieu);
                if (!$lieu) {
                    throw new ValidationException("Lieu invalide.");
                }

                echo var_dump($tarif);

                // Crée une nouvelle instance de Soiree et l'ajoute au dépôt.
                $soiree = new Soiree($nomSoiree, $thematique, $dateSoiree, $horraireDebut, $lieu, $tarif);
                $this->soireeRepository->ajouterSoiree($soiree);

                // Redirige vers la page d'accueil après l'ajout.
                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }

        // Récupère la liste des lieux pour l'affichage du formulaire.
        $lieux = $this->lieuRepository->getAllLieux();
        return (new RendererAddSoiree())->render(['error' => $error, 'lieux' => $lieux]);
    }
}
