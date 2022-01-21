<?php

namespace Egal\Auth;

use Egal\Core\EgalModel;
use Egal\Core\ModelMetadata;
use Illuminate\Support\Facades\Log;

class User extends EgalModel
{
    use HasRoles, HasPermissions, HasAuthorized;

    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    protected function generateAuthInformation(): array
    {
        return array_merge(
            $this->fresh()->toArray(),
            [
                'auth_identification' => $this->getAuthIdentifier(),
                'roles' => $this->getRoles(),
                'permissions' => $this->getPermissions(),
            ]
        );
    }

    static function getModelMetadata(): ModelMetadata
    {
        // TODO: Implement getModelMetadata() method.
    }

    public function cannot(string $__METHOD__):bool
    {
        return !Session::isUserServiceTokenExists();
    }
}