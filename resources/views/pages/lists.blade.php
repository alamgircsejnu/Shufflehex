@extends('layouts.master')
@section('css')
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/style.less') }}">
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/list-style.less') }}">
    <link rel="stylesheet/less" href="{{ asset('ChangedDesign/lessFiles/less/sidebar.less') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.7.2/less.min.js"></script>
    @endsection

@section('content')
    <div id="latest-list" class="col-md-7 col-sm-12">
        <div class="row">
            <div class="col-md-1"><span></span></div>
            <div class="col-md-11 plr-1"><h3>Lists</h3></div>
        </div>
<?php
        function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' ago' : 'just now';
        }
?>
        @foreach($posts as $key=>$post)
            <?php
            $upVoteMatched = 0;
            $downVoteMatched = 0;
            $votes=0;
            ?>
                @if(isset(Auth::user()->id) && !empty(Auth::user()->id))
            @foreach($post->votes as $key=>$vote)
                @if($vote->user_id == Auth::user()->id && $vote->vote == 1)
                    <?php $upVoteMatched = 1; ?>
                    @break
                @endif
            @endforeach
            @foreach($post->votes as $key=>$vote)
                @if($vote->user_id == Auth::user()->id && $vote->vote == -1)
                    <?php $downVoteMatched = 1; ?>
                    @break
                @endif
            @endforeach
            @foreach($post->votes as $key=>$vote)
                <?php
                $votes+= $vote->vote;
                ?>
            @endforeach
            @endif
        <div class="stories">
            <div class="story-item">
                <div class="row">
                    <div class="col-md-1 col-sm-1 plr-1" style="height: 100%">
                        <div class="like-thumb text-center">
                            @if($upVoteMatched == 1)
                            
                             <a href="#"
                                             onclick="upVote({{
                                    $post->id
                                    }})"><span  id="btn_upVote_{{ $post->id }}" class="glyphicon glyphicon-thumbs-up" style="font-size: 40px;color: green"></span> </a>
                            @else
                                <a href="#"
                                             onclick="upVote({{
                                    $post->id
                                    }})"><span id="btn_upVote_{{ $post->id }}" class="glyphicon glyphicon-thumbs-up" style="font-size: 40px"></span> </a>
                            @endif

                                <br>

                            <span class="vote-counter text-center" id="vote_count_{{ $post->id }}">{{ $votes }}</span><br>
                                @if($downVoteMatched == 1)
                            <a href="#" 
                                             onclick="downVote({{
                                    $post->id
                                    }})"><span id="btn_downVote_{{ $post->id }}" class="glyphicon glyphicon-thumbs-down" style="font-size: 40px;color: orangered"></span> </a>
                                    @else
                                    <a href="#"
                                                     onclick="downVote({{
                                    $post->id
                                    }})"><span id="btn_downVote_{{ $post->id }}" class="glyphicon glyphicon-thumbs-down" style="font-size: 40px;"></span> </a>
                                    @endif
                        </div>
                    </div>
                    <?php
                    $title = preg_replace('/\s+/', '-', $post->title);
                    $title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);

//                    ---------------------------- Time conversion --------------------------------
                    $date = time_elapsed_string($post->created_at, false);
                    ?>
                    <div class="col-md-3 col-sm-4 plr-1">
                        <div class="story-img">
                            <a href="#"><img class="" src="{{ $post->featured_image }}"></a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-7 plr-1">
                        <p class="story-domain">{{ $post->domain }}</p>
                        <h4 class="story-title"><a href="{{ $post->id }}/{{ $title }}" target="_blank"> {{ $post->title }}</a></h4>
                        <p><small>Sumitted at <strong><span class="postTime"><strong>{{ $date }}</strong></span></strong> by <strong><span>{{ $post->username }}</span></strong> in <strong>{{ $post->category }}</strong></small></p>
                        <div class="list-social-share">
                            <a href="#" class="icon-share-circle"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="icon-share-circle"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="icon-share-circle"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="icon-share-circle"><i class="fa fa-bookmark"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endforeach
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
    <script>
        function upVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_upVote_'+post_id;
            console.log(post_id);
            $.ajax({
                type:'post',
                url: 'vote',
                data: {_token: CSRF_TOKEN , post_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'upvoted'){
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.color = "green"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                }
            });
        };

        function downVote(post_id){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var property = 'btn_downVote_'+post_id;
            console.log(property);
            $.ajax({
                type:'post',
                url: 'vote/downVote',
                data: {_token: CSRF_TOKEN , post_id: post_id},
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                    if(data.status == 'downvoted'){
                        var property = document.getElementById('btn_upVote_'+post_id);
                        property.style.removeProperty('color');
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.color = "orangered"
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    } else{
                        var property = document.getElementById('btn_downVote_'+post_id);
                        property.style.removeProperty('color');
                        $('#vote_count_'+post_id).text(data.voteNumber);
                    }
                }
            });
        };
    </script>
@endsection