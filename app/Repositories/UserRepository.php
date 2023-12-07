<?php

namespace App\Repositories;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\FileStorageServiceContract;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryContract
{
    protected array $fields;

    public function __construct(
        protected FileStorageServiceContract $service
    ) {}

    public function create(RegisterRequest $request): User|false
    {
        try{
            DB::beginTransaction();

            $this->fields = $request->validated();
            if (isset($this->fields['avatar'])) {
                $this->fields['avatar'] = $this->service->upload($this->fields['avatar'], config('custom.user.avatar.dir'));
            }
            $user = User::create($this->fields);

            DB::commit();

            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            $this->service::remove($this->fields['avatar']);
            logs()->warning($exception);
            return false;
        }
    }
}
