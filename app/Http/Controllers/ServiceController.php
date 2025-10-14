<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Data\FakeServiceRepository;
use App\Data\FakeFacilityRepository;

class ServiceController extends Controller
{
    /**
     * Display a listing of services (optionally filtered by category).
     */
    public function index(Request $request)
    {
        $category = $request->input('category');
        $services = $category
            ? FakeServiceRepository::filterByCategory($category)
            : FakeServiceRepository::all();

        return view('services.index', compact('services', 'category'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $facilities = FakeFacilityRepository::all();
        return view('services.create', compact('facilities'));
    }

    /**
     * Store a newly created service in the repository.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'skillType'    => 'required|string|max:100',
            'facilityId'   => 'required|integer',
            'description'  => 'nullable|string',
            'deliveryMode' => 'nullable|string|max:100',
            'targetGroups' => 'nullable|string',
        ]);

        FakeServiceRepository::create([
            'Name'         => $validated['name'],
            'Category'     => $validated['category'],
            'SkillType'    => $validated['skillType'],
            'FacilityId'   => $validated['facilityId'],
            'Description'  => $validated['description'] ?? '',
            'DeliveryMode' => $validated['deliveryMode'] ?? '',
            'TargetGroups' => !empty($validated['targetGroups'])
                                ? array_map('trim', explode(',', $validated['targetGroups']))
                                : [],
        ]);

        return redirect()->route('services.index')
                         ->with('success', 'Service created successfully.');
    }

    /**
     * Display a single service.
     */
    public function show(int $id)
    {
        $service = FakeServiceRepository::find($id);

        if (!$service) {
            abort(404, 'Service not found.');
        }

        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing an existing service.
     */
    public function edit(int $id)
    {
        $service = FakeServiceRepository::find($id);

        if (!$service) {
            abort(404, 'Service not found.');
        }

        $facilities = FakeFacilityRepository::all();
        return view('services.edit', compact('service', 'facilities'));
    }

    /**
     * Update an existing service in the repository.
     */
    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'skillType'    => 'required|string|max:100',
            'facilityId'   => 'required|integer',
            'description'  => 'nullable|string',
            'deliveryMode' => 'nullable|string|max:100',
            'targetGroups' => 'nullable|string',
        ]);

        FakeServiceRepository::update($id, [
            'Name'         => $validated['name'],
            'Category'     => $validated['category'],
            'SkillType'    => $validated['skillType'],
            'FacilityId'   => $validated['facilityId'],
            'Description'  => $validated['description'] ?? '',
            'DeliveryMode' => $validated['deliveryMode'] ?? '',
            'TargetGroups' => !empty($validated['targetGroups'])
                                ? array_map('trim', explode(',', $validated['targetGroups']))
                                : [],
        ]);

        return redirect()->route('services.index')
                         ->with('success', 'Service updated successfully.');
    }

    /**
     * Remove a service from the repository.
     */
    public function destroy(int $id)
    {
        FakeServiceRepository::delete($id);

        return redirect()->route('services.index')
                         ->with('success', 'Service deleted successfully.');
    }
}
