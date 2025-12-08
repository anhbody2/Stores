<?php

if (! function_exists('star_rating')) {
    function star_rating($rating, $max = 5)
    {
        $fullStars = floor($rating);
        $halfStar  = ($rating - $fullStars) >= 0.5 ? 1 : 0;
        $emptyStars = $max - $fullStars - $halfStar;

        $html = '';

        // full stars
        for ($i = 0; $i < $fullStars; $i++) {
            $html .= '<i class="fa-solid fa-star text-warning"></i>';
        }

        // half star
        if ($halfStar) {
            $html .= '<i class="fa-solid fa-star-half text-warning"></i>';
        }

        // empty stars
        for ($i = 0; $i < $emptyStars; $i++) {
            $html .= '<i class="fa-regular fa-star text-warning"></i>';
        }

        return $html;
    }
}
