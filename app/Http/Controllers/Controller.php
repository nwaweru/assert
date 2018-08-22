<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $webServiceBaseUrl;

    public function __construct()
    {
        $this->webServiceBaseUrl = env('WEB_SERVICE_BASE_URL');
    }

    public function getAlert($type)
    {
        switch ($type) {
            case 'PERMISSION_DENIED':
                $alert['type'] = 'danger';
                $alert['message'] = 'Permission Denied';
                break;

            case 'RECORD_CREATED':
                $alert['type'] = 'success';
                $alert['message'] = 'Record Created';
                break;
            case 'RECORD_UPDATED':
                $alert['type'] = 'success';
                $alert['message'] = 'Record Updated';
                break;
            case 'RECORD_DELETED':
                $alert['type'] = 'success';
                $alert['message'] = 'Record Deleted';
                break;

            case 'RECORD_EXISTS':
                $alert['type'] = 'danger';
                $alert['message'] = 'Record Exists';
                break;
            case 'RECORD_NOT_FOUND':
                $alert['type'] = 'warning';
                $alert['message'] = 'Record Not Found';
                break;

            case 'ASSINGMENT_CLEARED':
                $alert['type'] = 'success';
                $alert['message'] = 'Assignment Cleared';
                break;
            case 'ASSIGNMENT_ALREADY_CLEARED':
                $alert['type'] = 'danger';
                $alert['message'] = 'Assignment Already Cleared';
                break;

            case 'ASSETS_IS_ASSIGNED':
                $alert['type'] = 'danger';
                $alert['message'] = 'Current Asset is Busy';
                break;
            case 'NO_ASSETS_SELECTED':
                $alert['type'] = 'danger';
                $alert['message'] = 'Invalid Selection';
                break;
            case 'REQUEST_CANCELLED':
                $alert['type'] = 'success';
                $alert['message'] = 'Request Cancelled';
                break;
            case 'REQUEST_ACCEPTED':
                $alert['type'] = 'success';
                $alert['message'] = 'Request Accepted';
                break;
            case 'REQUEST_REJECTED':
                $alert['type'] = 'success';
                $alert['message'] = 'Request Rejected';
                break;

            default:
                $alert['type'] = 'danger';
                $alert['message'] = 'Unknown Alert';
                break;
        }

        return $alert;
    }
}
