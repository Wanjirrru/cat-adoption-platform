<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Adoption;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function dashboard()
{
    // Define the variables
    $totalCats = Cat::count(); // Total number of cats
    $adoptedCats = Adoption::where('status', 'accepted')->count(); // Cats that have been adopted
    $happyAdopters = User::has('adoptions')->count(); // Users who have adopted cats
    $featuredCats = Cat::where('is_featured', true)->take(3)->get(); // Fetch featured cats (assuming you have an 'is_featured' column)

    // Pass the variables to the view
    return view('welcome', compact('totalCats', 'adoptedCats', 'happyAdopters', 'featuredCats'));
}

}