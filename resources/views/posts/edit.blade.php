<!DOCTYPE html>
<html>

<head>
    <title>Edit Post</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }

        .container {
            width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 120px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .update {
            background: #28a745;
            color: white;
        }

        .draft {
            background: #ffc107;
            color: black;
        }

        .back {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #3490dc;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>Edit Post</h1>

        <a href="/" class="back">← Back to Posts</a>

        <form action="{{ route('posts.update', $post->id) }}" method="POST">

            @csrf
            @method('PUT')

            <label>Title</label>
            <input type="text" name="title" value="{{ $post->title }}" required>

            <label>Content</label>
            <textarea name="content">{{ $post->content }}</textarea>

            @if($post->is_published)
                <button type="submit" name="status" value="publish" class="btn update">
                    Update Published
                </button>
            @else
                <button type="submit" name="status" value="publish" class="btn update">
                    Publish & Update
                </button>
                <button type="submit" name="status" value="draft" class="btn draft">
                    Save as Draft
                </button>
            @endif

        </form>

    </div>

</body>

</html>