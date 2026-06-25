@if($posts->count() > 0)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td><strong>{{ Str::limit($post->title, 40) }}</strong></td>
                <td class="content-column">
                    @if($post->content)
                        {{ Str::limit($post->content, 80) }}
                    @else
                        <span style="color: #999;">No content</span>
                    @endif
                </td>
                <td>
                    @if($post->status == 'published')
                        <span class="status-published">Published</span>
                    @elseif($post->status == 'review')
                        <span class="status-review">In Review</span>
                    @else
                        <span class="status-draft">Draft</span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('posts.preview', $post->id) }}" class="btn btn-preview">Preview</a>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-edit">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        @if($posts->hasPages())
        <tfoot>
            <tr>
                <td colspan="5" class="pagination-cell">
                    <div class="pagination-links">
                        {{ $posts->links() }}
                    </div>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
@else
    <div class="empty">
        <p>📭 No posts found.</p>
        <p><a href="{{ route('posts.create') }}" class="btn btn-create" style="margin-top: 10px;">+ Create your first post</a></p>
    </div>
@endif