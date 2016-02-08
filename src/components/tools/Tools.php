<?php
/**
 * Created by PhpStorm.
 * User: Kévin
 * Date: 16/12/2015
 * Time: 09:48
 */

namespace Core\Components\Tools;

class Tools
{
    /**
     * fonction de redirection
     */
    public function redirect($url, $time)
    {
        try {
            die('<meta http-equiv="refresh" content="'.$time.'; url='.$url.'">');
        } catch (ToolsExceptions $e) {
            throw new ToolsExceptions($e->getMessage());
        }
    }

    /**
     * fonction d'upload de fichier
     */
    public function upload($file, $uploadPath, $maxFileSize = 2000000, $newName = false) {
        try {
            $extensionAccepted = ['.png','.jpg','.jpeg','.gif'];
            $fileExtension = strtolower(substr($file['name'],strripos($file['name'],'.')));
            $id = uniqid(rand());
            $fileNewName = (!$newName)?$id.$fileExtension:$newName;

            $uploadError = [
                1 => 'La taille du fichier téléchargé est supérieure à la limite autorisée',
                2 => 'La taille du fichier téléchargé est supérieure à la limite autorisée',
                3 => 'Le fichier n\'a pas été correctement téléchargé',
                4 => 'Aucun fichier n\'a été téléchargé',
                6 => 'Le dossier temporaire pour le transfert du fichier est manquant',
                7 => 'Echec de l\'écriture du fichier sur le disque',
                8 => 'Une extension PHP a arrété l\'envoi de fichier'
            ];

            // si erreur d'upload
            if ($file['error'] > 0)
                return ['success' => false, 'message' => (isset($uploadPath[$file['error']])?$uploadError[$file['error']]:'Erreur inconnue')];

            // si le type du fichier n'est pas bon
            if (!in_array($fileExtension, $extensionAccepted))
                return ['success' => false, 'message' => 'le fichier n\'est pas une image'];

            // si fichier trop gros
            if ($file['size'] > $maxFileSize)
                return ['success' => false, 'message' => 'le fichier est trop lourd, 2Mo max'];

            // si jamais le fichier existe déjà on change son nom
            while (file_exists($uploadPath.'/'.$fileNewName)) {
                $id = uniqid(rand());
                $fileNewName = $id.$fileExtension;
            }

            $filePathAndName = $uploadPath.$fileNewName;

            $compressPathAndName = $uploadPath.'cp-'.$fileNewName;

            $resultat = move_uploaded_file($file['tmp_name'],$filePathAndName);

            if ($resultat) {
                // add compress function here
                if ($this->compress_image($filePathAndName, $compressPathAndName, 90))
                    return ['success' => true, 'message' => 'le fichier à bien été transféré et compressé', 'filename' => $fileNewName];
                else
                    return ['success' => true, 'message' => 'le fichier à bien été transféré, mais non compressé', 'filename' => $fileNewName];
            } else
                return ['success' => false, 'message' => 'Une erreur est survenue lors du transfert'];
        } catch (ToolsExceptions $e) {
            throw new ToolsExceptions($e->getMessage());
        }
    }

    /**
     * fonction de compression des images
     */
    public function compress_image($source_url, $destination_url, $quality) {
        $info = getimagesize($source_url);
        $image = null;

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);

        //save file
        if (!imagejpeg($image, $destination_url, $quality))
            throw new ToolsExceptions("Impossible de sauvegarder l'image compressé");

        //return destination file
        return $destination_url;
    }

    /**
     * get POST or GET value
     */
    public function getValue($name)
    {
        if (empty($_POST[$name]) && empty($_GET[$name]))
            throw new ToolsExceptions("Les paramètres GET['".$name."''] et POST['".$name."'] n'existe pas");

        if (!empty($_POST[$name] && empty($_GET[$name])))
            return $_POST[$name];
        else if (empty($_POST[$name] && !empty($_GET[$name])))
            return $_GET[$name];
        else if (!empty($_POST[$name] && !empty($_GET[$name])))
            return ['get' => $_GET[$name], 'post' => $_GET[$name]];
        else
            return false;
    }

    /**
     * get POST value $name
     */
    public function getPostValue($name)
    {
        if (empty($_GET[$name]))
            throw new ToolsExceptions("Le paramètre GET['".$name."']");

        return $_POST[$name];
    }

    /**
     * get GET value $name
     */
    public function getGetValue($name)
    {
        if (empty($_GET[$name]))
            throw new ToolsExceptions("Le paramètre GET['".$name."']");

        return $_GET[$name];
    }
}