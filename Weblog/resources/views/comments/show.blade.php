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

    function displayComments(comments) {
    const commentsSection = document.getElementById('comments-section');
    commentsSection.innerHTML = ''; // Clear the loading text

    comments.forEach(comment => {
        if (!comment.user || !comment.user.name) {
            console.error('Comment user data is missing:', comment);
            return; // Skip this comment
        }

        // Create the comment card
        const commentCard = document.createElement('div');
        commentCard.classList.add('card', 'mb-3');

        const commentCardBody = document.createElement('div');
        commentCardBody.classList.add('card-body');

        const commentHeader = document.createElement('h6');
        commentHeader.classList.add('card-subtitle', 'mb-2', 'text-muted');

        // Check if the commenter is the author of the article
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

        if (comment.replies.length > 0) {
            const repliesButton = document.createElement('button');
            repliesButton.classList.add('btn', 'btn-sm', 'btn-primary');
            repliesButton.innerText = 'View Replies';
            repliesButton.onclick = function() {
                toggleReplies(comment.id);
            };
            commentCardBody.appendChild(repliesButton);

            const repliesDiv = document.createElement('div');
            repliesDiv.id = `replies-${comment.id}`;
            repliesDiv.style.display = 'none';
            repliesDiv.classList.add('mt-3', 'ms-3');

            comment.replies.forEach(reply => {
                if (!reply.user || !reply.user.name) {
                    console.error('Reply user data is missing:', reply);
                    return; // Skip this reply
                }

                const replyCard = document.createElement('div');
                replyCard.classList.add('card', 'mb-2');

                const replyCardBody = document.createElement('div');
                replyCardBody.classList.add('card-body', 'bg-light');

                const replyHeader = document.createElement('h6');
                replyHeader.classList.add('card-subtitle', 'mb-2', 'text-muted');

                // Check if the reply's commenter is the author of the article
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

                repliesDiv.appendChild(replyCard);
            });

            commentCardBody.appendChild(repliesDiv);
        }

        commentCard.appendChild(commentCardBody);
        commentsSection.appendChild(commentCard);
    });
}


    function toggleReplies(commentId) {
        const repliesDiv = document.getElementById(`replies-${commentId}`);
        repliesDiv.style.display = repliesDiv.style.display === 'none' ? 'block' : 'none';
    }
</script>
