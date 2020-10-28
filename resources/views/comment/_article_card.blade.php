{{-- $article = Article::find(778) --}}
<div class="card">
    <div class="row no-gutters">
@if ($article->thumbnail)
        <div class="col-4">
            <img src="{{ $article->thumbnail }}" class="card-img-top" alt="{{ $article->title }}" />
        </div>
        <div class="col-8">
@else
        <div class="col">
@endif
            <div class="card-body">
                <h6 class="card-title">{!! $article->html_title !!}</h6>
            </div>
        </div>
    </div>
</div>