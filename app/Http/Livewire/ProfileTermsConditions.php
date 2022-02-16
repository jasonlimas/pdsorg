<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ProfileTermsConditions extends Component
{
    public $termsConditions = [''];
    public $term; // This variable is used to store the terms passed from edit view

    public function mount()
    {
        // If $term is not null, assign all values from null to $termsConditions
        // This should only run when the user is pressing the edit button from /profiles page
        if (!is_null($this->term)) {
            $this->termsConditions = $this->term->terms_conditions;
        }
    }

    public function render()
    {
        return view('livewire.profile-terms-conditions');
    }

    // Add terms and conditions line
    public function addTermsCondition()
    {
        $this->termsConditions[] = "";
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
