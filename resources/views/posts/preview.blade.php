<!DOCTYPE html>
<html>

<head>

    <title>Preview Post</title>

    <style>

        body{
            font-family: Arial;
            background:#f4f6f9;
            margin:0;
            padding:40px;
        }

        .container{
            max-width:800px;
            margin:auto;
            background:white;
            padding:40px;
            border-radius:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .status{
            display:inline-block;
            padding:6px 12px;
            border-radius:20px;
            margin-bottom:20px;
            font-size:14px;
        }

        .published{
            background:#d4edda;
            color:#155724;
        }

        .draft{
            background:#fff3cd;
            color:#856404;
        }

        .back{
            text-decoration:none;
            display:inline-block;
            margin-bottom:20px;
            color:#3490dc;
        }

        h1{
            margin-bottom:20px;
        }

        p{
            line-height:1.8;
            color:#444;
        }

    </style>

</head>

<body>

<div class="container">

    <a href="/" class="back">
        ← Back to Posts
    </a>

    <div>

        @if($post->is_published)

            <span class="status published">
                Published
            </span>

        @else

            <span class="status draft">
                Draft Preview
            </span>

        @endif

    </div>

    <h1>
        {{ $post->title }}
    </h1>

    <p>
        {{ $post->content }}
    </p>

</div>

</body>

</html>