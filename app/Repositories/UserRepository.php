<?php

namespace App\Repositories;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use App\Services\Contracts\FileStorageServiceContract;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function getAll(Request $request): LengthAwarePaginator
    {
        $users = User::select(config('custom.user.visible properties'))
            ->get()
            ->each(function($item) {
                if(!is_null($item->avatar)) {
                    $item->avatar = $this->getAvatar($item->avatar);
                }
        });

        $page = Paginator::resolveCurrentPage();
        $perPage = config('custom.user.index.count_rows');
        return new LengthAwarePaginator(
            $users->forPage($page, $perPage),
            $users->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    public function getUser(Request $request): User
    {
        $pathArray = explode('/', $request->getPathInfo());
        $id = array_pop($pathArray);

        $user = User::select(config('custom.user.visible properties'))
            ->firstWhere('id', $id);

        if(!is_null($user->avatar)) {
            $user->avatar = url($this->getAvatar($user->avatar));
        }
        return $user;
    }

    protected function getAvatar(string $file): string
    {
        if (!Storage::exists($file)) {
            return $file;
        }
        return Storage::url($file);
    }
}
