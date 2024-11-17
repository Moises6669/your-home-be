<?php

namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentRoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function __construct(Role $model) {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id): ?Role
    {
        return $this->model->find($id);
    }

    public function findByName(string $roleName)
    {
        return $this->model->where('role_name', $roleName)->first();
    }

    public function create(array $data): Role
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): ?Role
    {
        $role = $this->model->find($id);
        if ($role) {
            $role->update($data);
            return $role;
        }
        return null;
    }

    public function delete($id): bool
    {
        $role = $this->model->find($id);
        if ($role) {
            return $role->delete();
        }
        return false;
    }
}
