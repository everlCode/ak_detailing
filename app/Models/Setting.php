<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    /**
     * Получить значение по ключу с дефолтом
     */
    public static function get(string $key, $default = null)
    {
        $item = static::where('key', $key)->first();
        return $item ? $item->value : $default;
    }

    /**
     * Установить значение по ключу
     */
    public static function set(string $key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
