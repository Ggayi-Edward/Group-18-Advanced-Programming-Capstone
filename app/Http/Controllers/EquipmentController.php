<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeEquipmentRepository;
use App\Data\FakeFacilityRepository;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = FakeEquipmentRepository::all();

        // Attach facility names manually (since no real Eloquent relationship exists)
        foreach ($equipment as $eq) {
            $facility = FakeFacilityRepository::find($eq->FacilityId);
            $eq->FacilityName = $facility ? $facility->Name : 'N/A';
        }

        return view('equipment.index', compact('equipment'));
    }

    public function create()
    {
        $facilities = FakeFacilityRepository::all();
        return view('equipment.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name'          => 'required|string|max:255',
            'Description'   => 'nullable|string',
            'Capabilities'  => 'required|string|max:255',
            'FacilityId'    => 'required|integer',
            'InventoryCode' => 'nullable|string|max:255',
            'UsageDomain'   => 'nullable|string|max:255',
            'SupportPhase'  => 'nullable|string|max:255',
        ]);

        FakeEquipmentRepository::create($data);
        return redirect()->route('equipment.index')->with('status', 'Equipment created');
    }

    public function show($id)
    {
        $equipment = FakeEquipmentRepository::find($id);
        abort_unless($equipment, 404);

        // Attach facility name for display
        $facility = FakeFacilityRepository::find($equipment->FacilityId);
        $equipment->FacilityName = $facility ? $facility->Name : 'N/A';

        return view('equipment.show', compact('equipment'));
    }

    public function edit($id)
    {
        $equipment  = FakeEquipmentRepository::find($id);
        abort_unless($equipment, 404);

        $facilities = FakeFacilityRepository::all();

        // Attach facility name
        $facility = FakeFacilityRepository::find($equipment->FacilityId);
        $equipment->FacilityName = $facility ? $facility->Name : 'N/A';

        return view('equipment.edit', compact('equipment', 'facilities'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'Name'          => 'required|string|max:255',
            'Description'   => 'nullable|string',
            'Capabilities'  => 'required|string|max:255',
            'FacilityId'    => 'required|integer',
            'InventoryCode' => 'nullable|string|max:255',
            'UsageDomain'   => 'nullable|string|max:255',
            'SupportPhase'  => 'nullable|string|max:255',
        ]);

        FakeEquipmentRepository::update($id, $data);
        return redirect()->route('equipment.index')->with('status', 'Equipment updated');
    }

    public function destroy($id)
    {
        FakeEquipmentRepository::delete($id);
        return redirect()->route('equipment.index')->with('status', 'Equipment deleted');
    }
}
