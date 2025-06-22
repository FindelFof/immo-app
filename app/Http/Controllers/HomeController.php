<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {

        $houses = Property::with(['images' => function($query) {
            $query->orderBy('display_order', 'asc');
        }])
            ->where('is_available', true)
            ->latest()
            ->take(10)
            ->get();

        // Récupérer les propriétés en vedette
        $featuredProperties = Property::with(['images' => function($query) {
            $query->where('is_featured', true)->orWhere('display_order', 1);
        }])
            ->where('is_featured', true)
            ->where('is_available', true)
            ->latest()
            ->take(6)
            ->get();

        // Récupérer les dernières propriétés ajoutées
        $latestProperties = Property::with(['images' => function($query) {
            $query->where('is_featured', true)->orWhere('display_order', 1);
        }])
            ->where('is_available', true)
            ->latest()
            ->take(3)
            ->get();

        // Récupérer les villes distinctes avec le nombre de propriétés
        $cities = Property::select('city', DB::raw('count(*) as property_count'))
            ->where('is_available', true)
            ->groupBy('city')
            ->orderByDesc('property_count')
            ->take(6)
            ->get();

        // Récupérer les statistiques
        $stats = [
            'total_properties' => Property::count(),
            'properties_for_sale' => Property::where('type', 'sale')->where('is_available', true)->count(),
            'properties_for_rent' => Property::where('type', 'rent')->where('is_available', true)->count(),
            'cities_count' => Property::distinct('city')->count('city')
        ];

        // Pour le moment, nous utilisons des données statiques pour les témoignages et les blogs
        $testimonials = $this->getStaticTestimonials();
        $blogPosts = $this->getStaticBlogPosts();

        return view('site.pages.home', compact(
            'houses',
            'featuredProperties',
            'latestProperties',
            'cities',
            'stats',
            'testimonials',
            'blogPosts'
        ));
    }

    /**
     * Recherche de propriétés
     */
    public function search(Request $request)
    {
        // Validation des données de recherche
        $request->validate([
            'type' => 'nullable|in:sale,rent',
            'city' => 'nullable|string',
            'property_type' => 'nullable|in:house,apartment,land,commercial',
            'min_price' => 'nullable|numeric',
            'max_price' => 'nullable|numeric',
            'rooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'min_surface' => 'nullable|numeric',
            'max_surface' => 'nullable|numeric',
            'keyword' => 'nullable|string|max:255',
        ]);

        // Construction de la requête de recherche
        $query = Property::with(['images' => function($query) {
            $query->where('is_featured', true)->orWhere('display_order', 1);
        }])
            ->where('is_available', true);

        // Filtres conditionnels
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('rooms')) {
            $query->where('rooms', '>=', $request->rooms);
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->filled('min_surface')) {
            $query->where('surface', '>=', $request->min_surface);
        }

        if ($request->filled('max_surface')) {
            $query->where('surface', '<=', $request->max_surface);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%")
                    ->orWhere('neighborhood', 'like', "%{$keyword}%");
            });
        }

        // Exécution de la requête
        $properties = $query->latest()->paginate(9);

        // Récupérer les villes distinctes pour le filtre
        $cities = Property::select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        return view('properties.search', compact('properties', 'cities'));
    }

    /**
     * Fournit des témoignages statiques pour la démo
     */
    private function getStaticTestimonials(): array
    {
        return [
            [
                'name' => 'James Emily',
                'position' => 'First Time Buyer',
                'image' => 'assets/img/all-images/testimonial-img2.png',
                'quote' => 'From the moment we met our agent, we knew we were in good hands. Homz Real Estate Agency made buying our first home a wonderful experience. They were always available to answer our questions and guide us through the process with patience and professionalism.',
                'title' => 'Professional & Personable'
            ],
            [
                'name' => 'Sarah Johnson',
                'position' => 'Property Investor',
                'image' => 'assets/img/all-images/testimonial-img3.png',
                'quote' => 'As an experienced property investor, I have worked with many real estate agencies, but Homz stands out. Their market knowledge and networking capabilities have helped me secure multiple profitable investments. I highly recommend their services.',
                'title' => 'Exceptional Market Knowledge'
            ],
            [
                'name' => 'Michael Rodriguez',
                'position' => 'Home Seller',
                'image' => 'assets/img/all-images/testimonial-img4.png',
                'quote' => 'Selling our family home of 20 years was an emotional process, but the team at Homz handled everything with such care and professionalism. They secured us a price that exceeded our expectations and made the transition smooth.',
                'title' => 'Above and Beyond Service'
            ]
        ];
    }

    /**
     * Fournit des articles de blog statiques pour la démo
     */
    private function getStaticBlogPosts(): array
    {
        return [
            [
                'title' => 'Stay Informed: The Latest Trends And Insights In The Real Estate Market',
                'date' => '12 May 2024',
                'image' => 'assets/img/all-images/blog-img1.png',
                'category' => 'Property',
                'author' => 'Anderson',
                'slug' => 'latest-trends-real-estate-market'
            ],
            [
                'title' => 'Home Buying, Selling, and Beyond Comprehensive Real Estate Articles and Updates',
                'date' => '10 May 2024',
                'image' => 'assets/img/all-images/blog-img2.png',
                'category' => 'Property',
                'author' => 'John Doe',
                'slug' => 'home-buying-selling-beyond'
            ]
        ];
    }
}
