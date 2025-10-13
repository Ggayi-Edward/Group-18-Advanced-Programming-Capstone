<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeFacilityRepository;
use App\Data\FakeServiceRepository;
use App\Data\FakeEquipmentRepository;
use App\Data\FakeProjectRepository;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = FakeFacilityRepository::all();

        // Apply search filters manually since using FakeRepository
        if ($request->filled('search')) {
            $facilities = array_filter($facilities, function ($f) use ($request) {
                return stripos($f->Name, $request->search) !== false;
            });
        }

        if ($request->filled('type')) {
            $facilities = array_filter($facilities, function ($f) use ($request) {
                return stripos($f->FacilityType, $request->type) !== false;
            });
        }

        if ($request->filled('partner')) {
            $facilities = array_filter($facilities, function ($f) use ($request) {
                return stripos($f->PartnerOrganization, $request->partner) !== false;
            });
        }

        if ($request->filled('capabilities')) {
            $capFilter = strtolower($request->capabilities);
            $facilities = array_filter($facilities, function ($f) use ($capFilter) {
                return !empty($f->Capabilities) &&
                       collect($f->Capabilities)->contains(fn($c) => stripos($c, $capFilter) !== false);
            });
        }

        return view('facilities.index', ['facilities' => $facilities]);
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        FakeFacilityRepository::create([
            'Name' => $request->input('name'),
            'Location' => $request->input('location'),
            'Description' => $request->input('description'),
            'PartnerOrganization' => $request->input('partnerOrganization'),
            'FacilityType' => $request->input('facilityType'),
            'Capabilities' => array_map('trim', explode(',', $request->input('capabilities'))),
        ]);

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility created successfully.');
    }

    public function show($id)
    {
        $facility = FakeFacilityRepository::find($id);

        if (!$facility) {
            abort(404, "Facility not found");
        }

        // Load related entities
        $services  = FakeServiceRepository::forFacility($id);
        $equipment = FakeEquipmentRepository::forFacility($id);
        $projects  = FakeProjectRepository::forFacility($id);

        return view('facilities.show', compact('facility', 'services', 'equipment', 'projects'));
    }

    public function edit($id)
    {
        $facility = FakeFacilityRepository::find($id);

        if (!$facility) {
            abort(404, "Facility not found");
        }

        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, $id)
    {
        FakeFacilityRepository::update($id, [
            'Name' => $request->input('name'),
            'Location' => $request->input('location'),
            'Description' => $request->input('description'),
            'PartnerOrganization' => $request->input('partnerOrganization'),
            'FacilityType' => $request->input('facilityType'),
            'Capabilities' => array_map('trim', explode(',', $request->input('capabilities'))),
        ]);

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility updated successfully.');
    }

    public function destroy($id)
    {
        FakeFacilityRepository::delete($id);

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility deleted successfully.');
    }
}
