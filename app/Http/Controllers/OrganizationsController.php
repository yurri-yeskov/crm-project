<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class OrganizationsController extends Controller
{
    public function index()
    {
        return Inertia::render('Organizations/Index', [
            'filters' => Request::all('search', 'trashed'),
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('id')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($organization) {
                    return [
                        'id' => $organization->id,
                        'date' => $organization->date,
                        'status' => $organization->status,
                        'contact' => $organization->contact,
                        'company' => $organization->company,
                        'town' => $organization->town,
                        'area' => $organization->area,
                        'tel' => $organization->tel,
                        'mobile' => $organization->mobile,
                        'email' => $organization->email,
                        'web' => $organization->web,
                        'brands' => $organization->brands,
                        'comments' => $organization->comments,
                        'deleted_at' => $organization->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Organizations/Create');
    }

    public function store()
    {
        if (Organization::where('tel', '=', Request::validate([
            'tel' => ['required','numeric', 'min:9']
            ]))->exists()) {
            return Redirect::route('organizations')->with('error', 'Organization Not created. - Duplicated TelNumber');
            return;
        }

        if (Organization::where('mobile', '=', Request::validate([
            'mobile' => ['required','numeric', 'min:9']
            ]))->exists()) {
            return Redirect::route('organizations')->with('error', 'Organization Not created. - Duplicated MobileNumber');
            return;
        }
        
        Auth::user()->account->organizations()->create(
            Request::validate([
                'date' => ['required', 'max:100', 'date'],
                'email' => ['nullable', 'max:50', 'email'],
                'status' => ['required', 'max:150'],
                'contact' => ['required', 'max:100'],
                'company' => ['required', 'max:100'],
                'town' => ['required', 'max:50'],
                'area' => ['required', 'max:50'],
                'tel' => ['required', 'numeric', 'min:9'],
                'mobile' => ['required', 'numeric', 'min:9'],
                'web' => ['nullable', 'max:150'],
                'brands' => ['nullable', 'max:50'],
                'comments' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::route('organizations')->with('success', 'Organization created.');
    }

    public function edit(Organization $organization)
    {
        return Inertia::render('Organizations/Edit', [
            'organization' => [
                'id' => $organization->id,
                'date' => $organization->date,
                'status' => $organization->status,
                'contact' => $organization->contact,
                'company' => $organization->company,
                'town' => $organization->town,
                'area' => $organization->area,
                'tel' => $organization->tel,
                'mobile' => $organization->mobile,
                'email' => $organization->email,
                'web' => $organization->web,
                'brands' => $organization->brands,
                'comments' => $organization->comments,
                'deleted_at' => $organization->deleted_at,
            ],
        ]);
    }

    public function update(Organization $organization)
    {
        $organization->update(
            Request::validate([
                'date' => ['required', 'max:100', 'date'],
                'email' => ['nullable', 'max:50', 'email'],
                'status' => ['required', 'max:150'],
                'contact' => ['required', 'max:100'],
                'company' => ['required', 'max:100'],
                'town' => ['required', 'max:50'],
                'area' => ['required', 'max:50'],
                'tel' => ['required', 'numeric', 'min:9'],
                'mobile' => ['required', 'numeric', 'min:9'],
                'web' => ['nullable', 'max:150'],
                'brands' => ['nullable', 'max:50'],
                'comments' => ['nullable', 'max:50'],
            ])
        );

        return Redirect::back()->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization)
    {
        $organization->delete($organization->id);

        return Redirect::back()->with('success', 'Organization deleted.');
    }

    public function restore(Organization $organization)
    {
        $organization->restore();

        return Redirect::back()->with('success', 'Organization restored.');
    }
}
