<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Review;

class AdminController extends Controller
{

    public function index()
    {
        // Users
        $users = User::all();
        $totalUsers = User::count();

        // Courses
        $courses = Course::all();
;
        $totalCourses = Course::count();

        // Categories + count of courses per category
        $categories = Category::withCount('courses')->get();
        $totalCategories = Category::count();


        //Reviews
        $reviews = Review::all();
        $totalReviews = Review::count();

        $categorizedReviews = $this->categorizeReviews();
        $getLastFourReviews = $this->getLastFourReviews();
        $sortedCourses = $this->sortCoursesByPublishStatus();
        return view('admin_page.admin', [
            'users' => $users,
            'totalUsers' => $totalUsers,
            'courses' => $courses,
            'totalCourses' => $totalCourses,
            'categories' => $categories,
            'totalCategories' => $totalCategories,
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'categorizedReviews' => $categorizedReviews,
            'lastFourReviews' => $getLastFourReviews,
            'sortedCourses' => $sortedCourses,

        ]);
    }
    public function categorizeReviews()
    {
        // Step 1: Get all reviews
        $reviews = Review::all();
        $averageRate = round($reviews->avg('rate'), 2);
        // Step 2: Prepare arrays for storage
        $fiveStars  = [];
        $fourStars  = [];
        $threeStars = [];
        $twoStars   = [];
        $oneStars   = [];

        // Step 3: Loop and classify by rate
        foreach ($reviews as $review) {
            switch ($review->rate) {
                case 5:
                    $fiveStars[] = $review;
                    break;

                case 4:
                    $fourStars[] = $review;
                    break;

                case 3:
                    $threeStars[] = $review;
                    break;

                case 2:
                    $twoStars[] = $review;
                    break;

                case 1:
                    $oneStars[] = $review;
                    break;
            }
        }

        // Step 4: Add counts
        return [
            'average_rate' => $averageRate,
            'five_star' => [
                'count' => count($fiveStars),
                'list'  => $fiveStars
            ],
            'four_star' => [
                'count' => count($fourStars),
                'list'  => $fourStars
            ],
            'three_star' => [
                'count' => count($threeStars),
                'list'  => $threeStars
            ],
            'two_star' => [
                'count' => count($twoStars),
                'list'  => $twoStars
            ],
            'one_star' => [
                'count' => count($oneStars),
                'list'  => $oneStars
            ],
        ];
    }
    public function getLastFourReviews()
    {
        $reviews = Review::with('user')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return $reviews;
    }
    public function sortCoursesByPublishStatus()
    {
        $publishedCourses = Course::where('publish_status', true)
            ->get();

        $unpublishedCourses = Course::where('publish_status', false)
            ->get();

        return [
            'published'   => $publishedCourses,
            'unpublished' => $unpublishedCourses,
        ];
    }
    function getCategoryNameByLevel($level): string
    {
        return Category::where('category_id', $level)
            ->value('category_name') ?? 'Unknown';
    }
}
