<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdminOrPetugas();
    }

    public function view(User $user, Payment $payment): bool
    {
        return $user->isAdminOrPetugas() || $user->id === $payment->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Payment $payment): bool
    {
        return $user->isAdminOrPetugas();
    }

    public function delete(User $user, Payment $payment): bool
    {
        return $user->isAdmin();
    }
}
