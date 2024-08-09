<h2>{{$category->name}}</h2>

<ul>
        @foreach($articles as $article)
        <li class="list-group-item">
            <a href="{{route('articles.show', $article->id) }}"> {{$article->name}}</a>
            {{$article->preview}}
            
        </li>
        @endforeach
    </ul>