<?php 

namespace Mohkoma\ChangeLog;

use Mohkoma\ChangeLog\ChangeLog;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    /**
     *  Return the releases as Json data
     * 
     * @return json
     */
    public function index()
    {
        return ChangeLog::all();
    }

    /**
     * Get as view file
     * 
     * @return view
     */
    public function show()
    {
        return ChangeLog::view();
    }

    /**
     * Get as view file
     * 
     * @return view
     */
    public function create()
    {
        // No version added yet
        if(empty(config('changelog.versions'))) {
            return 'Please add versions to your config file';
        }

        // Get current version
        $version = Changelog::currentVersion();

        // Return the form
        return view('changelog::form', ['version' => $version]);
    }

    /**
     * Store new release
     * 
     * @return view
     */
    public function store(Request $request)
    {
        // Vaidate first
        $request->validate([
            'content' => 'string|required'
        ]);

        // Store the data
        if(ChangeLog::storeLog($request->content)) {
            return redirect()->route('changelog.view');
        }

        // Return error
        return 'Something went wrong!';
    }
}