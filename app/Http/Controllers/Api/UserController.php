<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index() {
        return response()->json($this->userService->getAllUsers);
    }
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users,username',
                'name' => 'required|string|max:100',
                'lastname' => 'required|string|max:100',
                'phone' => 'required|string|max:15|unique:users,phone',
                'email' => 'required|email|max:100|unique:users,email',
                'password' => 'required|string|min:8',
                // 'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $user = $this->userService->createUser($validated, $request->file('photo'));

            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        return response()->json(['message' => 'Validation passed'], 200);
    }
}
