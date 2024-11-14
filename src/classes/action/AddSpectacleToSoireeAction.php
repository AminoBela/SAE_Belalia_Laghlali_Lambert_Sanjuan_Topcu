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

class AddSpectacleToSoireeAction extends Action
{
    protected SoireeRepository $soireeRepository;
    protected LieuRepository $lieuRepository;
    protected SpectacleToSoireeRepository $spectacleToSoireeRepository;
    protected SpectacleRepository $spectacleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->soireeRepository = new SoireeRepository();
        $this->lieuRepository = new LieuRepository();
        $this->spectacleToSoireeRepository = new SpectacleToSoireeRepository();
        $this->spectacleRepository = new SpectacleRepository();
    }

    public function execute(): string
    {
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        $error = '';
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idSpectacle = htmlspecialchars($_POST['idSpectacle'] ?? '', ENT_QUOTES);
                $soiree = htmlspecialchars($_POST['Soiree'] ?? '', ENT_QUOTES);

                $spectacle = $this->spectacleRepository->obtenirSpectacleParId($idSpectacle);
                if (!$spectacle) {
                    throw new ValidationException("spectacle invalide.");
                }

                // Diviser la valeur de 'soiree' pour obtenir idLieu et dateSoiree
                $soireeParts = explode(',', $soiree);

                // Pour déboguer et afficher le contenu de soireeParts
                echo "<pre>";
                var_dump($soireeParts);
                echo "</pre>";

                if (count($soireeParts) < 2) {
                    throw new ValidationException("Format de soirée invalide.");
                }

                $idLieu = $soireeParts[0];
                $dateSoiree = $soireeParts[1];

                $soiree = $this->soireeRepository->getSoireeById($idLieu, $dateSoiree);
                if (!$soiree) {
                    throw new ValidationException("Soiree invalide.");
                }
                $this->spectacleToSoireeRepository->ajouterSpectacleToSoiree($soiree, $spectacle);

                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }

        $lieux = $this->lieuRepository->getAllLieux();
        $spectacles = $this->spectacleRepository->getListeSpectacles();
        $soirees = $this->soireeRepository->getAllSoiree();
        return (new RendererAddSpectacleToSoiree())->render(['error' => $error, 'idSpectacle' => $spectacles, 'soirees' => $soirees]);
    }
}
