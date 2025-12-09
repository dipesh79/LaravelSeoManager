@extends('seo::partials.app')

@section('title', 'SEO Tag Details')
@section('content')
    <h1 class="mb-4">SEO Tag Details</h1>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h2>{{ $tag->title }}</h2>
            <div>
                <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('admin.seo.edit', $tag->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('admin.seo.delete', $tag->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this tag?');">Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <!-- General SEO Tags -->
            <h3 class="mb-4">General SEO Tags</h3>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">URI:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->uri }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Title:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->title }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Description:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->description }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Keywords:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->keywords }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Robots:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->robots }}</p>
                </div>
            </div>

            <!-- OG Tags -->
            <h3 class="mb-4">OG Tags</h3>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">OG Title:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->og_title }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">OG Description:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->og_description }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">OG URL:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->og_url }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">OG Image:</label>
                <div class="col-sm-9">
                    <img src="{{ $tag->ogImage() }}" alt="OG Image" class="img-fluid fixed-image-size">
                </div>
            </div>

            <!-- Twitter Tags -->
            <h3 class="mb-4">Twitter Tags</h3>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Twitter Card:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->twitter_card }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Twitter Title:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->twitter_title }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Twitter Description:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->twitter_description }}</p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Twitter Image:</label>
                <div class="col-sm-9">
                    <img src="{{ $tag->twitterImage() }}" alt="Twitter Image" class="img-fluid fixed-image-size">
                </div>
            </div>

            <!-- Schema Tags -->
            <h3 class="mb-4">Schema Tags</h3>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Json LD:</label>
                <div class="col-sm-9">
                    <p class="card-text">{{ $tag->json_ld }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .fixed-image-size {
            width: 200px; /* Set desired width */
            height: 150px; /* Set desired height */
            object-fit: cover; /* Maintain aspect ratio */
        }
    </style>
@endpush
