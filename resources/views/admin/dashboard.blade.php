@extends('layouts.app')

@section('content')
@include('components.sidebar')
<div class="flex-1 flex flex-col">
    @include('components.navbar')
    @include('components.dashboard')
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('chartTransaksi').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Debit', 'Top Up'],
            datasets: [{
                data: [3, 3],
                backgroundColor: ['#007bff', '#343a40']
            }]
        }
    });
</script>
<script>
    lucide.createIcons();

    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        let title = document.getElementById("sidebar-title");

        if (sidebar.classList.contains("w-64")) {
            sidebar.classList.remove("w-64");
            sidebar.classList.add("w-16");
            title.style.display = "none";
        } else {
            sidebar.classList.remove("w-16");
            sidebar.classList.add("w-64");
            title.style.display = "block";
        }
    }

    function toggleDropdown() {
        let dropdown = document.getElementById("dropdown");
        dropdown.classList.toggle("hidden");
    }
</script>
@endsection
