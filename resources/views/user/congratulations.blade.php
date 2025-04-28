<div class="container text-center">
    <div class="alert alert-success mt-5">
        <h2>🎉 Congratulations! 🎉</h2>
        <p>You have reached your <strong>{{ $goalType }}</strong> goal!</p>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: {{ $progressPercentage }}%" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <p>Keep up the great work!</p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</div>
