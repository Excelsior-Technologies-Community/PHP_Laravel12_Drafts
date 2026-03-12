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
            width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            background: #3490dc;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f1f1f1;
        }

        .status-published {
            color: green;
            font-weight: bold;
        }

        .status-draft {
            color: orange;
            font-weight: bold;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Post List</h1>

        <a href="/create" class="btn">Create Post</a>

        <table>

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
            </tr>

            @foreach($posts as $post)

                <tr>

                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>

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

                </tr>

            @endforeach

        </table>

    </div>

</body>

</html>