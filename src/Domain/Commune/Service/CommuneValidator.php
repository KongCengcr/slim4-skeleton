<?php

namespace App\Domain\Commune\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class CommuneValidator
{
    public function validateCommune(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('name', true, 'Input required')
            ->notEmptyString('name', 'Input required')
            ->maxLength('name', 255, 'Too long')
            ->requirePresence('idJurisdiction', true, 'Input required')
            ->notEmptyString('idJurisdiction', 'Input required')
            ->maxLength('idJurisdiction', 255, 'Too long')
            ->naturalNumber('idJurisdiction', 'Invalid id jurisdiction');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function validateUpdateCommune(array $data): void
    {
        $validator = new Validator();
        $validator
            ->allowEmptyString('name') // Permite que 'name' sea vacío u omitido
            ->maxLength('name', 255, 'Too long')
            ->allowEmptyString('idJurisdiction') // Permite que 'name' sea vacío u omitido
            ->maxLength('idJurisdiction', 255, 'Too long')
            ->naturalNumber('idJurisdiction', 'Invalid id jurisdiction');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
