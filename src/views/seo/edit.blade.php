@extends('seo::partials.app')

@section('title', 'Update SEO Tag')
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h2>Update SEO Tag</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.seo.update', $tag->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="accordion mb-4" id="seoTagsAccordion">
                    <!-- General SEO Tags -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="generalSeoHeading">
                            <button
                                class="accordion-button @error('uri') show @enderror @error('title') show @enderror @error('description') show @enderror @error('keywords') show @enderror @error('robots') show @enderror"
                                type="button" data-bs-toggle="collapse" data-bs-target="#generalSeoCollapse"
                                aria-expanded="true" aria-controls="generalSeoCollapse">
                                General SEO Tags
                            </button>
                        </h2>
                        <div id="generalSeoCollapse"
                             class="accordion-collapse collapse @error('uri') show @enderror @error('title') show @enderror @error('description') show @enderror @error('keywords') show @enderror @error('robots') show @enderror"
                             aria-labelledby="generalSeoHeading" data-bs-parent="#seoTagsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label for="uri" class="form-label">URI</label>
                                    <input type="text" class="form-control @error('uri') is-invalid @enderror" id="uri"
                                           name="uri" value="{{ old('uri', $tag->uri) }}">
                                    @error('uri')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                           id="title" name="title" value="{{ old('title', $tag->title) }}">
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description" name="description">{{ old('description', $tag->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="keywords" class="form-label">Keywords</label>
                                    <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                           id="keywords" name="keywords" value="{{ old('keywords', $tag->keywords) }}">
                                    @error('keywords')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="robots" class="form-label">Robots</label>
                                    <input type="text" class="form-control @error('robots') is-invalid @enderror"
                                           id="robots" name="robots" value="{{ old('robots', $tag->robots) }}">
                                    @error('robots')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- OG Tags -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="ogTagsHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#ogTagsCollapse" aria-expanded="false"
                                    aria-controls="ogTagsCollapse">
                                OG Tags
                            </button>
                        </h2>
                        <div id="ogTagsCollapse"
                             class="accordion-collapse collapse @error('og_title') show @enderror @error('og_description') show @enderror @error('og_url') show @enderror @error('og_image') show @enderror"
                             aria-labelledby="ogTagsHeading" data-bs-parent="#seoTagsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label for="og_title" class="form-label">OG Title</label>
                                    <input type="text" class="form-control @error('og_title') is-invalid @enderror"
                                           id="og_title" name="og_title" value="{{ old('og_title', $tag->og_title) }}">
                                    @error('og_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="og_description" class="form-label">OG Description</label>
                                    <textarea class="form-control @error('og_description') is-invalid @enderror"
                                              id="og_description"
                                              name="og_description">{{ old('og_description', $tag->og_description) }}</textarea>
                                    @error('og_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="og_url" class="form-label">OG URL</label>
                                    <input type="url" class="form-control @error('og_url') is-invalid @enderror"
                                           id="og_url" name="og_url" value="{{ old('og_url', $tag->og_url) }}">
                                    @error('og_url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="og_image" class="form-label">OG Image</label>
                                    <input type="file" class="form-control @error('og_image') is-invalid @enderror"
                                           id="og_image" name="og_image">
                                    @if($tag->og_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $tag->og_image) }}" alt="OG Image" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                    @error('og_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Twitter Tags -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="twitterTagsHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#twitterTagsCollapse" aria-expanded="false"
                                    aria-controls="twitterTagsCollapse">
                                Twitter Tags
                            </button>
                        </h2>
                        <div id="twitterTagsCollapse"
                             class="accordion-collapse collapse @error('twitter_card') show @enderror @error('twitter_title') show @enderror @error('twitter_description') show @enderror @error('twitter_image') show @enderror"
                             aria-labelledby="twitterTagsHeading" data-bs-parent="#seoTagsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label for="twitter_card" class="form-label">Twitter Card</label>
                                    <input type="text" class="form-control @error('twitter_card') is-invalid @enderror"
                                           id="twitter_card" name="twitter_card" value="{{ old('twitter_card', $tag->twitter_card) }}">
                                    @error('twitter_card')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_title" class="form-label">Twitter Title</label>
                                    <input type="text" class="form-control @error('twitter_title') is-invalid @enderror"
                                           id="twitter_title" name="twitter_title" value="{{ old('twitter_title', $tag->twitter_title) }}">
                                    @error('twitter_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_description" class="form-label">Twitter Description</label>
                                    <textarea class="form-control @error('twitter_description') is-invalid @enderror"
                                              id="twitter_description"
                                              name="twitter_description">{{ old('twitter_description', $tag->twitter_description) }}</textarea>
                                    @error('twitter_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="twitter_image" class="form-label">Twitter Image</label>
                                    <input type="file" class="form-control @error('twitter_image') is-invalid @enderror"
                                           id="twitter_image" name="twitter_image">
                                    @if($tag->twitter_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $tag->twitter_image) }}" alt="Twitter Image" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif
                                    @error('twitter_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schema Tags -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="schemaTagsHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#schemaTagsCollapse" aria-expanded="false"
                                    aria-controls="schemaTagsCollapse">
                                Schema Tags
                            </button>
                        </h2>
                        <div id="schemaTagsCollapse"
                             class="accordion-collapse collapse @error('schema_type') show @enderror @error('schema_name') show @enderror @error('schema_description') show @enderror @error('schema_url') show @enderror"
                             aria-labelledby="schemaTagsHeading" data-bs-parent="#seoTagsAccordion">
                            <div class="accordion-body">
                                <div class="mb-3">
                                    <label for="schema_type" class="form-label">Schema Type</label>
                                    <input type="text" class="form-control @error('schema_type') is-invalid @enderror"
                                           id="schema_type" name="schema_type" value="{{ old('schema_type', $tag->schema_type) }}">
                                    @error('schema_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="schema_name" class="form-label">Schema Name</label>
                                    <input type="text" class="form-control @error('schema_name') is-invalid @enderror"
                                           id="schema_name" name="schema_name" value="{{ old('schema_name', $tag->schema_name) }}">
                                    @error('schema_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="schema_description" class="form-label">Schema Description</label>
                                    <textarea class="form-control @error('schema_description') is-invalid @enderror"
                                              id="schema_description"
                                              name="schema_description">{{ old('schema_description', $tag->schema_description) }}</textarea>
                                    @error('schema_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="schema_url" class="form-label">Schema URL</label>
                                    <input type="url" class="form-control @error('schema_url') is-invalid @enderror"
                                           id="schema_url" name="schema_url" value="{{ old('schema_url', $tag->schema_url) }}">
                                    @error('schema_url')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="json_ld" class="form-label">Json Ld</label>
                                    <textarea class="form-control @error('json_ld') is-invalid @enderror"
                                              id="json_ld" name="json_ld">{{ old('json_ld', $tag->json_ld) }}</textarea>
                                    @error('json_ld')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="type" value="static">

                <button type="submit" class="btn btn-primary">Update SEO Tag</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var accordionItems = document.querySelectorAll('.accordion-item');

            // Open the first accordion item by default
            if (accordionItems.length > 0) {
                var firstAccordionItem = accordionItems[0];
                var firstCollapse = firstAccordionItem.querySelector('.accordion-collapse');
                if (firstCollapse) {
                    firstCollapse.classList.add('show');
                }
            }

            // Ensure sections with errors are open
            var errorElements = document.querySelectorAll('.invalid-feedback');
            if (errorElements.length > 0) {
                var collapseElements = document.querySelectorAll('.accordion-collapse');
                collapseElements.forEach(function (collapse) {
                    collapse.classList.add('show');
                });
            }
        });
    </script>
@endpush
