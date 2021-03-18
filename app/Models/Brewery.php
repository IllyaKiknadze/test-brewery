<?php

namespace App\Models;

use Jenssegers\Model\Model;

/**
 * App\Models\User
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $brewery_type
 * @property string|null $street
 * @property string|null $address_2
 * @property string|null $address_3
 * @property string|null $city
 * @property string|null $state
 * @property string|null $county_province
 * @property string|null $postal_code
 * @property string|null $country
 * @property string|null $longitude
 * @property string|null $latitude
 * @property string|null $phone
 * @property string|null $website_url
 * @property string|null $updated_at
 * @property string|null $created_at
 */
class Brewery extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($this->id) {
            $this->attributes['website_url'] = env('APP_URL') . "/api/breweries/" . $this->id;
        }
    }
}
