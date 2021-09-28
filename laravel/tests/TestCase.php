<?php

namespace Tests;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * 一般ユーザーとしてログインする
     *
     * @param User|null $user
     * @return User
     */
    public function login(User $user = null): User
    {
        $user = $user ?? factory(User::class)->create();

        $this->actingAs($user);

        return $user;
    }

    /**
     * 管理者ユーザーとしてログインする
     *
     * @param Admin|null $admin
     * @return Admin
     */
    public function loginAsAdmin(Admin $admin = null): Admin
    {
        $admin = $admin ?? factory(Admin::class)->create();

        $this->actingAs($admin);

        return $admin;
    }
}
