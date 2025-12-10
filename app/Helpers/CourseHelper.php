<?php

use App\Models\Course;

if (! function_exists('getCoursesByCategory')) {
    function getCoursesByCategory($categoryId, $limit = 2)
    {
        return Course::where('level', $categoryId)
            ->take($limit)
            ->get();
    }
}
