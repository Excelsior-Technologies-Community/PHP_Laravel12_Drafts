<!DOCTYPE html>
<html>

<head>
    <title>Post List</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 95%;
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 20px;
            color: #222;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .preview-btn {
            background: #6f42c1;
            padding: 7px 12px;
            font-size: 14px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-form input,
        .search-form select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            min-width: 180px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f1f1f1;
        }

        tr:hover {
            background: #fafafa;
        }

        .status-published {
            color: green;
            font-weight: bold;
        }

        .status-draft {
            color: orange;
            font-weight: bold;
        }

        .content-column {
            max-width: 300px;
            line-height: 1.6;
            color: #555;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        @media(max-width:768px) {

            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-form {
                flex-direction: column;
            }

            table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="top-bar">

            <h1>Post Management</h1>

            <a href="/create" class="btn">
                + Create Post
            </a>

        </div>

        @if(session('success'))

            <div class="success">
                {{ session('success') }}
            </div>

        @endif

        <form method="GET" action="/" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search by title..."
                value="{{ request('search') }}"
            >

            <select name="status">

                <option value="">
                    All Status
                </option>

                <option
                    value="draft"
                    {{ request('status') == 'draft' ? 'selected' : '' }}
                >
                    Draft
                </option>

                <option
                    value="published"
                    {{ request('status') == 'published' ? 'selected' : '' }}
                >
                    Published
                </option>

            </select>

            <button type="submit" class="btn">
                Search
            </button>

        </form>

        <br>

        <table>

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            @forelse($posts as $post)

                <tr>

                    <td>
                        {{ $post->id }}
                    </td>

                    <td>
                        {{ $post->title }}
                    </td>

                    <td class="content-column">
                        {{ Str::limit($post->content, 100) }}
                    </td>

                    <td>

                        @if($post->is_published)

                            <span class="status-published">
                                Published
                            </span>

                        @else

                            <span class="status-draft">
                                Draft
                            </span>

                        @endif

                    </td>

                    <td>

                        <a
                            href="{{ route('posts.preview', $post->id) }}"
                            class="btn preview-btn"
                        >
                            Preview
                        </a>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="empty">
                        No posts found.
                    </td>

                </tr>

            @endforelse

        </table>

    </div>

</body>

</html>