<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ClientsController extends Controller
{
    public function index()
    {
        return Inertia::render('Clients/Index', [
            'filters' => Request::all('search', 'trashed'),
            'clients' => Auth::user()->account->clients()
                ->orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate()
                ->withQueryString()
                ->through(function ($client) {
                    return [
                        'id' => $client->id,
                        'email' => $client->email,
                        'name' => $client->name,
                        'phone' => $client->phone,
                        'city' => $client->city,
                        'deleted_at' => $client->deleted_at,
                    ];
                }),
        ]);
    }

    public function create()
    {
        return Inertia::render('Clients/Create');
    }

    public function store()
    {
        Auth::user()->account->clients()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::route('clients')->with('success', 'Organization created.');
    }

    public function edit(Organization $client)
    {
        return Inertia::render('Clients/Edit', [
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'email' => $client->email,
                'phone' => $client->phone,
                'address' => $client->address,
                'city' => $client->city,
                'region' => $client->region,
                'country' => $client->country,
                'postal_code' => $client->postal_code,
                'deleted_at' => $client->deleted_at,
                'contacts' => $client->contacts()->orderByName()->get()->map->only('id', 'name', 'city', 'phone'),
            ],
        ]);
    }

    public function update(Organization $client)
    {
        $client->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return Redirect::back()->with('success', 'Organization updated.');
    }

    public function destroy(Organization $client)
    {
        $client->delete();

        return Redirect::back()->with('success', 'Organization deleted.');
    }

    public function restore(Organization $client)
    {
        $client->restore();

        return Redirect::back()->with('success', 'Organization restored.');
    }
}
