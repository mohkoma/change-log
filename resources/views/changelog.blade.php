<!DOCTYPE html>
<html>
    <body>
        <style>
        h4, h3, ul, hr, h2 {
            margin: 13px;
        }
        li {
            margin: 25px;
        }
        body {
            font-family: monospace;
        }
        </style>
        <div>
            <h2>ChangeLog {{ config('app.name') }} - Development</h2>
            <hr><br>
            @foreach($releases as $release)
                <h3># Version [{{strtoupper($release->version)}}] - {{ $release->date }}</h3>
                <ul>
                    @foreach($release->changes as $change)
                        <li>{{ $change->content }} ({{ date('Y-m-d', $change->timestamp) }})</li>
                    @endforeach
                </ul><br>
            @endforeach
        </div>
    </body>
</html>