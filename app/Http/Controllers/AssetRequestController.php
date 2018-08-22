<?php
namespace App\Http\Controllers;

use App\Models\Asset;
use App\Traits\MyUuid;
use App\Models\Assignment;
use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AssetRequestController extends Controller
{

    use MyUuid;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-requests')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        return view('asset_requests.index');
    }

    /**
     * Get asset requests.
     *
     * @return Yajra\DataTables\DataTables
     */
    public function getRequests()
    {
        if (!Auth::user()->can('view-requests')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $requests = AssetRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->with('asset')
            ->get();

        return DataTables::of($requests)
                ->addIndexColumn()
                ->addColumn('status', function ($requests) {
                    if ($requests->accepted) {
                        $status = 'Accepted';
                    } else {
                        if ($requests->rejected) {
                            $status = 'Rejected';
                        } else {
                            $status = 'Pending';
                        }
                    }

                    return $status;
                })
                ->addColumn('audit_log', function ($requests) {
                    if ($requests->created_at == $requests->updated_at) {
                        $auditLog = 'Created on ' . date('jS F Y @ g:i a', strtotime($requests->created_at));
                    } else {
                        $auditLog = 'Updated on ' . date('jS F Y @ g:i a', strtotime($requests->updated_at));
                    }

                    return $auditLog;
                })
                ->addColumn('action', function ($request) {
                    $actions = '';

                    if (!$request->accepted && !$request->cancelled) {
                        if (Auth::user()->can('cancel-request')) {
                            $actions .= '<a href="' . route('requests.cancel', ['uuid' => $request->uuid]) . '" class="card-link">Cancel</a>';
                        }
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
        if (!Auth::user()->can('view-requests')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $requestedAssets = AssetRequest::where('user_id', Auth::id())
            ->where('accepted', '0')
            ->where('cancelled', '0')
            ->pluck('asset_id')
            ->toArray();

        $assets = Asset::where('assigned', '0')
            ->whereNotIn('id', $requestedAssets)
            ->get();

        return view('asset_requests.create', [
            'assets' => $assets
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
        $assets = $request->assets;

        if (is_null($assets)) {
            return redirect()->route('requests.create')->with('alert', $this->getAlert('NO_ASSETS_SELECTED'));
        } else {
            $requestedAssets = AssetRequest::where('user_id', Auth::id())
                ->where('accepted', '0')
                ->where('cancelled', '0')
                ->pluck('asset_id')
                ->toArray();

            $data = [];

            foreach ($assets as $id) {
                if (!in_array($id, $requestedAssets)) {
                    $data[] = [
                        'uuid' => $this->generateUuid(),
                        'user_id' => Auth::id(),
                        'asset_id' => $id,
                        'comment' => $request->comment,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }

            DB::table('asset_requests')->insert($data);

            return redirect()->route('requests.index')->with('alert', $this->getAlert('RECORD_CREATED'));
        }
    }

    /**
     * Show the form for canceling an asset request.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function cancel($uuid)
    {
        if (!Auth::user()->can('cancel-request')) {
            return redirect()->route('requests.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request = AssetRequest::where('uuid', $uuid)->where('user_id', Auth::id())->firstOrFail();

        return view('asset_requests.cancel', [
            'request' => $request
        ]);
    }

    /**
     * Cancel an asset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function cancelRequest(Request $request, $uuid)
    {
        if (!Auth::user()->can('cancel-request')) {
            return redirect()->route('requests.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $requested = AssetRequest::where('uuid', $uuid)->firstOrFail();
        $requested->accepted = false;
        $requested->rejection_reason = 'Request was Cancelled';
        $requested->cancelled = true;
        $requested->cancellation_reason = $request->cancellation_reason;
        $requested->save();

        return redirect()->route('requests.index')->with('alert', $this->getAlert('REQUEST_CANCELLED'));
    }

    /**
     * Show the form for accepting an asset request.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function accept($uuid)
    {
        if (!Auth::user()->can('accept-request')) {
            return redirect()->route('requests.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request = AssetRequest::where('uuid', $uuid)->firstOrFail();

        $currentAssignment = Assignment::where('asset_id', $request->asset_id)
            ->where('cleared', '0')
            ->first();

        return view('asset_requests.accept', [
            'request' => $request,
            'currentAssignment' => $currentAssignment,
        ]);
    }

    /**
     * Accept an asset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function acceptRequest(Request $request, $uuid)
    {
        if (!Auth::user()->can('accept-request')) {
            return redirect()->route('requests.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $requested = AssetRequest::where('uuid', $uuid)->firstOrFail();

        $currentAssignment = Assignment::where('asset_id', $request->asset_id)
            ->where('cleared', '0')
            ->first();

        if (!is_null($currentAssignment)) {
            return redirect()->route('requests.accept', ['uuid' => $requested->asset->uuid])->with('alert', $this->getAlert('ASSETS_IS_ASSIGNED'));
        }

        $requested->accepted = true;
        $requested->save();

        $assignment = new Assignment;
        $assignment->uuid = $this->generateUuid();
        $assignment->user_id = $requested->user_id;
        $assignment->asset_id = $requested->asset_id;
        $assignment->comment = $requested->comment;
        $assignment->save();

        $asset = Asset::find($requested->asset_id);
        $asset->assigned = true;
        $asset->save();

        return redirect()->route('assignments.index')->with('alert', $this->getAlert('REQUEST_ACCEPTED'));
    }

    /**
     * Show the form for accepting an asset request.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function reject($uuid)
    {
        if (!Auth::user()->can('accept-request')) {
            return redirect()->route('requests.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request = AssetRequest::where('uuid', $uuid)->firstOrFail();

        return view('asset_requests.reject', [
            'request' => $request
        ]);
    }

    /**
     * Accept an asset request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function rejectRequest(Request $request, $uuid)
    {
        if (!Auth::user()->can('accept-request')) {
            return redirect()->route('requests.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $requested = AssetRequest::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'rejection_reason' => 'required|max:255',
        ]);

        $requested->rejected = true;
        $requested->rejection_reason = $request->rejection_reason;
        $requested->save();

        return redirect()->route('assignments.index')->with('alert', $this->getAlert('REQUEST_REJECTED'));
    }
}
