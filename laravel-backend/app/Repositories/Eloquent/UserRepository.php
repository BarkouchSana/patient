<?php
namespace App\Repositories\Eloquent;


use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }


       /**
     * Persiste un utilisateur (insert ou update).
     * Si l'objet User a un ID, il tentera une mise à jour.
     * Sinon, il créera un nouvel utilisateur.
     *
     * @param User $user L'instance du modèle App\Models\User à sauvegarder.
     * @return User L'instance du modèle App\Models\User sauvegardée.
     */
    public function save(User $user): User
    {
        // La logique de création/mise à jour est gérée par Eloquent directement sur l'objet User.
        // Si $user->password est défini et n'est pas déjà hashé, on le hashe.
        // (Cette logique peut aussi être dans un mutateur sur le modèle User)
        if ($user->isDirty('password') && !empty($user->password)) {
            $user->password = Hash::make($user->password);
        }
        $user->save();
        return $user;
    }

     /**
     * Crée un nouvel utilisateur.
     *
     * @param array $data Les données pour créer l'utilisateur.
     * @return User L'instance du modèle App\Models\User créée.
     */
    // public function create(array $data): User
    // {
    //     // S'assure que le mot de passe est hashé lors de la création
    //     if (isset($data['password'])) {
    //         $data['password'] = Hash::make($data['password']);
    //     }
    //     return User::create($data);
    // }

        /**
     * Met à jour un utilisateur existant.
     *
     * @param int $id L'ID de l'utilisateur à mettre à jour.
     * @param array $data Les données pour mettre à jour l'utilisateur.
     * @return User|null L'instance du modèle App\Models\User mise à jour, ou null si non trouvé.
     */
    // public function update(int $id, array $data): ?User
    // {
    //     $user = $this->findById($id);
    //     if ($user) {
    //         // Si un nouveau mot de passe est fourni, le hasher
    //         if (isset($data['password']) && !empty($data['password'])) {
    //             $data['password'] = Hash::make($data['password']);
    //         } elseif (isset($data['password']) && empty($data['password'])) {
    //             // Si le mot de passe est explicitement vide, ne pas le mettre à jour
    //             unset($data['password']);
    //         }
    //         $user->update($data);
    //         return $user;
    //     }
    //     return null;
    // }
}
