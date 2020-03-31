<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-clients'])) {
            $clients = Client::orderBy('name', 'ASC');

            if ($request->get('name')) {
                $clients->where('name', 'LIKE', '%' . $request->get('name') . '%');
            }

            if ($request->get('email')) {
                $clients->where('email', 'LIKE', '%' . $request->get('email') . '%')
                    ->orWhere('secondary_email', 'LIKE', '%' . $request->get('email') . '%');
            }

            if ($request->get('url')) {
                $clients->where('client_url', 'LIKE', '%' . $request->get('url') . '%');
            }

            $clients = $clients->paginate(20);

            return view('admin.pages.clients.index', compact('clients'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-clients'])) {

            return view('admin.pages.clients.create');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['create-clients'])) {

            $client = Client::create($request->all());
            Role::create([
                'name' => 'admin',
                'display_name' => 'Admin',
                'description' => 'Admin Role for ' . $client->name . " Client",
                'client_id' => $client->id,
            ]);

            return redirect()->route('clients.index')->with('success', 'Client Created Successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['read-clients'])) {
            return view('admin.pages.clients.show', compact('client'));
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-clients'])) {

            return view('admin.pages.clients.edit', compact('client'));
        } else {
            return view('error.unauthorized');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['update-clients'])) {
            $input = $request->all();
            if (!$request->has('status')) {
                $input['status'] = 0;
            }
            $client->update($input);

            Role::where('client_id', $client->id)->first()->update([
                'description' => 'Admin Role for ' . $client->name . " Client"
            ]);
            return redirect()->route('clients.index')->with('success', 'Client updated successfully');
        } else {
            return view('error.unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if (Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['delete-clients'])) {

            $client->delete();
            return redirect()->route('clients.index')->with('success', 'Client deleted successfully');
        } else {
            return view('error.unauthorized');
        }
    }
}
