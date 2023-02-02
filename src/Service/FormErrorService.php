<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormErrorService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Constructor
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        // Stocker une référence au service Validator dans une variable privée pour une utilisation ultérieure.
        $this->validator = $validator;
    }

    /**
     * Récupérer les erreurs de formulaire
     *
     * @param mixed $form
     *
     * @return array
     */
    public function getErrorsFromForm($form)
    {
        // Utiliser le Validator pour valider les données du formulaire.
        $errors = $this->validator->validate($form);

        // Initialiser un tableau pour stocker les erreurs de formulaire.
        $formErrors = [];

        // Pour chaque erreur de validation, ajouter un message d'erreur à la clé correspondant au chemin de la propriété.
        foreach ($errors as $error) {
            $formErrors[$error->getPropertyPath()][] = $error->getMessage();
        }

        // Retourner le tableau d'erreurs de formulaire.
        return $formErrors;
    }
}