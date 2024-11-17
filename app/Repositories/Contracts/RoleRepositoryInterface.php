<?php

namespace App\Repositories\Contracts;

use App\Models\Role;

interface RoleRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByName(string $role);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
