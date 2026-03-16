<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('frontend.index') }}">
            <i class="fas fa-database"></i> {{ config('app.name', 'Portal Data') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.datasets') }}">
                        <i class="fas fa-table"></i> Datasets
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.index') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.search') }}">
                        <i class="fas fa-search"></i> Search
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.create') }}">
                        <i class="fas fa-plus"></i> Add Dataset
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.organizations') }}">
                        <i class="fas fa-building"></i> Organizations
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
