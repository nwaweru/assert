<?php
namespace App\Http\Controllers;

use App\Traits\MyUuid;
use Illuminate\Http\Request;
use App\Models\AssetCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssetCategoryResource;

class AssetCategoryController extends Controller
{

    use MyUuid;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-asset-categories')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $categories = AssetCategory::orderBy('created_at', 'desc')->get();

        return AssetCategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('create-asset-category')) {
            return redirect()->route('asset_categories.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request->validate([
            'name' => 'required|unique:asset_categories,name|max:255',
        ]);

        $category = new AssetCategory;
        $category->uuid = $this->generateUuid();
        $category->name = $request->name;
        $category->user_id = Auth::id();
        $category->save();

        $savedCategory = AssetCategory::find($category->id);

        return new AssetCategoryResource($savedCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        if (!Auth::user()->can('view-asset-category')) {
            return redirect()->route('asset_categories.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $category = AssetCategory::where('uuid', $uuid)->firstOrFail();

        return new AssetCategoryResource($category);
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
        if (!Auth::user()->can('edit-asset-category')) {
            return redirect()->route('asset_categories.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $category = AssetCategory::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => 'required|unique:asset_categories,name,' . $category->id . '|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return new AssetCategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        if (!Auth::user()->can('delete-asset-category')) {
            return redirect()->route('asset_categories.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $category = AssetCategory::where('uuid', $uuid)->firstOrFail();
        $category->destroy();
    }
}
