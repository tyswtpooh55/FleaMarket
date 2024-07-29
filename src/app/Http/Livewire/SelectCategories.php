<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class SelectCategories extends Component
{
    public $categories;
    public $selectedCategory1;
    public $selectedCategory2;

    public function mount()
    {
        $this->categories = Category::all();
        $this->selectedCategory1 = null;
        $this->selectedCategory2 = null;
    }

    public function render()
    {
        return view('livewire.select-categories', [
            'filteredCategories' => $this->selectedCategory1 ? $this->categories->where('id', '!=', $this->selectedCategory1) : $this->categories,
        ]);
    }

    public function updatedSelectCategory1()
    {
        $this->selectedCategory2 = null;
    }
}
