<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BreweryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'brewery_type'    => $this->brewery_type,
            'street'          => $this->street,
            'address_2'       => $this->address_2,
            'address_3'       => $this->address_3,
            'city'            => $this->city,
            'state'           => $this->state,
            'county_province' => $this->county_province,
            'postal_code'     => $this->postal_code,
            'country'         => $this->country,
            'longitude'       => $this->longitude,
            'latitude'        => $this->latitude,
            'phone'           => $this->phone,
            'website_url'     => $this->website_url,
            'updated_at'      => $this->updated_at,
            'created_at'      => $this->created_at
        ];
    }
}
