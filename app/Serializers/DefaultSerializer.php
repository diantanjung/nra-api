<?php

namespace App\Serializers;

use League\Fractal\Serializer\ArraySerializer;

class DefaultSerializer extends ArraySerializer
{
    /**
     * {@inheritDoc}
     */
    public function collection(?string $resourceKey, array $data): array
    {
        return ['status' => 200, 'message' => "Successfully", 'data' => $data];
    }

    /**
     * {@inheritDoc}
     */
    public function item(?string $resourceKey, array $data): array
    {
        return ['status' => 200, 'message' => "Successfully", 'data' => $data];
    }

    /**
     * {@inheritDoc}
     */
    public function null(): ?array
    {
        return [];
    }
}
