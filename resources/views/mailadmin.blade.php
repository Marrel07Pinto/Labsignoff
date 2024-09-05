<!DOCTYPE html>
<html>
<body>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Feedback and Attendance Data of {{$labnumber}}</h1>
        </div>
        <section class="section">
            <p>Hi {{$adminname}},</p>

            <!-- Attendance Information -->
            <p><label>Attendance:</label></p>
            <ul>
                <li>Number of students that are present: {{ $present }}</li>
                <li>Number of students that are partially present: {{ $partialPresent }}</li>
                <li>Number of students that are absent: {{ $totalabsent }}</li>
            </ul>

            <!-- Feedback and Attendance Summary -->
            <p>This email contains the feedback and attendance data for lab number {{$labnumber}}. Please review the details below:</p>
            <p><label>Total number of students the feedback was given:</label> {{ $totalcount }}</p>
            <p><label>Understanding:</label> 
                <span style="color: {{ getColorCategory($average) }}">{{ $average }} ({{ categorize($average) }})</span>
            </p>
            <p><label>Overall experience of students:</label> 
                <span style="color: {{ getColorCategory($averageoverall) }}">{{ $averageoverall }} ({{ categorize($averageoverall) }})</span>
            </p>
            <p><label>Overall difficulty of the lab task:</label> 
                <span style="color: {{ getColorCategory($averagedifficulty) }}">{{ $averagedifficulty }} ({{ categorize($averagedifficulty) }})</span>
            </p>
            <p>
                <label>Confusion in the lab task:</label>
                @if ($positivecount < $negativecount)
                    <span style="color: red;">Majority of the students were unclear regarding the lab task.</span>
                @else
                    <span style="color: green;">There is no confusion in the lab.</span>
                @endif
            </p>

            <!-- Additional Notes -->
            @php
                $notes = [];
                if ($average < 60) {
                    $notes[] = 'The understanding score is below average. Please consider improving the teaching methods or materials.';
                }
                if ($averageoverall < 60) {
                    $notes[] = 'The overall experience rating is below average. Please gather feedback to enhance the overall lab experience.';
                }
                if ($averagedifficulty > 60) {
                    $notes[] = 'The difficulty level of the lab task is higher than expected. Consider adjusting the difficulty or providing additional resources.';
                }
                if ($totalabsent > $present) {
                    $notes[] = 'The number of absents is higher than the number of present students. It might be useful to investigate the reasons for high absenteeism.';
                }
            @endphp

            @if (!empty($notes))
                <p><strong>Notes:</strong></p>
                <ul>
                    @foreach ($notes as $note)
                        <li style="color: red;">{{ $note }}</li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
</body>
</html>

@php
function categorize($value) {
    if ($value >= 90) {
        return 'outstanding';
    } elseif ($value >= 80) {
        return 'excellent';
    } elseif ($value >= 70) {
        return 'very-good';
    } elseif ($value >= 60) {
        return 'good';
    } elseif ($value >= 50) {
        return 'average';
    } elseif ($value >= 40) {
        return 'poor';
    } else {
        return 'below-minimum';
    }
}

function getColorCategory($value) {
    $category = categorize($value);
    switch ($category) {
        case 'outstanding':
        case 'excellent':
        case 'very-good':
        case 'good':
        case 'average':
            return 'green';
        case 'poor':
        case 'below-minimum':
            return 'red';
        default:
            return 'black';
    }
}
@endphp
