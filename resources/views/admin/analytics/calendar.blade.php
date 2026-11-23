@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar3"></i> Booking Calendar</h2>
    <a href="{{ route('admin.analytics.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Analytics
    </a>
</div>

<div class="card p-4">
    <div id="calendar"></div>
</div>

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        events: {!! json_encode($events) !!},
        eventClick: function(info) {
            if (info.event.url) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            }
        },
        height: 'auto',
        themeSystem: 'bootstrap5'
    });
    calendar.render();
});
</script>

<style>
    #calendar {
        color: #1e293b;
    }
    .fc {
        background: white;
        padding: 20px;
        border-radius: 10px;
    }
</style>
@endsection
