<?php

namespace App\Ship\Parents\Models;

use Apiato\Abstract\Models\UserModel as AbstractUserModel;
use App\Ship\Contracts\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

abstract class UserModel extends AbstractUserModel implements Authorizable
{
    use Notifiable;
    use HasApiTokens;
    use HasRoles;
}
