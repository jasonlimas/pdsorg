<?php

namespace App\Http\Livewire;

use App\Models\TermsConditions;
use Livewire\Component;

class QuoteTermsConditions extends Component
{
    public $termsConditions = [''];
    public $savedPresets = TermsConditions::class;
    public $selectedPreset = '';

    public function mount()
    {
        $this->savedPresets = TermsConditions::all();
    }

    public function render()
    {
        return view('livewire.quote-terms-conditions');
    }

    // Add terms and conditions line
    public function addTermsCondition()
    {
        $this->termsConditions[] = "";
    }

    // Apply preset
    public function applyPreset()
    {
        // Only apply preset if the selected preset is not empty
        if ($this->selectedPreset != '') {
            $this->termsConditions = [''];
            $this->termsConditions = TermsConditions::find($this->selectedPreset)->terms_conditions;
        }
    }

    // Function to remove a terms condition line
    public function removeTermsCondition($index)
    {
        // Check if there are more than one element in $termsConditions
        // If yes, let the user remove the element. Otherwise, do nothing.
        // This is to keep the array of $termsConditions at least one element.
        if (count($this->termsConditions) > 1) {
            unset($this->termsConditions[$index]);
            $this->termsConditions = array_values($this->termsConditions);
        }
    }
}
