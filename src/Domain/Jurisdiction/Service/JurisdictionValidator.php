<?php

namespace App\Domain\Jurisdiction\Service;

use App\Support\Validation\ValidationException;
use Cake\Validation\Validator;

final class JurisdictionValidator
{
    public function validateJurisdiction(array $data): void
    {
        $validator = new Validator();
        $validator
            ->requirePresence('name', true, 'Input required')
            ->notEmptyString('name', 'Input required')
            ->maxLength('name', 255, 'Too long');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }

    public function validateUpdateJurisdiction(array $data): void
    {
        $validator = new Validator();
        $validator
            ->allowEmptyString('name') // Permite que 'name' sea vacío u omitido
            ->maxLength('name', 255, 'Too long')
            ->allowEmptyString('status') // Permite que 'status' sea vacío u omitido
            ->inList('status', ['ACTIVE', 'DISABLE'], 'Invalid status. Allowed values are ACTIVE or DISABLE');

        $errors = $validator->validate($data);

        if ($errors) {
            throw new ValidationException('Please check your input', $errors);
        }
    }
}
