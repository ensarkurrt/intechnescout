<?php

namespace App\Casts;

use App\Helpers\CryptionHelper;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class EncryptionCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        $decoded = CryptionHelper::decode($value);
        return $decoded == false ? null : $decoded;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        $encoded = CryptionHelper::encode($value);
        return $encoded == false ? null : $encoded;
    }
}
