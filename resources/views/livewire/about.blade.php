<div class="container mt-5">
    <!-- Introducción -->
    <div class="text-center mb-4">
        <h1>{{ __('about.title') }}</h1>
        <p class="lead">{{ __('about.subtitle') }}</p>
    </div>

    <!-- Misión y Visión -->
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('about.mission_title') }}</h5>
                    <p class="card-text">{{ __('about.mission_text') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ __('about.vision_title') }}</h5>
                    <p class="card-text">{{ __('about.vision_text') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipo -->
    <div class="text-center mb-4">
        <h2>{{ __('about.team_title') }}</h2>
        <p>{{ __('about.team_subtitle') }}</p>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="{{ __('about.team_member_alt') }}">
                <div class="card-body">
                    <h5 class="card-title">{{ __('about.team_member_1_name') }}</h5>
                    <p class="card-text">{{ __('about.team_member_1_desc') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="{{ __('about.team_member_alt') }}">
                <div class="card-body">
                    <h5 class="card-title">{{ __('about.team_member_2_name') }}</h5>
                    <p class="card-text">{{ __('about.team_member_2_desc') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="https://via.placeholder.com/300" class="card-img-top" alt="{{ __('about.team_member_alt') }}">
                <div class="card-body">
                    <h5 class="card-title">{{ __('about.team_member_3_name') }}</h5>
                    <p class="card-text">{{ __('about.team_member_3_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
