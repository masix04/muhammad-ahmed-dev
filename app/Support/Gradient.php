<?php

namespace App\Support;

/**
 * A stable, good-looking gradient for things that have no image of their own
 * (projects without a thumbnail, blog posts without a cover). The same title
 * always gets the same gradient.
 */
class Gradient
{
    // Written out in full so Tailwind finds every class.
    private const SET = [
        'from-violet-600 via-fuchsia-500 to-amber-300',
        'from-emerald-500 via-teal-500 to-sky-400',
        'from-indigo-600 via-violet-500 to-pink-400',
        'from-rose-500 via-orange-400 to-amber-300',
        'from-sky-600 via-indigo-500 to-violet-400',
        'from-stone-800 via-violet-700 to-emerald-400',
    ];

    public static function for(?string $seed): string
    {
        return self::SET[crc32((string) $seed) % count(self::SET)];
    }

    /**
     * "Forex/Kleos/ILMU" gives "FK", "Multi-Tenant E-commerce" gives "MT".
     * A single word gives its first two letters ("Boilerplate" gives "BO").
     */
    public static function initials(?string $title): string
    {
        $words = preg_split('/[^\p{L}\p{N}]+/u', trim((string) $title), -1, PREG_SPLIT_NO_EMPTY);

        if (count($words) >= 2) {
            return mb_strtoupper(mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1));
        }

        return mb_strtoupper(mb_substr($words[0] ?? '', 0, 2));
    }
}
