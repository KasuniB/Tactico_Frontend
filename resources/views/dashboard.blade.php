<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HomePage</title>
    <link rel="icon" href="{{ asset('scout.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .main-body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .main-footer {
            margin-top: auto;
        }
    </style>
</head>
<body class="main-body">
    @include('frontend.Navigation') <!-- Include the navigation view -->

    <div class="container my-5">
        <form method="POST" action="{{ action('App\Http\Controllers\PlayerRecommendationController@index') }}">
            @csrf
            <div class="mb-3">
                <label for="player_type" class="form-label">Player Type:</label>
                <input type="text" class="form-control" id="player_type" name="player_type">
            </div>
            <div class="mb-3">
                <label for="query" class="form-label">Player Name:</label>
                <input type="text" class="form-control" id="query" name="query">
            </div>
            <div class="mb-3">
                <label for="count" class="form-label">Count:</label>
                <input type="text" class="form-control" id="count" name="count">
            </div>
            <div class="mb-3">
                <label for="comparison" class="form-label">Comparison:</label>
                <input type="text" class="form-control" id="comparison" name="comparison">
            </div>
            <div class="mb-3">
                <label for="league" class="form-label">League:</label>
                <input type="text" class="form-control" id="league" name="league">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        @if (isset($error))
        <script>
            swal("Error", "{{ $error }}", "error");
            </script>
        @else
            @isset($data)
            <table class="table mt-5">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Similarity</th>
                        <th>1</th>
                        <th>11</th>
                        <th>141</th>
                        <th>3</th>
                        <th>5</th>
                        <th>6</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $player)
                    <tr>
                        <td>{{ $player['Player'] }}</td>
                        <td>{{ $player['Similarity'] }}</td>
                        <td>{{ $player['1'] }}</td>
                        <td>{{ $player['11'] }}</td>
                        <td>{{ $player['141'] }}</td>
                        <td>{{ $player['3'] }}</td>
                        <td>{{ $player['5'] }}</td>
                        <td>{{ $player['6'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Insert the canvas for the chart here -->
            <canvas id="similarityChart"></canvas>
            @endisset
        @endif
    </div>

    @include('frontend.FooterPage') <!-- Include the footer view -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Add the script to create the chart -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        @isset($data)
        const data = @json($data);
        const labels = data.map(player => player.Player);
        const similarities = data.map(player => parseFloat(player.Similarity));

        // get the minimum similarity value and decrease it a bit for the chart's minimum y value
        const minSimilarity = Math.min(...similarities) - 0.1;

        // get the maximum similarity value and increase it a bit for the chart's maximum y value
        const maxSimilarity = Math.max(...similarities) + 0.1;

        const ctx = document.getElementById('similarityChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Similarity',
                    data: similarities,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        min: minSimilarity,
                        max: maxSimilarity
                    }
                }
            }
        });
        @endisset
    });
    </script>
</body>
</html>
