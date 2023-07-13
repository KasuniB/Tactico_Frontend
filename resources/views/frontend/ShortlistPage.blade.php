<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ShortlistPage</title>
    <link rel="icon" href="{{ asset('scout.png') }}" type="image/x-icon">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .main-body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-footer {
            margin-top: auto;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 10px;
        }
    </style>

</head>
<body class="main-body">
    @include('frontend.Navigation')

    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- Display error message -->
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <h1>Shortlisted Players</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Player Name</th>
                    <th>Position</th>
                    <th>Competition</th>
                    <th>Age</th>
                    <th>Player Type</th>
                    <th>Action</th> <!-- Added Action header -->
                </tr>
            </thead>
            <tbody>
                @foreach ($shortlistedPlayers as $shortlistedPlayer)
                <tr>
                    <td>{{ $shortlistedPlayer->player_name }}</td>
                    <td>{{ $shortlistedPlayer->position }}</td>
                    <td>{{ $shortlistedPlayer->competition }}</td>
                    <td>{{ $shortlistedPlayer->age }}</td>
                    <td>{{ $shortlistedPlayer->player_type }}</td>
                    <td> <!-- Added delete form -->
                        <form action="{{ route('shortlist.destroy', $shortlistedPlayer->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('frontend.FooterPage')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>