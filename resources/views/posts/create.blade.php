<!DOCTYPE html>
<html>

<head>

    <title>Create Post</title>

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

        .publish {
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

        <h1>Create Post</h1>

        <a href="/" class="back">← Back to Posts</a>

        <form action="{{ route('posts.store') }}" method="POST">

            @csrf

            <label>Title</label>

            <input type="text" name="title" required>

            <label>Content</label>

            <textarea name="content"></textarea>

            <button type="submit" name="status" value="publish" class="btn publish">
                Publish
            </button>

            <button type="submit" name="status" value="draft" class="btn draft">
                Save Draft
            </button>

        </form>

    </div>

</body>

</html>