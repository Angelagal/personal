@extends('dashboard.master')

@section('content')

<a href="{{ route('post.create') }}" target="blank">Create</a>

<div class="card mt-4">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <td>
                    Id
                </td>
                <td>
                    Title
                </td>
                <td>
                    Posted
                </td>
                <td>
                    Category
                </td>
                <td>
                    Options
                </td>
            </tr>
            <tbody>
                @foreach ($posts as $p)
                  <tr>
                    <td>
                        {{ $p->id }}
                    </td>
                    <td>
                        {{ $p->title }}
                    </td>
                    <td>
                        {{ $p->posted }}
                    </td>
                    <td>
                        {{ $p->category->title }}
                    </td>
                    <td>
                        <a href="{{ route('post.edit', $p->id) }}">Edit</a>
                        <a href="{{ route('post.show', $p->id) }}">Show</a>
                        <form action="{{ route('post.destroy', $p) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                  </tr>
                @endforeach
            </tbody>
        </thead>
    </table>
</div>
</div>

    {{ $posts->links() }}

@endsection