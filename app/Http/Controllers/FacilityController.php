<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeFacilityRepository;
use App\Data\FakeServiceRepository;
use App\Data\FakeEquipmentRepository;
use App\Data\FakeProjectRepository;
use Exception;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $facilities = FakeFacilityRepository::all();

        // Apply search filters manually
        if ($request->filled('search')) {
            $facilities = array_filter($facilities, fn($f) => stripos($f->Name, $request->search) !== false);
        }

        if ($request->filled('type')) {
            $facilities = array_filter($facilities, fn($f) => stripos($f->FacilityType, $request->type) !== false);
        }

        if ($request->filled('partner')) {
            $facilities = array_filter($facilities, fn($f) => stripos($f->PartnerOrganization, $request->partner) !== false);
        }

        if ($request->filled('capabilities')) {
            $capFilter = strtolower($request->capabilities);
            $facilities = array_filter($facilities, fn($f) =>
                !empty($f->Capabilities) &&
                collect($f->Capabilities)->contains(fn($c) => stripos($c, $capFilter) !== false)
            );
        }

        return view('facilities.index', ['facilities' => $facilities]);
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        // ✅ Validation (required fields + data retention)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facilityType' => 'required|string|max:255',
            'partnerOrganization' => 'nullable|string|max:255',
            'capabilities' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // ✅ Uniqueness check (name + location)
        $existing = collect(FakeFacilityRepository::all())->first(function ($f) use ($data) {
            return strcasecmp($f->Name, $data['name']) === 0 &&
                   strcasecmp($f->Location, $data['location']) === 0;
        });

        if ($existing) {
            return back()
                ->withErrors(['name' => 'A facility with this name already exists at this location.'])
                ->withInput();
        }

        // ✅ Store new facility
        FakeFacilityRepository::create([
            'Name' => $data['name'],
            'Location' => $data['location'],
            'Description' => $data['description'] ?? '',
            'PartnerOrganization' => $data['partnerOrganization'] ?? '',
            'FacilityType' => $data['facilityType'],
            'Capabilities' => !empty($data['capabilities'])
                ? array_map('trim', explode(',', $data['capabilities']))
                : [],
        ]);

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility created successfully.');
    }

    public function show($id)
    {
        $facility = FakeFacilityRepository::find($id);
        abort_unless($facility, 404, "Facility not found");

        $services  = FakeServiceRepository::forFacility($id);
        // ✅ Safe fix for missing method
        $equipment = array_filter(FakeEquipmentRepository::all(), fn($e) => $e->FacilityId == $id);
        $projects  = FakeProjectRepository::forFacility($id);

        return view('facilities.show', compact('facility', 'services', 'equipment', 'projects'));
    }

    public function edit($id)
    {
        $facility = FakeFacilityRepository::find($id);
        abort_unless($facility, 404, "Facility not found");

        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'facilityType' => 'required|string|max:255',
            'partnerOrganization' => 'nullable|string|max:255',
            'capabilities' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        // ✅ Check uniqueness (excluding current)
        $duplicate = collect(FakeFacilityRepository::all())->first(function ($f) use ($data, $id) {
            return $f->FacilityId != $id &&
                   strcasecmp($f->Name, $data['name']) === 0 &&
                   strcasecmp($f->Location, $data['location']) === 0;
        });

        if ($duplicate) {
            return back()
                ->withErrors(['name' => 'A facility with this name already exists at this location.'])
                ->withInput();
        }

        FakeFacilityRepository::update($id, [
            'Name' => $data['name'],
            'Location' => $data['location'],
            'Description' => $data['description'] ?? '',
            'PartnerOrganization' => $data['partnerOrganization'] ?? '',
            'FacilityType' => $data['facilityType'],
            'Capabilities' => !empty($data['capabilities'])
                ? array_map('trim', explode(',', $data['capabilities']))
                : [],
        ]);

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility updated successfully.');
    }

    public function destroy($id)
    {
        $projects = FakeProjectRepository::forFacility($id);

        if (!empty($projects)) {
            return redirect()->route('facilities.index')
                             ->with('error', 'Cannot delete facility because it has dependant.');
        }

        FakeFacilityRepository::delete($id);

        return redirect()->route('facilities.index')
                         ->with('success', 'Facility deleted successfully.');
    }
}
