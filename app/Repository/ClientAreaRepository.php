<?php

namespace App\Repository;

use App\Models\Area;
use App\Models\Client;
use App\Models\ClientArea;
use App\Models\ClientAreaHour;
use App\Transformers\ClientAreaTransformer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ClientAreaRepository
{
    /**
     * Get list of paginated client areas.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getAll(Request $request): array
    {
        $client_areas = ClientArea::filter($request)->paginate($request->get('per_page', 20));

        return fractal($client_areas, new ClientAreaTransformer())->toArray();
    }

    /**
     * Get a client area by ID.
     *
     * @param  int  $id
     * @return array
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getById(int $id): array
    {
        $client_area = ClientArea::findOrFail($id);

        return fractal($client_area, new ClientAreaTransformer())->toArray();
    }

    /**
     * Store a new client area.
     *
     * @param  array  $attrs
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(array $attrs): array
    {
        $client = Client::find($attrs['client_id']);
        if ($client == null) {
            throw new BadRequestException("client not found");
        }

        $area = Area::find($attrs['area_id']);
        if ($area == null) {
            throw new BadRequestException("area not found");
        }

        $check_exist = ClientArea::select('id')
            ->where('client_id', $attrs['client_id'])
            ->where('area_id', $attrs['area_id'])
            ->first();

        if ($check_exist != null) {
            throw new BadRequestException("area sudah terisi, silahkan pilih area lainnya");
        }

        $client_area = new ClientArea($attrs);
        if (!$client_area->isValidFor('CREATE')) {
            throw new ValidationException($client_area->validator());
        }

        $client_area->save();

        // store working hours
        $working_hour_data = [];
        foreach ($attrs['working_hours'] as $working_hour) {
            $working_hour_data[] = [
                'client_area_id' => $client_area->id,
                'shift' => $working_hour['shift'],
                'time_start' => $working_hour['time_start'],
                'time_end' => $working_hour['time_end'],
                'status' => 1
            ];
        }

        ClientAreaHour::insert($working_hour_data);

        return fractal($client_area, new ClientAreaTransformer())->toArray();
    }

    /**
     * Update a client area by ID.
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
        $client_area = ClientArea::findOrFail($id);
        $client_area->fill($attrs);

        if (!$client_area->isValidFor('UPDATE')) {
            throw new ValidationException($client_area->validator());
        }

        $client_area->save();

        // sync working hours
        foreach ($attrs['working_hours'] as $working_hour) {
            $working_hour_data = [
                'client_area_id' => $client_area->id,
                'shift' => $working_hour['shift'],
                'time_start' => $working_hour['time_start'],
                'time_end' => $working_hour['time_end'],
                'status' => $working_hour['status']
            ];

            if ($working_hour['id'] != 0) {
                ClientAreaHour::where('id', $working_hour['id'])->update($working_hour_data);
            } else {
                ClientAreaHour::insert($working_hour_data);
            }
        }

        return fractal($client_area, new ClientAreaTransformer())->toArray();
    }

    /**
     * Delete a client area by ID.
     *
     * @param  int  $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function deleteById(int $id): bool
    {
        $client_area = ClientArea::findOrFail($id);

        return (bool) $client_area->delete();
    }
}
