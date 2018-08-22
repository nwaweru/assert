<?php
namespace App\Http\Controllers;

use App\Models\Asset;
use App\Traits\MyUuid;
use Illuminate\Http\Request;
use App\Models\AssetCategory;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{

    use MyUuid;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-assets')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        return view('assets.index');
    }

    /**
     * Get assets.
     *
     * @return Yajra\DataTables\DataTables
     */
    public function getAssets()
    {
        if (!Auth::user()->can('view-assets')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assets = Asset::orderBy('created_at', 'desc')
            ->with('assetCategory')
            ->get();

        return DataTables::of($assets)
                ->addIndexColumn()
                ->addColumn('assigned', function ($assets) {
                    if ($assets->assigned) {
                        $assigned = 'Busy';
                    } else {
                        $assigned = 'Free';
                    }

                    return $assigned;
                })
                ->addColumn('audit_log', function ($assets) {
                    if ($assets->created_at == $assets->updated_at) {
                        $auditLog = 'Created on ' . date('jS F Y @ g:i a', strtotime($assets->created_at));
                    } else {
                        $auditLog = 'Updated on ' . date('jS F Y @ g:i a', strtotime($assets->updated_at));
                    }

                    return $auditLog;
                })
                ->addColumn('action', function ($asset) {
                    $actions = '';

                    if (Auth::user()->can('edit-asset')) {
                        $actions .= '<a href="' . route('assets.edit', ['uuid' => $asset->uuid]) . '" class="card-link">Edit</a>';
                    }

                    if (Auth::user()->can('view-asset')) {
                        $actions .= '<a href="' . route('assets.show', ['uuid' => $asset->uuid]) . '" class="card-link">View</a>';
                    }

                    return $actions;
                })
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('create-asset')) {
            return redirect()->route('assets.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $categories = AssetCategory::orderBy('name', 'desc')->get();

        return view('assets.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create-asset')) {
            return redirect()->route('assets.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request->validate([
            'name' => 'required|unique:assets,name|max:255',
            'category' => 'required',
        ]);

        $asset = new Asset;
        $asset->uuid = $this->generateUuid();
        $asset->name = $request->name;
        $asset->asset_category_id = $request->category;
        $asset->user_id = Auth::id();
        $asset->save();

        return redirect()->route('assets.index')->with('alert', $this->getAlert('RECORD_CREATED'));
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        if (!Auth::user()->can('view-asset')) {
            return redirect()->route('assets.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $asset = Asset::where('uuid', $uuid)->firstOrFail();

        return view('assets.show', [
            'asset' => $asset,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        if (!Auth::user()->can('edit-asset')) {
            return redirect()->route('assets.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $asset = Asset::where('uuid', $uuid)->firstOrFail();
        $categories = AssetCategory::orderBy('name', 'desc')->get();

        return view('assets.edit', [
            'asset' => $asset,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        if (!Auth::user()->can('edit-asset')) {
            return redirect()->route('assets.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $asset = Asset::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => 'required|unique:assets,name,' . $asset->id . '|max:255',
            'category' => 'required',
        ]);

        $asset->name = $request->name;
        $asset->asset_category_id = $request->category;
        $asset->user_id = Auth::id();
        $asset->save();

        return redirect()->route('assets.show', ['uud' => $asset->uuid])->with('alert', $this->getAlert('RECORD_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        //
    }
}
