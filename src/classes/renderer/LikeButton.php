<?php

namespace iutnc\nrv\renderer;

use iutnc\nrv\repository\PreferencesRepository;

class LikeButton
{
    /**
     * Rendu du bouton like
     * @param string $idSpectacle Id du spectacle
     * @param int $size Taille du bouton
     * @param string $chemin Chemin de la page
     * @return string Code HTML du bouton like
     */
    public static function renderLikeButton(string $idSpectacle, int $size, string $chemin): string
    {
        // On récupère l'instance du repository des préférences
        $preferencesRepository = PreferencesRepository::getInstance();

        // On vérifie si le spectacle est dans les préférences
        $estAjouterPref = $preferencesRepository->estAjouterPref($idSpectacle);

        // On détermine les classes CSS à appliquer
        $likeIconClassName = $estAjouterPref ? 'like-icon-liked' : 'like-icon';
        $estAjouterPrefClassName = $estAjouterPref ? 'inner-fill-liked' : 'inner-fill';

        // On retourne le code HTML du bouton like
        return "<a class='like-icon-a' href='?action=$chemin&ajouterPref={$idSpectacle}'>
                <svg class='$likeIconClassName' fill=\"#000000\" height=\"800px\" width=\"800px\" version=\"1.1\" id=\"Capa_1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                     viewBox=\"0 0 471.701 471.701\" xml:space=\"preserve\">
                <style>
                /* On ajoute une classe CSS pour le bouton (car sinon se met pas à jour dynamiquement) */
                /* On change aussi le nom de la classe car sinon les couleurs ne se mettent pas à jour dynamiquement */
                    .inner-fill {
                        stroke: black;
                        stroke-width: " . $size / 2 . "px;
                        fill: white;
                    }
    
                    .inner-fill:hover {
                        fill: #ff7784;
                    }
                    
                    .inner-fill-liked {
                        fill: #ff7784;
                    }
                    
                    .inner-fill-liked:hover {
                        fill: white;
                    }
                    
                    .like-icon {
                        width: " . $size . "px;
                        height: " . $size . "px;
                        fill: black;
                        transition: filter 0.3s ease;
                    }
                    
                    .like-icon:hover {
                        filter: drop-shadow(0 0 0.75rem #ff7784);
                        transform: scale(1.1);
                    }
                    
                    .like-icon-liked {
                        fill: black;
                        width: " . $size . "px;
                        height: " . $size . "px;
                        transition: filter 0.3s ease;
                    }
                    
                    .like-icon-liked:hover {
                        filter: drop-shadow(0 0 0.75rem black);
                        transform: scale(1.1);
                    }
                </style>
                <g>
                    <path d=\"M433.601,67.001c-24.7-24.7-57.4-38.2-92.3-38.2s-67.7,13.6-92.4,38.3l-12.9,12.9l-13.1-13.1
                        c-24.7-24.7-57.6-38.4-92.5-38.4c-34.8,0-67.6,13.6-92.2,38.2c-24.7,24.7-38.3,57.5-38.2,92.4c0,34.9,13.7,67.6,38.4,92.3
                        l187.8,187.8c2.6,2.6,6.1,4,9.5,4c3.4,0,6.9-1.3,9.5-3.9l188.2-187.5c24.7-24.7,38.3-57.5,38.3-92.4
                        C471.801,124.501,458.301,91.701,433.601,67.001z M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3
                        s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4
                        c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3
                        C444.801,187.101,434.001,213.101,414.401,232.701z\"/>
                    /* L'élément path juste en dessous est celui qui change de couleur */
                    <path class=\"$estAjouterPrefClassName\" d=\"M414.401,232.701l-178.7,178l-178.3-178.3c-19.6-19.6-30.4-45.6-30.4-73.3
                    s10.7-53.7,30.3-73.2c19.5-19.5,45.5-30.3,73.1-30.3c27.7,0,53.8,10.8,73.4,30.4l22.6,22.6c5.3,5.3,13.8,5.3,19.1,0l22.4-22.4
                    c19.6-19.6,45.7-30.4,73.3-30.4c27.6,0,53.6,10.8,73.2,30.3c19.6,19.6,30.3,45.6,30.3,73.3
                    C444.801,187.101,434.001,213.101,414.401,232.701z\"/>
                </g>
                </svg>
                </a>";
    }

}