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

    /**
     * Форматирует телефонный номер, вставляя пробелы для лучшей читаемости.
     * Поддерживает номера в формате +7xxxxxxxxxx, 7xxxxxxxxxx, 8xxxxxxxxxx, а также 10-значные локальные номера.
     * Для международных номеров применяет группировку по 3 символа.
     * Возвращает null если вход пустой.
     */
    public static function formatPhone(?string $phone)
    {
        if (empty($phone)) {
            return null;
        }

        // Сохраняем plus отдельно
        $trimmed = trim($phone);
        $hasPlus = str_starts_with($trimmed, '+');
        // Оставляем только цифры
        $digits = preg_replace('/[^0-9]/', '', $trimmed);

        if ($digits === '') return null;

        // Российский формат: 11 цифр, начиная с 7 или 8 => +7 XXX XXX XX XX
        if (strlen($digits) === 11 && in_array($digits[0], ['7', '8'])) {
            $core = substr($digits, 1); // 10 цифр
            $parts = [substr($core, 0, 3), substr($core, 3, 3), substr($core, 6, 2), substr($core, 8, 2)];
            return '+7 ' . implode(' ', $parts);
        }

        // 10-значный локальный номер: XXX XXX XX XX (без country)
        if (strlen($digits) === 10) {
            $parts = [substr($digits, 0, 3), substr($digits, 3, 3), substr($digits, 6, 2), substr($digits, 8, 2)];
            return implode(' ', $parts);
        }

        // Если был плюс, возвращаем + и группируем остаток по 3
        if ($hasPlus) {
            $groups = preg_split('//u', $digits, -1, PREG_SPLIT_NO_EMPTY);
            // сгруппируем по 3 начиная с начала
            $out = [];
            $i = 0;
            while ($i < strlen($digits)) {
                $out[] = substr($digits, $i, 3);
                $i += 3;
            }
            return '+' . implode(' ', $out);
        }

        // Для прочих длин просто разбиваем на группы по 3
        $out = [];
        $i = 0;
        $len = strlen($digits);
        while ($i < $len) {
            $out[] = substr($digits, $i, 3);
            $i += 3;
        }
        return implode(' ', $out);
    }
}
