<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Account;

class AccountPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given account can be updated by the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Account  $account
     * @return bool
     */
    public function update(User $user, Account $account)
    {
        return true;
    }

    // Jika ingin menambahkan policy lain (misal: delete), bisa ditambahkan disini
    public function delete(User $user, Account $account)
    {
        return $user->id === $account->user_id;
    }

}
