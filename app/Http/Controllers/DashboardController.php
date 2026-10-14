<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\LabOrder;
use App\Models\LabTest;
use App\Models\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'patientCount' => Patient::count(),
            'doctorCount' => Doctor::count(),
            'labTestCount' => LabTest::count(),
            'orderCount' => LabOrder::count(),
            'pendingOrderCount' => LabOrder::where('status', 'pending')->count(),
            'recentOrders' => LabOrder::with(['patient', 'doctor'])
                ->latest('order_date')
                ->take(5)
                ->get(),
        ]);
    }
}
