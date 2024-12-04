<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    // Declare properties
    public $category_id = null;
    public $paginate_count = 15;
    public $per_page = 15;
    public $search = '';
    public $sort = 'asc'; // default sorting
    public $minPrice = null;
    public $maxPrice = null;
    public $exclude_product_ids = [];
    public $default_home_sorting_method;
    public $from_page;

    // Pagination theme - adjust as per your CSS framework
    protected $paginationTheme = 'bootstrap'; // or 'tailwind'

    // Listen for event to update category
    protected $listeners = ['category-selected' => 'setCategory', 'filterProducts' => 'applyFilters'];

    /**
     * Mount method is called when the component is first rendered.
     * @param int|null $category_id
     * @param int $per_page
     */
    public function mount($category_id = null, $per_page = 15, $exclude_product_ids = [], $from_page = null)
    {
        $this->category_id = $category_id ?? null;
        $this->per_page = $per_page;
        $this->paginate_count = $per_page;
        $this->exclude_product_ids = $exclude_product_ids;
        $this->default_home_sorting_method = (!empty(__homeSetting('default_home_sorting_method'))) ? __homeSetting('default_home_sorting_method') : 'default';
        $this->from_page = $from_page; 
    }

    public function applyFilters($filters)
    {
        // Update the component's properties with the filters
        $this->search = $filters['search'];
        $this->sort = $filters['sort'] ?? 'asc';
        $this->minPrice = $filters['minPrice'] ?? '';
        $this->maxPrice = $filters['maxPrice'] ?? '';

        // Reset pagination when applying filters
        $this->resetPage();
    }

    /**
     * Set the category and reset pagination.
     * This method is triggered by the event listener.
     *
     * @param int $category_id
     */
    public function setCategory($category_id = null)
    {
        $this->category_id = $category_id;
        $this->resetPage();
    }

    /**
     * Load more products by increasing pagination count.
     */
    public function loadMore()
    {
        $this->paginate_count += $this->per_page;
    }

    /**
     * Reset pagination when category ID is updated.
     */
    public function updatedCategoryId()
    {
        $this->resetPage();
    }

    public function placeholder()
    {
        return view('livewire.skeleton-loader', [
            'skeletons' => range(1, 10),
            'apply_top_margin' => true
        ]);
    }

    /**
     * Render the component.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // Start building the query for products
        $query = Product::with(['category', 'variations'])
            ->where('public_visibility', 1);

        // Filter by category if a category_id is set
        $query->when($this->category_id, function ($q) {
            $q->whereIn('category_id', [$this->category_id]);
        });

        // Search filter
        $query->when($this->search, function ($q) {
            $q->where('name', 'like', '%' . $this->search . '%');
        });

        // Price range filter
        $query->when($this->minPrice, fn($q) => $q->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($q) => $q->where('price', '<=', $this->maxPrice));
        
        switch ($this->default_home_sorting_method) {
            case 'random':
                $query->inRandomOrder();
                break;
            case 'custom':
                $query->where('is_home', 1);
                break;
            default:
                $query->orderBy('name', $this->sort);
                break;
        }

        // Exclude specific product_ids
        if (!empty($this->exclude_product_ids)) {
            $query->whereNotIn('id', $this->exclude_product_ids);
        }

        // Paginate results
        $products = $query->paginate($this->paginate_count);

        // Return the view with the paginated products
        return view('livewire.products', [
            'products' => $products
        ]);
    }
}
