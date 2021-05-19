@include('includes.header')

<h1>{{ $header ?? null }}</h1>

<p>{{ $message ?? null }}</p>

<div class="books-container">
    @foreach ($books as $book)
        <div class="book">
            <figure class="book-image">
                <img src="img/{{ $book['image'] }}" alt="{{ $book['title'] }}">
            </figure>
            <div class="book-info">
                <div>{{ $book['title'] }}</div>
                <div>{{ $book['publisher'] }}</div>
                <div>{{ $book['author'] }}</div>
                <div>ISBN: {{ $book['ISBN'] }}</div>
            </div>
        </div>
    @endforeach
</div>

@include('includes.footer')
