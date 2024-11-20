<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findByEmail($email);
    public function assignRole($userId,$roleName);
    public function attachProfileImage(User $user,array $imageData);
}
