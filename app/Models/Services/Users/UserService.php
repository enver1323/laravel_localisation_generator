<?php


namespace App\Services\Users;


use App\Entities\StatusMessage;
use App\Entities\Users\User;
use App\Entities\Users\UserRM;
use App\Http\Requests\Users\UserSearchRequest;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Services\CustomService;
use Illuminate\Support\Facades\Hash;

class UserService extends CustomService
{
    private $entity;
    private $model;

    public function __construct(User $entity, UserRM $model)
    {
        $this->entity = $entity;
        $this->model = $model;
    }

    public function search(UserSearchRequest $request, int $itemsPerPage): array
    {
        $query = $this->model;
        $object = (object)[];

        if (!empty($request->input()))
            list($query, $object) = $this->formSearch($request, $query, $object);

        return [$query->paginate($itemsPerPage), $object];
    }

    private function formSearch(UserSearchRequest $request, UserRM $query, $object): array
    {
        if ($request->input('id')) {
            $object->id = $request->input('id');
            $query = $query->where('id', '=', $request->input('id'));
        }

        if ($request->input('name')) {
            $object->name = $request->input('name');
            $query = $query->where('name', 'LIKE', "%$object->name%");
        }

        if ($request->input('email')) {
            $object->email = $request->input('email');
            $query = $query->where('email', 'LIKE', "%$object->email%");
        }

        if (!$query->count()) {
            $query = $this->model;
            $this->fireStatusMessage(StatusMessage::TYPES['warning'], 'Nothing was found according to your query');
        }

        return [$query, $object];
    }

    public function create(UserStoreRequest $request): void
    {
        $item = $this->entity->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "User \"$item->name\" was successfully created");
        return;
    }

    public function update(UserUpdateRequest $request, User $item): void
    {
        $item->name = $request->input('name');
        $item->email = $request->input('email');
        $item->password = $request->input('password') === null ? $item->password : Hash::make($request->input('password'));
        $item->updated_at = time();
        $item->save();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "User \"$item->name\" was successfully modified");
        return;
    }

    public function destroy(User $item): void
    {
        $name = $item->name;
        $item->delete();

        $this->fireStatusMessage(StatusMessage::TYPES['success'], "User \"$name\" was successfully deleted");
    }
}
