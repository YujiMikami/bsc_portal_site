<?php
use Carbon\Carbon;

if (!function_exists('toIntOrNull')) {
    function toIntOrNull($value)
    {
        return empty($value) ? null : $value;
    }
}

function normalizeDateOrNull(?string $value): ?string
{
    if (empty($value)) {
        return null;
    }

    // 年月日の場合
    try {
        return Carbon::createFromFormat('Y/n/j', $value)->format('Y-m-d');
    } catch (\Exception $e) {
        // 無視して次へ
    }

    // 年月の場合（1日を仮置き）
    try {
        return Carbon::createFromFormat('Y/n', $value)->startOfMonth()->format('Y-m-d');
    } catch (\Exception $e) {
        // 無視して次へ
    }

    // それ以外は null
    return null;
}