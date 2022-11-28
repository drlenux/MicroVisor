<?php

namespace app;

class Helper
{
    public static function getMin(array $data, $key)
    {
        $min = null;

        foreach ($data as $val) {
            if ($min === null) {
                $min = $val[$key];
            } else {
                $min = min($min, $val[$key] ?? null);
            }
        }

        return $min;
    }

    public static function getMax(array $data, $key)
    {
        $max = null;

        foreach ($data as $val) {
            $max = max($max, $val[$key] ?? null);
        }

        return $max;
    }

    public static function getDate(?int $timestamp, string $format = 'Y-m-d H:i:s'): ?string
    {
        if (!$timestamp) return null;
        return date($format, $timestamp);
    }
}