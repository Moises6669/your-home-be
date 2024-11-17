<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        RoleRepositoryInterface $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }

    public function getUserById($id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(array $data)
    {
        $data['activate'] = true;
        $data['verified'] = false;
        $user = $this->userRepository->create($data);

        $regularRole = $this->roleRepository->find('regular_user');

        if ($regularRole) {
            $user->roles()->attach($regularRole->id);
        }

        return $user;
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->userRepository->delete($id);
    }

    public function findUserByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }

    public function register(array $data):array
    {
        $user = $this->userRepository->create($data);
        $token = $user->createToken('auth_token')->aplainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function login(array $data):array
    {
        if (!Auth::attempt($data)) {
            return ['message' => 'Invalid login details'];
        }

        $user = $this->userRepository->findByEmail($data['email']);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function logout()
    {
        $user = Auth::user();
        // $user->token()->where('id', $user->currenAccessToken()->id)->delete();

        return ['message' => 'Successfully logged out'];
    }
}
