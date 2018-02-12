@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/style.less') }}">
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.less') }}">
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/view-story.less') }}">
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
@endsection
<?php
$embed = EmbedVideo::make($post->link)->parseUrl();
// Will return Embed class if provider is found. Otherwie will return false - not found. No fancy errors for now.
if ($embed) {
// Set width of the embed.
$embed->setAttribute(['width' => 600]);

// Print html: '<iframe width="600" height="338" src="//www.youtube.com/embed/uifYHNyH-jA" frameborder="0" allowfullscreen></iframe>'.
// Height will be set automatically based on provider width/height ratio.
// Height could be set explicitly via setAttr() method.

}
?>
@section('content')
    <div class="col-md-7 col-sm-12">
        <div class="single-story-body">
            <div class="story-heading">
                <h1>{{ $post->title }}</h1>
            </div>
            <hr/>
            <div class="feature-img">
                @if($post->is_video==1)
                    <?php
                    echo $embed->getHtml();
                    ?>
                @else
                <img class="img-responsive" src="{{ $post->featured_image }}">
                @endif
                <div class="link-source">
                    <span class="pull-left">source: <a href="#">{{ $post->domain }}</a></span>
                </div>
            </div>
            <hr/>
            <div class="story-content">
                <div>
                    {!! $post->description !!}
                </div>
                <a class="btn btn-block text-danger pull-left" href="#">View Full Site</a>
            </div>

        </div>
        <div class="container" style="margin-top: 10%">
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <form id="addNewStory" action="{{ route('comment.store') }}" method="POST" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea type="text" name="comment" id="storyDesc" rows="5" cols="10" class="form-control"></textarea>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <button type="submit" name="storySubmit" id="storySubmit" class="btn btn-danger pull-right">Reply</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-8 col-xs-12">
                    <div class="comment-box" style="margin: 10px auto">
                        @foreach($post->comments as $comment)
                            <div class="comment">
                                <div class="panel panel-success">
                                    <div class="panel-heading" style="padding: 5px;">
                                    <span class="comment-user text-primary"><strong>{{ $comment->username }}</strong>&nbsp;<span
                                                class="small text-muted commentTime postTime">{{ $comment->created_at }}</span></span>
                                    </div>
                                    <div class="comment-details panel-body">
                                        {{ $comment->comment }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- jQuery Nicescroll CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.6.8-fix/jquery.nicescroll.min.js"></script>
    <script src="js/home.js"></script>
@endsection