<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\Alert;   // ¡Importa el modelo Alert!
use App\Models\Product; // ¡Importa el modelo Product para la relación!

class Alerts extends Component
{
    public Collection $alerts;
    public int $alertCount;

    public function mount()
    {
        $this->loadAlerts();
    }

    public function loadAlerts()
    {
       
        $this->alerts = Alert::where('is_triggered', true)
                             ->where('is_read', false)
                             ->with('product')
                             ->latest()
                             ->get();

        $this->alertCount = $this->alerts->count(); 
    }

    
    public function markAsRead(int $alertId)
    {
        $alert = Alert::find($alertId); 
        if ($alert) {
            $alert->update(['is_read' => true]); 
            $this->loadAlerts(); 
        }
    }

    
    public function render()
    {
        return view('livewire.alerts');
    }
}