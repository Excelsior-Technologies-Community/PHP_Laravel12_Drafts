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
            max-width: 1200px;
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
            font-size: 14px;
        }
        .btn-create {
            background: #28a745;
        }
        .btn-preview {
            background: #6f42c1;
            padding: 6px 10px;
            font-size: 12px;
        }
        .btn-edit {
            background: #ffc107;
            color: #333;
            padding: 6px 10px;
            font-size: 12px;
        }
        .btn-delete {
            background: #dc3545;
            padding: 6px 10px;
            font-size: 12px;
        }
        .btn:hover {
            opacity: 0.85;
        }
        .search-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .search-form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .search-group {
            flex: 1;
            min-width: 180px;
        }
        .search-group label {
            display: block;
            font-size: 12px;
            margin-bottom: 5px;
            color: #666;
        }
        .search-group input,
        .search-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .search-btn {
            background: #3490dc;
            padding: 10px 20px;
        }
        .reset-btn {
            background: #6c757d;
        }
        .live-search-status {
            font-size: 12px;
            color: #28a745;
            margin-top: 10px;
            display: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background: #f1f1f1;
            font-weight: bold;
        }
        tr:hover {
            background: #fafafa;
        }
        .status-published {
            color: #28a745;
            font-weight: bold;
        }
        .status-review {
            color: #004085;
            font-weight: bold;
        }
        .status-draft {
            color: #ffc107;
            font-weight: bold;
        }
        .content-column {
            max-width: 250px;
            line-height: 1.5;
            color: #555;
            font-size: 13px;
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
            padding: 40px;
            color: #777;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        .delete-form {
            display: inline;
        }
        .pagination-cell {
            background: #f8f9fa;
        }
        .pagination-links {
            padding: 15px;
            text-align: center;
        }
        .pagination-links nav {
            display: inline-block;
        }
        .pagination-links ul {
            display: flex;
            gap: 5px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .pagination-links li {
            display: inline-block;
        }
        .pagination-links a,
        .pagination-links span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #3490dc;
        }
        .pagination-links .active span {
            background: #3490dc;
            color: white;
            border-color: #3490dc;
        }
        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        @media(max-width: 768px) {
            .container {
                padding: 20px;
            }
            .search-form {
                flex-direction: column;
            }
            .action-buttons {
                flex-direction: column;
            }
            table {
                display: block;
                overflow-x: auto;
            }
            th, td {
                white-space: nowrap;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <h1>Post Management</h1>
            <a href="{{ route('posts.create') }}" class="btn btn-create">+ Create New Post</a>
        </div>
        @if(session('success'))
            <div class="success" id="success-message">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    $('#success-message').fadeOut('slow');
                }, 3000);
            </script>
        @endif
        <div class="search-section">
            <div class="search-form">
                <div class="search-group">
                    <label>Search by Title</label>
                    <input type="text" id="live-search" placeholder="Type to search..." autocomplete="off">
                </div>
                <div class="search-group">
                    <label>Filter by Status</label>
                    <select id="status-filter">
                        <option value="">All Status</option>
                        <option value="draft">Draft</option>
                        <option value="review">In Review</option>
                        <option value="published">Published</option>
                    </select>
                </div>
                <div>
                    <label>&nbsp;</label>
                    <button type="button" id="reset-filters" class="btn reset-btn">Reset</button>
                </div>
            </div>
            <div class="live-search-status" id="live-search-status">
                Live search is active...
            </div>
        </div>
        <div id="posts-table-container">
            <div class="loading">Loading posts...</div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        let searchTimeout;
        function performLiveSearch() {
            var search = $('#live-search').val();
            var status = $('#status-filter').val();
            $('#live-search-status').show();
            $.ajax({
                url: "{{ route('posts.liveSearch') }}",
                type: "GET",
                data: {
                    search: search,
                    status: status,
                    ajax: 1
                },
                beforeSend: function() {
                    $('#posts-table-container').html('<div class="loading">Loading...</div>');
                },
                success: function(response) {
                    $('#posts-table-container').html(response);
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error: ' + error);
                    $('#posts-table-container').html('<div class="loading">Error loading data. Please refresh the page.</div>');
                }
            });
        }
        $('#live-search').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performLiveSearch, 500);
        });
        $('#status-filter').on('change', function() {
            performLiveSearch();
        });
        $('#reset-filters').on('click', function() {
            $('#live-search').val('');
            $('#status-filter').val('');
            performLiveSearch();
        });
        performLiveSearch();
    });
    </script>
</body>
</html>