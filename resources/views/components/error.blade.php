@extends('entry')
@section('content')
<div class="container-fluid">
    <div class="error-content d-flex justify-content-center">
        <img class="" src="{{ asset('images/elements/13.jpg') }}" alt="Background Image">

        <div class="container align-self-center ">
            <h1 class="error-code">404</h1>
            <h2 class="error-message">Page Not Found</h2>
            <p class="error-description">
                The page you are looking for might have been removed, had its name changed,
                or is temporarily unavailable. Please check the URL and try again.
            </p>
            <div class="redirect-timer">
                You will be automatically redirected to the homepage in <span id="countdown">10</span> seconds
            </div>
            <a href="/" class="btn btn-primary py-2 px-2" id="goHomeBtn">
                 Return to Homepage
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Set the countdown time in seconds
    let countdownTime = 10;
    const countdownElement = document.getElementById('countdown');

    // Function to update the countdown timer
    function updateCountdown() {
        countdownElement.textContent = countdownTime;

        if (countdownTime <= 0) {
            // When countdown reaches 0, redirect to home page
            window.location.href = "/";
        } else {
            // Decrease the countdown time
            countdownTime--;
            // Update the countdown every second
            setTimeout(updateCountdown, 1000);
        }
    }

    // Start the countdown when page loads
    document.addEventListener('DOMContentLoaded', function() {
        updateCountdown();

        // Set a timeout to redirect after 10 seconds
        setTimeout(function() {
            window.location.href = "/";
        }, 10000); // 10 seconds

        // Add click event listener to the home button
        document.getElementById('goHomeBtn').addEventListener('click', function() {
            window.location.href = "/";
        });
    });
</script>
</body>
@endsection