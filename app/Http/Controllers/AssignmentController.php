<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Asset;
use App\Traits\MyUuid;
use App\Models\Assignment;
use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{

    use MyUuid;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->can('view-assignments')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        return view('assignments.index');
    }

    /**
     * Get assignments.
     *
     * @return Yajra\DataTables\DataTables
     */
    public function getAssignments()
    {
        if (!Auth::user()->can('view-assignments')) {
            return redirect()->route('dashboard')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assignments = Assignment::orderBy('created_at', 'desc')
            ->with('user')
            ->with('asset')
            ->get();

        return DataTables::of($assignments)
                ->addIndexColumn()
                ->addColumn('comment', function ($assignments) {
                    if ($assignments->comment) {
                        $comment = $assignments->comment;
                    } else {
                        $comment = 'None';
                    }

                    return $comment;
                })
                ->addColumn('cleared', function ($assignments) {
                    if ($assignments->cleared) {
                        $cleared = 'Yes';
                    } else {
                        $cleared = 'No';
                    }

                    return $cleared;
                })
                ->addColumn('clearance_comment', function ($assignments) {
                    if ($assignments->clearance_comment) {
                        $cleared = $assignments->clearance_comment;
                    } else {
                        $cleared = 'None';
                    }

                    return $cleared;
                })
                ->addColumn('audit_log', function ($assignments) {
                    if ($assignments->created_at == $assignments->updated_at) {
                        $auditLog = 'Created on ' . date('jS F Y @ g:i a', strtotime($assignments->created_at));
                    } else {
                        $auditLog = 'Updated on ' . date('jS F Y @ g:i a', strtotime($assignments->updated_at));
                    }

                    return $auditLog;
                })
                ->addColumn('action', function ($assignment) {
                    $actions = '';

                    if (!$assignment->cleared) {
                        if (Auth::user()->can('edit-assignment')) {
                            $actions .= '<a href="' . route('assignments.edit', ['uuid' => $assignment->uuid]) . '" class="card-link">Edit</a>';
                        }
                    }

                    if (Auth::user()->can('view-assignment')) {
                        $actions .= '<a href="' . route('assignments.show', ['uuid' => $assignment->uuid]) . '" class="card-link">View</a>';
                    }

                    if (!$assignment->cleared) {
                        if (Auth::user()->can('clear-assignment')) {
                            $actions .= '<a href="' . route('assignments.clear', ['uuid' => $assignment->uuid]) . '" class="card-link">Clear</a>';
                        }
                    }

                    return $actions;
                })
                ->make(true);
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

        $requests = AssetRequest::orderBy('created_at', 'desc')
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
                            if (!is_null($requests->rejection_reason)) {
                                $status .= ': ' . $requests->rejection_reason;
                            }
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

                    if (!$request->accepted && !$request->rejected) {
                        if (Auth::user()->can('reject-request')) {
                            $actions .= '<a href="' . route('requests.reject', ['uuid' => $request->uuid]) . '" class="card-link">Reject</a>';
                        }

                        if (Auth::user()->can('accept-request')) {
                            $actions .= '<a href="' . route('requests.accept', ['uuid' => $request->uuid]) . '" class="card-link">Accept</a>';
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
        if (!Auth::user()->can('create-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $users = User::where('verified', '1')->orderBy('first_name', 'asc')->where('active', '1')->get();
        $assets = Asset::where('assigned', '0')->orderBy('name', 'asc')->get();

        return view('assignments.create', [
            'users' => $users,
            'assets' => $assets,
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
        if (!Auth::user()->can('create-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $request->validate([
            'user' => 'required',
            'asset' => 'required',
            'comment' => 'present|max:255',
        ]);

        $assignment = new Assignment;
        $assignment->uuid = $this->generateUuid();
        $assignment->user_id = $request->user;
        $assignment->asset_id = $request->asset;
        $assignment->comment = $request->comment;
        $assignment->save();

        $asset = Asset::find($request->asset);
        $asset->assigned = true;
        $asset->save();

        return redirect()->route('assignments.index')->with('alert', $this->getAlert('RECORD_CREATED'));
    }

    /**
     * Display the specified resource.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        if (!Auth::user()->can('view-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assignment = Assignment::where('uuid', $uuid)->firstOrFail();

        return view('assignments.show', [
            'assignment' => $assignment
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
        if (!Auth::user()->can('edit-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assignment = Assignment::where('uuid', $uuid)->firstOrFail();

        if ($assignment->cleared) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('ASSIGNMENT_ALREADY_CLEARED'));
        }

        $users = User::where('verified', '1')->orderBy('first_name', 'asc')->where('active', '1')->get();
        $assets = Asset::orderBy('name', 'desc')->get();

        return view('assignments.edit', [
            'assignment' => $assignment,
            'users' => $users,
            'assets' => $assets,
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
        if (!Auth::user()->can('edit-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assignment = Assignment::where('uuid', $uuid)->firstOrFail();

        if ($assignment->cleared) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('ASSIGNMENT_ALREADY_CLEARED'));
        }

        $request->validate([
            'asset' => 'required',
            'comment' => 'present|max:255',
        ]);

        $assetID = (int) $request->asset;

        if ($assetID !== $assignment->asset->id) {
            $oldAsset = Asset::find($assignment->asset_id);
            $oldAsset->assigned = false;
            $oldAsset->save();

            $oldAssignment = Assignment::find($assignment->id);
            $oldAssignment->clearance_comment = 'Cleared by System.';
            $oldAssignment->cleared = true;
            $oldAssignment->save();

            $newAssignment = new Assignment;
            $newAssignment->uuid = $this->generateUuid();
            $newAssignment->user_id = $assignment->user_id;
            $newAssignment->asset_id = $assetID;
            $newAssignment->comment = $request->comment;
            $newAssignment->save();

            $newAsset = Asset::find($assetID);
            $newAsset->assigned = true;
            $newAsset->user_id = Auth::id();
            $newAsset->save();
        } else {
            $assignment->comment = $request->comment;
            $assignment->save();
        }

        return redirect()->route('assignments.index')->with('alert', $this->getAlert('RECORD_UPDATED'));
    }

    /**
     * Show the form for clearing asset assignment.
     *
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function clear($uuid)
    {
        if (!Auth::user()->can('clear-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assignment = Assignment::where('uuid', $uuid)->firstOrFail();

        return view('assignments.clear', [
            'assignment' => $assignment,
        ]);
    }

    /**
     * Update the assignment details to reflect clearance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  uuid  $uuid
     * @return \Illuminate\Http\Response
     */
    public function clearAssignment(Request $request, $uuid)
    {
        if (!Auth::user()->can('clear-assignment')) {
            return redirect()->route('assignments.index')->with('alert', $this->getAlert('PERMISSION_DENIED'));
        }

        $assignment = Assignment::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'clearance_comment' => 'present|max:255',
        ]);

        $asset = Asset::find($assignment->asset_id);
        $asset->assigned = false;
        $asset->user_id = Auth::id();
        $asset->save();

        $assignment->clearance_comment = $request->clearance_comment;
        $assignment->cleared = true;
        $assignment->save();

        return redirect()->route('assignments.show', ['uuid' => $assignment->uuid])->with('alert', $this->getAlert('ASSINGMENT_CLEARED'));
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
