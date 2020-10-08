<!DOCTYPE html>
<html>
    <body>
        <style>
        body {
            font-family: monospace;
        }
        </style>
        <div>
            <h2>ChangeLog {{ config('app.name') }} - Development</h2>
            <hr><br>
            <form method="post" action="{{ route('changelog.store') }}">
                @csrf
                <p>Add new release log - current version {{ $version }}</p>
                <textarea name="content" rows="4" cols="70" required></textarea>
                <br><br>
                <button type="submit">Submit</button>
            </form>
        </div>
    </body>
</html>
