<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemRequest;
use App\Models\System;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(System::class, 'system');
    }

    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $systems = System::query()
            ->when($search, function ($query, $searchValue) {
                $query->where(function ($subQuery) use ($searchValue) {
                    $subQuery
                        ->where('name', 'like', "%{$searchValue}%")
                        ->orWhere('owner', 'like', "%{$searchValue}%")
                        ->orWhere('current_version', 'like', "%{$searchValue}%")
                        ->orWhere('latest_version', 'like', "%{$searchValue}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('systems.index', compact('systems', 'search'));
    }

    public function create(): View
    {
        return view('systems.create');
    }

    public function store(SystemRequest $request): RedirectResponse
    {
        $payload = $request->validatedPayload();
        $payload['created_by'] = $request->user()->id;

        System::query()->create($payload);

        return redirect()
            ->route('systems.index')
            ->with('success', 'Sistema registrado exitosamente.');
    }

    public function show(System $system): View
    {
        return view('systems.show', compact('system'));
    }

    public function edit(System $system): View
    {
        return view('systems.edit', compact('system'));
    }

    public function update(SystemRequest $request, System $system): RedirectResponse
    {
        $system->update($request->validatedPayload());

        return redirect()
            ->route('systems.index')
            ->with('success', 'Sistema actualizado exitosamente.');
    }

    public function destroy(System $system): RedirectResponse
    {
        $system->delete();

        return redirect()
            ->route('systems.index')
            ->with('success', 'Sistema eliminado exitosamente.');
    }
}
