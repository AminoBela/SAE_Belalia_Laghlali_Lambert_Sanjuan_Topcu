<?php

namespace iutnc\nrv\action;

use iutnc\nrv\renderer\RendererAddSpectacleToSoiree;
use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\repository\SpectacleRepository;
use iutnc\nrv\repository\LieuRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use Exception;
use iutnc\nrv\repository\SpectacleToSoireeRepository;

/**
 * Class AddSpectacleToSoireeAction
 *
 * Action pour ajouter un spectacle à une soirée dans le système.
 *
 * @package iutnc\nrv\action
 */
class AddSpectacleToSoireeAction extends Action
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
     * @var SpectacleToSoireeRepository Instance du dépôt des relations spectacles-soirées.
     */
    protected SpectacleToSoireeRepository $spectacleToSoireeRepository;

    /**
     * @var SpectacleRepository Instance du dépôt des spectacles.
     */
    protected SpectacleRepository $spectacleRepository;

    /**
     * AddSpectacleToSoireeAction constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->soireeRepository = new SoireeRepository();
        $this->lieuRepository = new LieuRepository();
        $this->spectacleToSoireeRepository = new SpectacleToSoireeRepository();
        $this->spectacleRepository = new SpectacleRepository();
    }

    /**
     * Exécute l'action d'ajout de spectacle à une soirée.
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
                $idSpectacle = htmlspecialchars($_POST['idSpectacle'] ?? '', ENT_QUOTES);
                $soiree = htmlspecialchars($_POST['Soiree'] ?? '', ENT_QUOTES);

                $spectacle = $this->spectacleRepository->obtenirSpectacleParId($idSpectacle);
                if (!$spectacle) {
                    throw new ValidationException("Spectacle invalide.");
                }

                // Diviser la valeur de 'soiree' pour obtenir idLieu et dateSoiree
                $soireeParts = explode(',', $soiree);

                if (count($soireeParts) < 2) {
                    throw new ValidationException("Format de soirée invalide.");
                }

                $idLieu = $soireeParts[0];
                $dateSoiree = $soireeParts[1];

                $soiree = $this->soireeRepository->getSoireeById($idLieu, $dateSoiree);
                if (!$soiree) {
                    throw new ValidationException("Soirée invalide.");
                }
                $this->spectacleToSoireeRepository->ajouterSpectacleToSoiree($soiree, $spectacle);

                // Redirige vers la page d'accueil après l'ajout.
                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }

        // Récupère la liste des lieux, spectacles et soirées pour l'affichage du formulaire.
        $lieux = $this->lieuRepository->getAllLieux();
        $spectacles = $this->spectacleRepository->getListeSpectacles();
        $soirees = $this->soireeRepository->getAllSoiree();
        return (new RendererAddSpectacleToSoiree())->render(['error' => $error, 'idSpectacle' => $spectacles, 'soirees' => $soirees]);
    }
}
