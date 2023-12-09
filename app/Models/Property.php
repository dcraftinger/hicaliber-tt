<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
    ];

    public function scopeFiltered(Builder $query, array $filterValues = []): Builder
    {
        $filterSettings = [
            'name' => ['type' => 'partial'],
            'price' => ['type' => 'range'],
            'bedrooms' => ['type' => 'exact'],
            'bathrooms' => ['type' => 'exact'],
            'storeys' => ['type' => 'exact'],
            'garages' => ['type' => 'exact'],
        ];

        foreach ($filterValues as $key => $value) {
            $filterType = $filterSettings[$key]['type'] ?? null;

            if (! isset($filterType, $value)) {
                continue;
            }

            if ($filterType === 'exact') {
                $query->where($key, '=', $value);
            } elseif ($filterType === 'partial') {
                $query->where($key, 'like', "%{$value}%");
            } elseif ($filterType === 'range') {
                $query->whereBetween($key, $value);
            }
        }

        return $query;
    }
}
