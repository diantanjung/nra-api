<?php

namespace App\Repository;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use App\Models\UserContract;
use App\Models\UserProfile;
use App\Transformers\ClientContractTransformer;
use App\Transformers\ClientEmployeeTransformer;
use App\Transformers\ClientTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class ClientRepository
{
    /**
     * Get list of paginated clients.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function recap(): array
    {
        $clients = Client::all();

        return fractal($clients, new ClientTransformer())->toArray();
    }

    /**
     * Get a client by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $client = Client::findOrFail($id);

        return fractal($client, new ClientTransformer())->toArray();
    }

    /**
     * Store a new client.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): JsonResponse
    {
        $client = new Client($attrs);
        if (!$client->isValidFor('CREATE')) {
            throw new ValidationException($client->validator());
        }

        $client->save();

        return responseSuccess($client);
    }

    /**
     * Update a client by ID.
     *
     * @param  int  $id
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateById(int $id, array $attrs): array
    {
        $client = Client::findOrFail($id);
        $client->fill($attrs);

        if (!$client->isValidFor('UPDATE')) {
            throw new ValidationException($client->validator());
        }

        $client->save();

        return fractal($client, new ClientTransformer())->toArray();
    }

    /**
     * Delete a client by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $client = Client::findOrFail($id);

        return (bool) $client->delete();
    }

    /**
     * get employee list by client id
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function employees(Request $request): array
    {
        $users = User::where('client_id', $request->id)
            ->whereIn('role_id', Role::USER_ONLY_ID)
            ->where('name', 'like', '%' . $request->keyword . '%')
            ->get();

        return fractal($users, new ClientEmployeeTransformer())->toArray();
    }

    /**
     * update user contract
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateContract(Request $request): array
    {
        $user_contract = UserContract::create([
            'user_id' => $request->user_id,
            'contract_type_id' => $request->contract_type_id,
            'effective_date_start' => $request->effective_date_start,
            'effective_date_end' => $request->effective_date_end,
            'note' => $request->note,
        ]);

        $user_profile = UserProfile::where('user_id', $request->user_id)->first();
        $user_profile->update(['contract_id' => $user_contract->id]);

        return fractal($user_contract, new ClientContractTransformer())->toArray();
    }
}
