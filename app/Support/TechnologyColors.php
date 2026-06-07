<?php

namespace App\Support;

class TechnologyColors
{
    public static function category(?string $category = null): array
    {
        return config('skill-categories.categories')[$category]
            ?? config('skill-categories.categories.All');
    }

    public static function technology(string $tech): array
    {
        $category = config("skill-categories.technologies.$tech");

        return self::category($category);
    }

    public static function badge(string $tech): string
    {
        return self::technology($tech)['badge'];
    }

    public static function dot(string $tech): string
    {
        return self::technology($tech)['dot'];
    }

    public static function light(string $category): string
    {
        return self::category($category)['light'];
    }

    public static function badgeByCategory(string $category): string
    {
        return self::category($category)['badge'];
    }

    public static function dotByCategory(string $category): string
    {
        return self::category($category)['dot'];
    }
}
