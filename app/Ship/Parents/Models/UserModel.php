<?php

namespace App\Ship\Parents\Models;

use Apiato\Abstract\Models\UserModel as AbstractUserModel;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

abstract class UserModel extends AbstractUserModel
{
    use Notifiable;
    use HasApiTokens;
    use HasRoles;
}
