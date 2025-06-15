<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProdukHukum;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index()
    {
        $startYear = 2016;
        $currentYear = date('Y');

        // Get all categories
        $categories = Category::all();

        $statistics = [];

        foreach ($categories as $category) {
            $yearlyData = [];
            $yearlyData['category'] = $category->name;

            // Initialize all years with 0
            for ($year = $startYear; $year <= $currentYear; $year++) {
                $yearlyData[$year] = 0;
            }

            // Get count of produk hukum for each year
            $produkHukumCounts = ProdukHukum::where('category_id', $category->id)
                ->select(DB::raw('YEAR(tanggal_penetapan) as year'), DB::raw('count(*) as total'))
                ->whereYear('tanggal_penetapan', '>=', $startYear)
                ->whereYear('tanggal_penetapan', '<=', $currentYear)
                ->groupBy('year')
                ->get();

            // Update the counts in yearlyData
            foreach ($produkHukumCounts as $count) {
                $yearlyData[$count->year] = $count->total;
            }

            $statistics[] = $yearlyData;
        }

        return view('frontend.page.statistik', compact('statistics'));
    }
}
