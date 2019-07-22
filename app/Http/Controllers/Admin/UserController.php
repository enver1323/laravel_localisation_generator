<?php


namespace App\Http\Controllers\Admin;


use App\Entities\Users\User;
use App\Entities\Users\UserRM;
use App\Http\Requests\Users\UserSearchRequest;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Services\Users\UserService;

class UserController extends AdminController
{
    private function getView(string $view): string
    {
        return sprintf('users.%s', $view);
    }

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(UserSearchRequest $request)
    {
        list($items, $queryObject) = $this->service->search($request, self::ITEMS_PER_PAGE);

        return $this->render($this->getView('userIndex'), [
            'items' => $items,
            'searchQuery' => $queryObject,
        ]);
    }

    public function create()
    {
        return $this->render($this->getView('userCreate'));
    }

    public function store(UserStoreRequest $request)
    {
        $this->service->create($request);

        return redirect()->route('admin.users.index');
    }

    public function show(UserRM $user)
    {
        return $this->render($this->getView('userShow'), [
            'item' => $user
        ]);
    }

    public function edit(UserRM $user)
    {
        return $this->render($this->getView('userEdit'), [
            'item' => $user
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $this->service->update($request, $user);

        return redirect()->route('admin.users.show', [
            'item' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $this->service->destroy($user);

        return redirect()->route('admin.users.index');
    }
}
