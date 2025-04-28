<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Models\EloquentUser;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        $m = EloquentUser::find($id);
        if (! $m) return null;

        $u = new User();
        foreach (['id','name','email','password','phone','status','remember_token','created_at','updated_at'] as $f) {
            $prop = lcfirst(str_replace('_','',ucwords($f,'_')));
            $u->$prop = $m->$f;
        }
        return $u;
    }

    public function findByEmail(string $email): ?User
    {
        $m = EloquentUser::where('email',$email)->first();
        if (! $m) return null;
        return $this->findById($m->id);
    }

    public function save(User $user): User
    {
        $m = EloquentUser::updateOrCreate(
            ['id' => $user->id],
            [
              'name'     => $user->name,
              'email'    => $user->email,
              'password' => $user->password,
              'phone'    => $user->phone,
              'status'   => $user->status,
            ]
        );
        $user->id = $m->id;
        return $user;
    }
}
