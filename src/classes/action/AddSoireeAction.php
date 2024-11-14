<?php

namespace iutnc\nrv\action;

use iutnc\nrv\models\Soiree;
use iutnc\nrv\repository\SoireeRepository;
use iutnc\nrv\repository\LieuRepository;
use iutnc\nrv\exception\ValidationException;
use iutnc\nrv\auth\Autorisation;
use iutnc\nrv\renderer\RendererAddSoiree;
use Exception;

class AddSoireeAction extends Action
{
    protected SoireeRepository $soireeRepository;
    protected LieuRepository $lieuRepository;

    public function __construct()
    {
        parent::__construct();
        $this->soireeRepository = new SoireeRepository();
        $this->lieuRepository = new LieuRepository();
    }

    public function execute(): string
    {
        if (!Autorisation::isStaff() && !Autorisation::isAdmin()) {
            return "<div style='color:red;'>Permission refusée : vous devez être admin ou staff.</div>";
        }

        $error = '';
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nomSoiree = htmlspecialchars($_POST['nomSoiree'] ?? '', ENT_QUOTES,'UTF-8');
                $thematique = htmlspecialchars($_POST['thematique'] ?? '', ENT_QUOTES,'UTF-8');
                $dateSoiree = htmlspecialchars($_POST['dateSoiree'] ?? '', ENT_QUOTES,'UTF-8');
                $horraireDebut = htmlspecialchars($_POST['horraireDebut'] ?? '', ENT_QUOTES,'UTF-8');
                $idLieu = htmlspecialchars($_POST['idLieu'] ?? '', ENT_QUOTES);

                if (empty($nomSoiree) || empty($thematique) || empty($dateSoiree) || empty($horraireDebut) || empty($idLieu)) {
                    throw new ValidationException("Tous les champs obligatoires doivent être remplis.");
                }

                $lieu = $this->lieuRepository->getLieuById($idLieu);
                if (!$lieu) {
                    throw new ValidationException("Lieu invalide.");
                }

                $soiree = new Soiree($nomSoiree, $thematique, $dateSoiree, $horraireDebut, $lieu);
                $this->soireeRepository->ajouterSoiree($soiree);

                header('Location: ?action=home');
                exit;
            }
        } catch (ValidationException $e) {
            $error = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        } catch (Exception $e) {
            $error = "Une erreur inattendue s'est produite : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }

        $lieux = $this->lieuRepository->getAllLieux();
        return (new RendererAddSoiree())->render(['error' => $error, 'lieux' => $lieux]);
    }
}