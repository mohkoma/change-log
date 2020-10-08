<?php

namespace Mohkoma\ChangeLog;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;


class ChangeLog
{

    /**
     *  First let's define the storage
     */
    public static function disk()
    {
        return Storage::disk(config('changelog.storage_disk', 'public'));
    }

    /**
     *  First let's define the storage
     */
    public static function directory()
    {
        return config('changelog.directory_name', 'changelog');
    }

    /**
     *  Store the logs
     */
    public static function storeLog($data)
    {
        // Build the object
        $data = collect([
            'timestamp' => self::getCurrentDate()->getTimestamp(),
            'content'   => $data
        ]);

        // Store as json
        if(!self::toJsonFile($data)) {

            // Oops! failed to store json file
            throw new Exception('Failed initializing store file.'); 
        };

        // Return true
        return true;
    }

    /**
     *  Store the logs
     */
    public static function toJsonFile(Collection $data)
    {
        // Build the file name
        $path = self::directory() . '/' . Carbon::parse($data['timestamp'])->format('Y_m_d_Hms') . '_log.json';
        
        // Store file
        return self::disk()->put($path, json_encode($data));
    }

    /**
     *  Get all logs
     * 
     * @return Array
     */
    public static function all()
    {
        // Get all the files
        $files = self::disk()->allFiles(self::directory());
        
        // Build the empty array
        $content = collect();

        // Go through the files
        foreach ($files as $key => $file) {

            // Push it to the array
            $content[] = self::decodeJsonFile($file);
        }

        // Get the content
        return self::versions($content->sortByDesc('timestamp'));
    }

    /**
     *  Filter them by versions
     * 
     * @return Array
     */
    public static function versions(Collection $content)
    {
        // First let's get our versions
        $dates = collect(config('changelog.versions'));

        // Get keys only
        $versions = $dates->keys();

        // Build empty collection
        $releases = collect();

        // Let's loop through
        foreach ($versions as $key => $version) {

            // current date
            $current = $dates[$version];

            // Get the next item key
            $next = !isset($versions[$key + 1]) ? false : $dates[$versions[$key + 1]];

            // Build the logs
            $changes = !$next 
                ? $content->where('timestamp', '>',  self::timestamp($current)) 
                : $content->whereBetween('timestamp', [self::timestamp($current), self::timestamp($next)]);
            
            // build the object
            $releases[] = (object)[
                'version'     => $version,
                'date'        => $dates[$version],
                'changes'     => $changes
            ];
        }
        
        // Let's return
        return $releases->reverse();
    }

    /**
     *  Show releases as html.
     * 
     * @return View
     */
    public static function view()
    {
        // Get the releases
        $releases = self::all();

        // Return the view
        return view('changelog::changelog', ['releases' => $releases]);
    }

    /**
     *  Get the current date.
     * 
     * @return Carbon\Carbon
     */
    public static function getCurrentDate()
    {
        return Carbon::now();
    }

    /**
     *  Parse the date.
     */
    public static function timestamp($date)
    {
        return Carbon::parse($date)->getTimestamp();
    }

    /**
     *  Decode the json file.
     * 
     * @param String $path
     */
    public static function decodeJsonFile(String $path)
    {
        // Get file
        $file = json_decode(self::disk()->get($path));

        // Return the file content
        return $file;
    }

    /**
     *  Get the current version.
     * 
     * @return string
     */
    public static function currentVersion()
    {
        // Get versions
        $versions = collect(config('changelog.versions'))->reverse();

        // First matched version
        return $versions->filter(function($date, $version) { return self::timestamp($date) < now()->getTimestamp(); })->keys()->first();
    }
}