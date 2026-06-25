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
        h1 { margin-bottom: 20px; }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea { height: 120px; }
        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .update { background: #28a745; color: white; }
        .draft  { background: #ffc107; color: black; }
        .review { background: #17a2b8; color: white; }
        .back {
            display: inline-block;
            margin-bottom: 15px;
            text-decoration: none;
            color: #3490dc;
        }
        label { font-size: 14px; color: #444; }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Post</h1>
    <a href="{{ route('posts.index') }}" class="back">← Back to Posts</a>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Title</label>
        <input type="text" name="title" value="{{ $post->title }}" required>

        <label>Content</label>
        <textarea name="content">{{ $post->content }}</textarea>

        <label>Status</label>
        <select name="status">
            <option value="draft"     {{ $post->status == 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="review"    {{ $post->status == 'review'    ? 'selected' : '' }}>In Review</option>
            <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
        </select>

        <button type="submit" class="btn update">Update Post</button>
    </form>
</div>
</body>
</html>