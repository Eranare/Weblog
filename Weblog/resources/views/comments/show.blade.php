@if(Auth::check())
    <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="article_id" value="{{ $article->id }}">
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="Write a comment..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>
@endif

<h2>Comments</h2>
<div id="comments-section">
    <p>Loading comments...</p>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchComments({{ $article->id }});
    });

    function fetchComments(articleId) {
        fetch(`/api/articles/${articleId}/comments`)
            .then(response => response.json())
            .then(comments => {
                displayComments(comments);
            })
            .catch(error => {
                console.error('Error fetching comments:', error);
                document.getElementById('comments-section').innerHTML = '<p>Failed to load comments.</p>';
            });
    }

    function displayComments(comments, parentElement = null) {
        const commentsSection = parentElement || document.getElementById('comments-section');
        commentsSection.innerHTML = ''; // Clear the loading text

        comments.forEach(comment => {
            if (!comment.user || !comment.user.name) {
                console.error('Comment user data is missing:', comment);
                return; // Skip this comment
            }

            // Create the comment card
            const commentCard = document.createElement('div');
            commentCard.classList.add('card', 'mb-3', 'nested-comment');

            const commentCardBody = document.createElement('div');
            commentCardBody.classList.add('card-body');

            const commentHeader = document.createElement('h6');
            commentHeader.classList.add('card-subtitle', 'mb-2', 'text-muted');

            let authorLabel = '';
            if (comment.user_id === {{ $article->user->id }}) {
                authorLabel = `<span class="badge bg-primary ms-2">Author</span>`;
            }

            commentHeader.innerHTML = `${comment.user.name} - ${new Date(comment.created_at).toLocaleDateString()} ${authorLabel}`;

            const commentContent = document.createElement('p');
            commentContent.classList.add('card-text');
            commentContent.innerText = comment.content;

            commentCardBody.appendChild(commentHeader);
            commentCardBody.appendChild(commentContent);

            // Add reply button
            if ({{ Auth::check() ? 'true' : 'false' }}) {
                const replyButton = document.createElement('button');
                replyButton.classList.add('btn', 'btn-sm', 'btn-link');
                replyButton.innerText = 'Reply';
                replyButton.onclick = function () {
                    toggleReplyForm(comment.id);
                };
                commentCardBody.appendChild(replyButton);

                // Reply form
                const replyForm = document.createElement('form');
                replyForm.id = `reply-form-${comment.id}`;
                replyForm.style.display = 'none';
                replyForm.classList.add('reply-form', 'mt-2');
                replyForm.innerHTML = `
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                    <input type="hidden" name="parent_id" value="${comment.parent_id ? comment.parent_id : comment.id}">
                    <textarea name="content" class="form-control mb-2" rows="2" placeholder="Write a reply..."></textarea>
                    <button type="submit" class="btn btn-sm btn-primary">Post Reply</button>
                `;
                replyForm.action = "{{ route('comments.store') }}";
                replyForm.method = 'POST';
                commentCardBody.appendChild(replyForm);
            }

            // If there are replies, show a "View Replies" button, collapse replies initially
            if (comment.replies.length > 0) {
                const repliesButton = document.createElement('button');
                repliesButton.classList.add('btn', 'btn-sm', 'btn-link');
                repliesButton.innerText = `View Replies (${comment.replies.length})`;
                repliesButton.onclick = function() {
                    toggleReplies(comment.id);
                };
                commentCardBody.appendChild(repliesButton);

                const repliesDiv = document.createElement('div');
                repliesDiv.id = `replies-${comment.id}`;
                repliesDiv.style.display = 'none'; // Hidden by default
                repliesDiv.classList.add('mt-3', 'ms-3');

                displayReplies(comment.replies, repliesDiv); // Only one level of replies

                commentCardBody.appendChild(repliesDiv);
            }

            commentCard.appendChild(commentCardBody);
            commentsSection.appendChild(commentCard);
        });
    }

    // Function to display a single level of replies
    function displayReplies(replies, parentElement) {
        parentElement.innerHTML = ''; // Clear existing replies
        replies.forEach(reply => {
            const replyCard = document.createElement('div');
            replyCard.classList.add('card', 'mb-2');

            const replyCardBody = document.createElement('div');
            replyCardBody.classList.add('card-body', 'bg-light');

            const replyHeader = document.createElement('h6');
            replyHeader.classList.add('card-subtitle', 'mb-2', 'text-muted');

            let replyAuthorLabel = '';
            if (reply.user_id === {{ $article->user->id }}) {
                replyAuthorLabel = `<span class="badge bg-primary ms-2">Author</span>`;
            }

            replyHeader.innerHTML = `${reply.user.name} - ${new Date(reply.created_at).toLocaleDateString()} ${replyAuthorLabel}`;

            const replyContent = document.createElement('p');
            replyContent.classList.add('card-text');
            replyContent.innerText = reply.content;

            replyCardBody.appendChild(replyHeader);
            replyCardBody.appendChild(replyContent);
            replyCard.appendChild(replyCardBody);

            parentElement.appendChild(replyCard);
        });
    }

    function toggleReplyForm(commentId) {
        const replyForm = document.getElementById(`reply-form-${commentId}`);
        replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
    }

    function toggleReplies(commentId) {
        const repliesDiv = document.getElementById(`replies-${commentId}`);
        const repliesButton = repliesDiv.previousElementSibling; // The button just before the replies

        if (repliesDiv.style.display === 'none') {
            repliesDiv.style.display = 'block';
            repliesButton.innerText = 'Hide Replies';
        } else {
            repliesDiv.style.display = 'none';
            repliesButton.innerText = `View Replies (${repliesDiv.children.length})`;
        }
    }
</script>

<style>
    /* Styling for nested comments */
    .nested-comment {
        margin-left: 20px;
    }
</style>
