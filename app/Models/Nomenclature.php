<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;
use Laravel\Scout\Searchable;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;

class Nomenclature extends Model
{
    use HasFactory, UsesLandlordConnection, Searchable;

    protected $fillable = ['standard_name', 'aspak_code', 'keywords'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    // #[SearchUsingPrefix(['id', 'email'])]
    #[SearchUsingFullText(['standard_name', 'keywords'])]
    public function toSearchableArray()
    {
        $array = [
            'standard_name' => $this->standard_name,
            'keywords' => $this->keywords
        ];
 
        return $array;
    }
}
