@extends('seo::partials.app')

@section('title', 'All SEO Tags')
@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">SEO Tags</h1>

        <div class="mb-3 d-flex justify-content-between align-items-center">
            <!-- Buttons -->
            <div>
                <a href="{{ route('admin.seo.create') }}" class="btn btn-primary me-2">Add New Page</a>
                <form id="generate-form" action="{{ route('admin.seo.generate-static-pages') }}" method="POST"
                      class="d-inline">
                    @csrf
                    <button id="generate-btn" type="submit" class="btn btn-secondary">
                        <span id="generate-text">Generate Static Pages</span>
                        <span id="spinner" class="spinner-border spinner-border-sm ms-2" role="status"
                              aria-hidden="true" style="display: none;"></span>
                    </button>
                </form>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.seo.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" value="{{ $search }}"
                       placeholder="Search...">
                <button type="submit" class="btn btn-primary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.seo.index') }}" class="btn btn-danger ms-2" title="Clear Search">X</a>
                @endif
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                <tr>
                    <th>URI</th>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($tags as $tag)
                    <tr>
                        <td>{{ $tag->uri }}</td>
                        <td>{{ $tag->title }}</td>
                        <td>
                            @if(auth()->user()->canViewSeo())
                                <a href="{{ route('admin.seo.show', $tag->id) }}"
                                   class="btn btn-primary btn-sm">View</a>
                            @endif
                            @if(auth()->user()->canUpdateSeo())
                                <a href="{{ route('admin.seo.edit', $tag->id) }}"
                                   class="btn btn-warning btn-sm">Edit</a>
                            @endif
                            @if(auth()->user()->canDeleteSeo())

                                <form action="{{ route('admin.seo.delete', $tag->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this tag?');">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No tags found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        <div class="mt-3">
            {{ $tags->links('pagination::bootstrap-4') }}
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('generate-form').addEventListener('submit', function () {
                document.getElementById('generate-btn').disabled = true;
                document.getElementById('generate-text').style.display = 'none';
                document.getElementById('spinner').style.display = 'inline-block';
            });
        </script>
    @endpush
@endsection
